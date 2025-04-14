<?php
// Start session to check if the user is an admin
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'Admin') {
    // Redirect to login if not logged in or not an admin
    header("Location: /itproject/Login/login.php");
    exit();
}

// Include the database connection
include('C:/xampp/htdocs/itproject/DBconnect/Conn_accounts.php'); // Ensure this is your actual connection file

// SQL Query: Separate queries for students, teachers, and admins
$students_query = "SELECT * FROM students";
$teachers_query = "SELECT * FROM teacher";
$admins_query = "SELECT * FROM admin";

// Execute queries for students, teachers, and admins
$students_result = $conn->query($students_query);
$teachers_result = $conn->query($teachers_query);
$admins_result = $conn->query($admins_query);

// Check if the queries were successful
if (!$students_result || !$teachers_result || !$admins_result) {
    die("Error: " . $conn->error);  // Handle any query errors
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="viewadmin.css" rel="stylesheet">
    <style>
        /* Additional custom styles if needed */
        table img {
            border-radius: 50%;
        }
        .table-dark {
            background-color: #343a40;
            color: white;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
        <a class="navbar-brand" href="#">
            <img src="../img/Alogo1.jpg" alt="Logo" width="30" height="30"> Appointment Scheduling
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-white" href="\itproject\Admin\registration.php">Create Account</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/itproject/aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="/itproject/Login/login.php">Log in</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <!-- Students Table -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th colspan="4" class="table-dark">Students</th></tr>
                    <?php while ($student = $students_result->fetch_assoc()) { ?>
                        <tr>
                            <td>Student</td>
                            <td>
                                <img src="<?= $student['profile_image'] ? $student['profile_image'] : 'default-avatar.jpg' ?>" alt="Profile Image" width="50" height="50">
                                <?= htmlspecialchars($student['student_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($student['student_email']) ?></td>
                            <td>
                                <a href="/itproject/Admin/Process/edit.php?id=<?= $student['student_id'] ?>&type=student" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/itproject/Admin/Process/delete.php?id=<?= $student['student_id'] ?>&type=student" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Teachers Table -->
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th colspan="4" class="table-dark">Teachers</th></tr>
                    <?php while ($teacher = $teachers_result->fetch_assoc()) { ?>
                        <tr>
                            <td>Teacher</td>
                            <td>
                                <img src="<?= $teacher['profile_image'] ? $teacher['profile_image'] : 'default-avatar.jpg' ?>" alt="Profile Image" width="50" height="50">
                                <?= htmlspecialchars($teacher['teacher_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($teacher['teacher_email']) ?></td>
                            <td>
                                <a href="/itproject/Admin/Process/edit.php?id=<?= $teacher['teacher_id'] ?>&type=teacher" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/itproject/Admin/Process/delete.php?id=<?= $teacher['teacher_id'] ?>&type=teacher" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Admins Table -->
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><th colspan="4" class="table-dark">Admins</th></tr>
                    <?php while ($admin = $admins_result->fetch_assoc()) { ?>
                        <tr>
                            <td>Admin</td>
                            <td>
                                <img src="<?= $admin['profile_image'] ? $admin['profile_image'] : 'default-avatar.jpg' ?>" alt="Profile Image" width="50" height="50">
                                <?= htmlspecialchars($admin['admin_name']) ?>
                            </td>
                            <td><?= htmlspecialchars($admin['admin_email']) ?></td>
                            <td>
                                <a href="/itproject/Admin/Process/edit.php?id=<?= $admin['admin_id'] ?>&type=admin" class="btn btn-primary btn-sm">Edit</a>
                                <a href="/itproject/Admin/Process/delete.php?id=<?= $admin['admin_id'] ?>&type=admin" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    

</body>
</html>

<?php
// Close the DB connection
$conn->close();
?>
