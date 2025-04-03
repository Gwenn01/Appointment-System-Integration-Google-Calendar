<?php
require(__DIR__ . '/../Database/database.php');

if (!isset($_SESSION['userid'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['userid'];
$upcoming = [];
$bookedSlots = [];
$selectedDate = '';

// Fetch upcoming appointment
if ($user_id) {
    $query = "
        SELECT 
            a.id,
            s.service_name,
            t.slot_date,
            t.start_time,
            t.end_time,
            a.status
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
}

// Check booked slots if a date is selected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_date'])) {
    $selectedDate = $_POST['slot_date'];

    $stmt = mysqli_prepare($conn, "SELECT start_time, end_time FROM time_slots WHERE slot_date = ? AND is_booked = TRUE");
    mysqli_stmt_bind_param($stmt, "s", $selectedDate);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $bookedSlots[] = date("g:i A", strtotime($row['start_time'])) . " - " . date("g:i A", strtotime($row['end_time']));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div>
        <header class="d-flex justify-content-between align-items-center p-3 bg-dark text-white">
            <h1>Welcome, <span id="customerName">Customer</span>!</h1>
            <button id="newAppointmentBtn" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                <i class="bi bi-plus-lg"></i> New Appointment
            </button>
        </header>

        <section class="appointments p-4">
            <h2><i class="bi bi-calendar-event"></i> Upcoming Appointments</h2>
            <div class="appointment-list">
                <?php if (!empty($upcoming)): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="bi bi-clipboard-heart"></i> <?= htmlspecialchars($upcoming['service_name']) ?></h5>
                            <p class="card-text">
                                <strong>Date:</strong> <?= htmlspecialchars($upcoming['slot_date']) ?><br>
                                <strong>Time:</strong>
                                <?= date("g:i A", strtotime($upcoming['start_time'])) ?>
                                to
                                <?= date("g:i A", strtotime($upcoming['end_time'])) ?><br>
                                <strong>Status:</strong>
                                <span class="badge <?= $upcoming['status'] == 'confirmed' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?= ucfirst($upcoming['status']) ?>
                                </span>
                            </p>
                            <form method="POST" action="Backend/cancel_appointment.php" onsubmit="return confirm('Cancel this appointment?');">
                                <input type="hidden" name="appointment_id" value="<?= $upcoming['id'] ?>">
                                <button class="btn btn-sm btn-outline-danger" type="submit">
                                    <i class="bi bi-x-circle"></i> Cancel Appointment
                                </button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No upcoming appointments.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <!-- New Appointment Modal -->
    <div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newAppointmentModalLabel"><i class="bi bi-calendar-plus"></i> Book an Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Check Booked Slots Form -->
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Select Date</label>
                            <input 
                                type="date" 
                                name="slot_date" 
                                class="form-control" 
                                id="datePicker"
                                value="<?= htmlspecialchars($selectedDate ?? '') ?>" 
                                required
                            >
                        </div>
                        <button type="submit" name="check_date" class="btn btn-primary mb-3">Check Availability</button>
                    </form>

                    <?php if (!empty($selectedDate)): ?>
                        <div class="alert alert-info">
                            <strong>Booked Time Slots for <?= htmlspecialchars($selectedDate) ?>:</strong><br>
                            <?= count($bookedSlots) > 0 ? implode(', ', $bookedSlots) : "No slots booked for this date." ?>
                        </div>

                        <!-- Final Appointment Booking Form -->
                        <form action="Backend/book_appointment.php" method="POST">
                            <input type="hidden" name="slot_date" value="<?= htmlspecialchars($selectedDate) ?>">

                            <div class="mb-3">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="start_time" id="startTime" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" name="end_time" id="endTime" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service Type</label>
                                <select class="form-select" name="service" required>
                                    <option value="">Choose a service</option>
                                    <option value="Dental Checkup">Dental Checkup</option>
                                    <option value="General Consultation">General Consultation</option>
                                    <!-- You can fetch these dynamically if needed -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Optional.."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Set Appointment</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // date
        const datePicker = document.getElementById('datePicker');
        const today = new Date().toISOString().split('T')[0];
        datePicker.min = today;

        // Prevent selecting weekends
        datePicker.addEventListener('input', function () {
            const selectedDate = new Date(this.value);
            const day = selectedDate.getDay();
            if (day === 0 || day === 6) {
                alert("Appointments are not available on weekends. Please select a weekday.");
                this.value = '';
            }
        });
        // time
        const startTimeInput = document.getElementById('startTime');
            const endTimeInput = document.getElementById('endTime');

            // Set allowed time range
            startTimeInput.min = "07:00";
            startTimeInput.max = "17:00";
            endTimeInput.min = "07:00";
            endTimeInput.max = "17:00";

            function isLunchTime(time) {
                return time >= "12:00" && time < "13:00";
            }

            function validateTime(input, label) {
                const time = input.value;
                if (isLunchTime(time)) {
                    alert(`The selected ${label} falls within lunch break (12:00 PM to 1:00 PM). Please choose another time.`);
                    input.value = "";
                }
            }

            startTimeInput.addEventListener('change', () => {
                validateTime(startTimeInput, "start time");
            });

            endTimeInput.addEventListener('change', () => {
                validateTime(endTimeInput, "end time");
            });
    </script>
</body>
</html>
