<?php //last

require('Conn_accounts.php');

$sql1 = "CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    student_name VARCHAR(100) NOT NULL,
    student_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

$query1 = mysqli_query($conn,"DROP TABLE IF EXISTS students");

$sql2 = "CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(255) NOT NULL,
    teacher_email VARCHAR(255) NOT NULL,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$query2 = mysqli_query($conn,"DROP TABLE IF EXISTS teachers");

$sql3 = "CREATE TABLE admin (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_name VARCHAR(100) NOT NULL,
    admin_email VARCHAR(100) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$query3 = mysqli_query($conn,"DROP TABLE IF EXISTS admin");

$sql4 = "CREATE TABLE uploaded_images (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    image_name VARCHAR(255) NOT NULL,
    image_type VARCHAR(100) NOT NULL,
    image_data VARCHAR(255) NOT NULL
)";

$query4 = mysqli_query($conn,"DROP TABLE IF EXISTS uploaded_images");

$sql5 = "CREATE TABLE user_types (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each user type
    type_name VARCHAR(50) NOT NULL,     -- Name of the user type (e.g., Admin, Student, Teacher)
    description TEXT,                   -- Optional: Description of the user type
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Timestamp when the record was created
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  -- Timestamp when the record was last updated
)";

$query5 = mysqli_query($conn,"DROP TABLE IF EXISTS user_types");


// if ($query1 && $query2 && $query3) {
//     echo "Tables are created" ;

// }else {
//     echo "failed to create ";
// }

?>