<?php
require 'C:/xampp/htdocs/itproject/DBconnect/Conn_accounts.php';

$id = $_GET['id'];
$type = $_GET['type'];

switch ($type) {
    case 'student':
        $table = 'students';
        $id_col = 'student_id';
        $name_col = 'student_name';
        $email_col = 'student_email';
        $password_col = 'student_password';
        break;
    case 'teacher':
        $table = 'teacher';
        $id_col = 'teacher_id';
        $name_col = 'teacher_name';
        $email_col = 'teacher_email';
        $password_col = 'teacher_password';
        break;
    case 'admin':
        $table = 'admin';
        $id_col = 'admin_id';
        $name_col = 'admin_name';
        $email_col = 'admin_email';
        $password_col = 'admin_password';
        break;
    default:
        echo json_encode(['error' => 'Invalid type']);
        exit;
}

$stmt = $conn->prepare("SELECT $name_col, $email_col FROM $table WHERE $id_col = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

echo json_encode(['name' => $name, 'email' => $email]);
$conn->close();
