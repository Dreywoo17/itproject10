<?php
require 'C:/xampp/htdocs/itproject/DBconnect/Conn_accounts.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['type'])) {
    $id = $_GET['id'];  // ID of the user to delete
    $type = $_GET['type'];

    // Determine the correct table and column for deletion
    if ($type === "student") {
        $table = "students";
        $column = "student_id";
    } elseif ($type === "teacher") {
        $table = "teacher";
        $column = "teacher_id";
    } elseif ($type === "admin") {
        $table = "admin";
        $column = "admin_id";
    } else {
        die("Invalid user type.");
    }

    // Delete query with prepared statement
    $deleteQuery = "DELETE FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: viewadmin.php");
        exit();
    } else {
        echo "Error deleting record.";
    }

    $stmt->close();
    $conn->close();
}
?>

?>