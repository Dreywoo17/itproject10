<?php
session_start();
require 'C:\xampp\htdocs\itproject\DBconnect\Conn_appointments.php';

//  Checking if action and id are set in the URL
if (isset($_GET['action']) && isset($_GET['id'])) {
    $appointment_id = (int) $_GET['id']; 
    $action = $_GET['action'];

   // Validating the action
    $Vstatus = ['cancel' => 'Cancelled', 'ongoing' => 'Ongoing'];

    if (array_key_exists($action, $Vstatus)) {
        $status = $Vstatus [$action];

         // Prepare and execute the SQL statement to update the appointment status also to prevent SQL injection
        $statement = $conn->prepare("UPDATE appointmentdb SET Status = ? WHERE Student_ID = ?");
        $statement->bind_param("si", $status, $appointment_id);


        // Check if the statement executed successfully
        if ($statement->execute()) {
            header("Location: viewappoint.php");
            exit();
        } else {
            exit("Failed to update status: " . $statement->error);
        }
    }
}

// Fetching all appointments from the database
$sql = "SELECT Student_Name, Section, Appointment_Date, Student_ID, Description, Status FROM appointmentdb";
$result = mysqli_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
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
    <link rel="stylesheet" href="/itproject/Login/Asset/addappoint.css">
    <link rel="stylesheet" href="/itproject/Login/Asset/viewappoint.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img class="logo me-2" src="../../img/Alogo1.jpg" alt="Logo">
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
                            <td><?= htmlspecialchars($row['Student_Name']); ?></td>
                            <td><?= htmlspecialchars($row['Section']); ?></td>
                            <td><?= htmlspecialchars($row['Student_ID']); ?></td>
                            <td><?= htmlspecialchars($row['Appointment_Date']); ?></td>
                            <td><?= htmlspecialchars($row['Description']); ?></td>
                            <td><?= htmlspecialchars($row['Status'] ?? 'Pending'); ?></td>
                            <td>
                                <?php if ($row['Status'] == 'Pending'): ?>
                                    <a href="viewappoint.php?action=cancel&id=<?= $row['Student_ID']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                                <?php elseif ($row['Status'] == 'Accepted'): ?>
                                    <a href="viewappoint.php?action=ongoing&id=<?= $row['Student_ID']; ?>" class="btn btn-warning btn-sm">Ongoing</a>
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
        <a href="addappoint.php" class="btn btn-danger mt-3">Back</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
