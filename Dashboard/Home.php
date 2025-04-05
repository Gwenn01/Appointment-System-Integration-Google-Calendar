<?php
require(__DIR__ . '/../Database/database.php');

if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['userid'];
$serviceOptions = [];
$upcoming = [];
$bookedSlots = [];
$selectedDate = '';

// Fetch services
$serviceResult = mysqli_query($conn, "SELECT id, service_name FROM services ORDER BY service_name ASC");
while ($row = mysqli_fetch_assoc($serviceResult)) {
    $serviceOptions[] = $row;
}

// Fetch upcoming appointment
$query = "
    SELECT a.id, s.service_name, t.slot_date, t.start_time, a.status
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN time_slots t ON a.time_slot_id = t.id
    WHERE a.user_id = ?
      AND t.slot_date >= CURDATE()
      AND a.status IN ('pending', 'confirmed')
    ORDER BY t.slot_date ASC, t.start_time ASC
    LIMIT 1
";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($row = mysqli_fetch_assoc($result)) {
    $upcoming = $row;
}

// Check booked slots
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_date'])) {
    $selectedDate = $_POST['slot_date'];
    $stmt = mysqli_prepare($conn, "SELECT start_time FROM time_slots WHERE slot_date = ? AND is_booked = 1");
    mysqli_stmt_bind_param($stmt, "s", $selectedDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[] = date("g:i A", strtotime($row['start_time']));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Appointments | Customer Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3 bg-dark text-white">
        <h4 class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['username']) ?>!</h4>
        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
            <i class="bi bi-plus-lg"></i> New Appointment
        </button>
    </header>

    <main class="p-4">
        <section>
            <h5 class="mb-3"><i class="bi bi-calendar-event"></i> Upcoming Appointment</h5>
            <?php if (!empty($upcoming)): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-clipboard-heart"></i> <?= htmlspecialchars($upcoming['service_name']) ?></h5>
                        <p class="mb-2">
                            <strong>Date:</strong> <?= htmlspecialchars($upcoming['slot_date']) ?><br>
                            <strong>Time:</strong> <?= date("g:i A", strtotime($upcoming['start_time'])) ?><br>
                            <strong>Status:</strong>
                            <span class="badge <?= $upcoming['status'] === 'confirmed' ? 'bg-success' : 'bg-warning text-dark' ?>">
                                <?= ucfirst($upcoming['status']) ?>
                            </span>
                        </p>
                        <form method="POST" action="Backend/cancel_appointment.php" onsubmit="return confirm('Cancel this appointment?');">
                            <input type="hidden" name="appointment_id" value="<?= $upcoming['id'] ?>">
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-circle"></i> Cancel</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-muted">You have no upcoming appointments.</div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Modal: Book New Appointment -->
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-calendar-plus"></i> Book an Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- Check availability form -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Select Date</label>
                            <input type="date" name="slot_date" class="form-control" id="datePicker" value="<?= htmlspecialchars($selectedDate) ?>" required>
                        </div>
                        <button type="submit" name="check_date" class="btn btn-primary mb-3 w-100">Check Availability</button>
                    </form>

                    <?php if (!empty($selectedDate)): ?>
                        <div class="alert alert-info">
                            <strong>Booked Slots on <?= htmlspecialchars($selectedDate) ?>:</strong><br>
                            <?= count($bookedSlots) > 0 ? implode(', ', $bookedSlots) : 'No slots booked yet.' ?>
                        </div>

                        <!-- Booking form -->
                        <form method="POST" action="Backend/book_appointment.php">
                            <input type="hidden" name="slot_date" value="<?= htmlspecialchars($selectedDate) ?>">

                            <div class="mb-3">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="startTime" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Service</label>
                                <select class="form-select" name="service" required>
                                    <option value="">Choose a service</option>
                                    <?php foreach ($serviceOptions as $service): ?>
                                        <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['service_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Notes (optional)</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Any special instructions..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Set Appointment</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const datePicker = document.getElementById('datePicker');
        const today = new Date().toISOString().split('T')[0];
        datePicker.min = today;

        datePicker.addEventListener('change', () => {
            const day = new Date(datePicker.value).getDay();
            if (day === 0 || day === 6) {
                alert("Appointments are only available on weekdays. Please choose another date.");
                datePicker.value = '';
            }
        });

        const startTimeInput = document.getElementById('startTime');

        const isLunchTime = (time) => time >= "12:00" && time < "13:00";

        const validateTime = (input, label) => {
            const value = input.value;
            if (isLunchTime(value)) {
                alert(`The selected ${label} falls within our lunch break (12:00 PM - 1:00 PM).`);
                input.value = "";
            }
        };

        startTimeInput?.addEventListener('change', () => validateTime(startTimeInput, "start time"));

        startTimeInput.min = "07:00";
        startTimeInput.max = "17:00";
    </script>
</body>
</html>