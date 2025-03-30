<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style/dashboard.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <?php
    require(__DIR__ . '/../Database/database.php');

    $bookedSlots = [];
    $selectedDate = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_date'])) {
        $selectedDate = $_POST['slot_date'];

        $stmt = mysqli_prepare($conn, "SELECT slot_time FROM time_slots WHERE slot_date = ? AND is_booked = TRUE");
        mysqli_stmt_bind_param($stmt, "s", $selectedDate);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $bookedSlots[] = $row['slot_time'];
        }
    }
    ?>

    <div>
        <header>
            <h1>Welcome, <span id="customerName">Customer</span>!</h1>
            <button id="newAppointmentBtn" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
                <i class="bi bi-plus-lg"></i> New Appointment
            </button>
        </header>

        <section class="appointments">
            <h2><i class="bi bi-calendar-event"></i> Upcoming Appointments</h2>
            <div class="appointment-list">
                <p>No upcoming appointments.</p>
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
                            <input type="date" name="slot_date" class="form-control" value="<?php echo htmlspecialchars($selectedDate); ?>" required>
                        </div>
                        <button type="submit" name="check_date" class="btn btn-primary mb-3">Check Availability</button>
                    </form>

                    <?php if (!empty($selectedDate)): ?>
                        <div class="alert alert-info">
                            <strong>Booked Time Slots for <?php echo htmlspecialchars($selectedDate); ?>:</strong><br>
                            <?php if (count($bookedSlots) > 0): ?>
                                <?php echo implode(', ', $bookedSlots); ?>
                            <?php else: ?>
                                No slots booked for this date.
                            <?php endif; ?>
                        </div>

                        <!-- Final Appointment Booking Form -->
                        <form action="Backend/book_appointment.php" method="POST">
                            <input type="hidden" name="slot_date" value="<?php echo htmlspecialchars($selectedDate); ?>">

                            <div class="mb-3">
                                <label class="form-label">Select Time</label>
                                <input type="time" class="form-control" name="slot_time" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Service Type</label>
                                <select class="form-select" name="service" required>
                                    <option value="">Choose a service</option>
                                    <option value="Dental Checkup">Dental Checkup</option>
                                    <option value="General Consultation">General Consultation</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <textarea class="form-control" name="notes" rows="3" placeholder="Enter any special requests..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Confirm Appointment</button>
                        </form>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
