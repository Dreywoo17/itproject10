<?php
session_start();

require 'C:\xampp\htdocs\itproject\DBconnect\Conn_appointments.php';

// Fetch appointments from database
$sql = "SELECT Student_Name, Section, Appointment_Date, Student_ID, Description FROM appointmentdb";
$result = mysqli_query($conn, $sql);

// Check for SQL errors
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// If status is updated, set it in session (you can extend this logic later to save it permanently)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    $action = $_GET['action'];

    // Save the status in the session (or in a temporary database table, as per your design)
    $_SESSION['appointment_status'][$appointment_id] = $action;

    header("Location: viewappoint.php");  // Redirect to avoid resubmission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Appointment Scheduling System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="viewappoint.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img class="logo me-2" src="../img/Alogo1.jpg" alt="Logo">
                <span class="text-white ms-2">Appointment Scheduling System</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="\itproject\aboutus.php">About Us</a></li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light text-dark" href="\itproject\Login\login.php">
                            <i class="fa-regular fa-user"></i> Log in
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Appointment Table -->
    <div class="container d-flex justify-content-center mt-4">
        <div class="container3">
            <h1>Scheduled Appointments</h1>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Student ID</th>
                        <th>Date & Time</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                                <td><?php echo htmlspecialchars($row['Section']); ?></td>
                                <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Appointment_Date']); ?></td>
                                <td><?php echo htmlspecialchars($row['Description']); ?></td>

                                <?php
                                    // Check the session status for the appointment
                                    $appointment_id = $row['Student_ID']; // Assuming Student_ID is unique for appointments
                                    $status = isset($_SESSION['appointment_status'][$appointment_id]) ? $_SESSION['appointment_status'][$appointment_id] : 'Pending';
                                ?>
                                <td><?php echo $status; ?></td>
                                <td>
                                    <?php if ($status == 'Pending'): ?>
                                        
                                        <a href="viewappoint.php?action=cancel&id=<?php echo $appointment_id; ?>" class="btn btn-danger btn-sm">Cancel</a>
                                    <?php elseif ($status == 'Accepted'): ?>
                                        <a href="viewappoint.php?action=ongoing&id=<?php echo $appointment_id; ?>" class="btn btn-warning btn-sm">Ongoing</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No appointments scheduled.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <a href="addappoint.php" class="btn btn-danger mt-3" aria-label="Go back to Admin Panel">Back</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
