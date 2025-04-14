<?php
require('Conn_appointments.php'); // Ensure database connection

$query1 = "CREATE TABLE IF NOT EXISTS appointmentdb (
    ID INT(11) NOT NULL AUTO_INCREMENT,
    Student_ID VARCHAR(15) NOT NULL,
    Student_Name VARCHAR(80) NOT NULL,
    Section VARCHAR(10) NOT NULL, 
    Appointment_Date DATETIME NOT NULL, 
    Description VARCHAR(255) NOT NULL,
    Status ENUM('Pending', 'Accepted', 'Ongoing', 'Completed') DEFAULT 'Pending',
    PRIMARY KEY (ID) -- ID as the unique primary key
)";

$query_result = mysqli_query($conn, $query1);

// if ($query_result) {
//     echo "Table created successfully.";
// } else {
//     echo "Failed to create table: " . mysqli_error($conn);
// }
// ?>
