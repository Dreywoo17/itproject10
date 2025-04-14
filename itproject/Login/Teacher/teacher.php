<?php
session_start();

require 'C:\xampp\htdocs\itproject\DBconnect\Conn_appointments.php';

// Fetch all appointments with their statuses
$sql = "SELECT Student_Name, Section, Appointment_Date, Student_ID, Description, Status FROM appointmentdb";
$statement = $conn->prepare($sql);
$statement->execute();
$result = $statement->get_result();

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

// Handle status changes (Accept, Cancel, Complete)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $appointment_id = $_GET['id'];
    $action = $_GET['action'];

    // Update the status in the database
    $status = '';
    if ($action === 'accept') {
        $status = 'Ongoing';
    } elseif ($action === 'cancel') {
        $status = 'Cancelled';
    } elseif ($action === 'complete') {
        $status = 'Completed';
    }

    // Update appointment status in the database
    $update_sql = "UPDATE appointmentdb SET Status = ? WHERE Student_ID = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param('si', $status, $appointment_id);

    if ($update_stmt->execute()) {
        header("Location: teacher.php");
        exit();
    } else {
        exit("Error updating status: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/itproject/Login/Asset/addappoint.css">
    <link rel="stylesheet" href="/itproject/Login/Asset/viewappoint.css">
    <link rel="stylesheet" href="/itproject/Login/Asset/teacher.css">

   
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
                <li class="nav-item"><a class="nav-link btn btn-danger text-white" href="../login.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Dashboard Content -->
<div class="container mt-5 bg-semi-transparent">
    <h2 class="mb-3 text-center">Manage Appointments</h2>

    <!-- Pending Appointments -->
    <h4>Pending Appointments</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Student ID</th>
                    <th>Date & Time</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()):
                    if ($row['Status'] === 'Pending'): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Section']); ?></td>
                            <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Appointment_Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Description']); ?></td>
                            <td>
                                <a href="teacher.php?action=accept&id=<?php echo $row['Student_ID']; ?>" class="btn btn-success btn-sm">Accept</a>
                                <a href="teacher.php?action=cancel&id=<?php echo $row['Student_ID']; ?>" class="btn btn-danger btn-sm">Cancel</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Ongoing Appointments -->
    <h4 class="mt-4">Ongoing Appointments</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Student ID</th>
                    <th>Date & Time</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($result, 0);  // Reset result pointer
                while ($row = $result->fetch_assoc()):
                    if ($row['Status'] === 'Ongoing'): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Section']); ?></td>
                            <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Appointment_Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Description']); ?></td>
                            <td>
                                <a href="teacher.php?action=complete&id=<?php echo $row['Student_ID']; ?>" class="btn btn-primary btn-sm">Complete</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Completed Appointments -->
    <h4 class="mt-4">Completed Appointments</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Section</th>
                    <th>Student ID</th>
                    <th>Date & Time</th>
                    <th>Description</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                mysqli_data_seek($result, 0);  // Reset result pointer again
                while ($row = $result->fetch_assoc()):
                    if ($row['Status'] === 'Completed'): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                            <td><?php echo htmlspecialchars($row['Section']); ?></td>
                            <td><?php echo htmlspecialchars($row['Student_ID']); ?></td>
                            <td><?php echo htmlspecialchars($row['Appointment_Date']); ?></td>
                            <td><?php echo htmlspecialchars($row['Description']); ?></td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                    <?php endif; ?>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
