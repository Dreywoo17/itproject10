-- phpMyAdmin SQL Dump
-- version 5.2.1
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2025 at 06:41 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create `user_types` Table
CREATE TABLE `user_types` (
  `user_type_id` INT(11) NOT NULL AUTO_INCREMENT,  -- Primary key
  `type_name` VARCHAR(50) NOT NULL,                -- Type name (Admin, Student, Teacher)
  `description` TEXT,                              -- Description (optional)
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- When the record was created
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert Default User Types (Admin, Student, Teacher)
INSERT INTO `user_types` (`type_name`, `description`) VALUES
  ('Admin', 'Administrator with full access to the system'),
  ('Student', 'User who is enrolled in courses and can schedule appointments'),
  ('Teacher', 'User who is a teacher and can manage courses and students');

-- --------------------------------------------------------
-- Create `admin` Table
CREATE TABLE `admin` (
  `admin_id` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_name` VARCHAR(100) NOT NULL,
  `admin_email` VARCHAR(100) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `profile_image` VARCHAR(255) DEFAULT NULL,
  `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `user_type_id` INT(11),  -- Added `user_type_id` column
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_email` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `students` Table
CREATE TABLE `students` (
  `student_id` INT(11) NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(100) NOT NULL,
  `student_email` VARCHAR(100) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `profile_image` VARCHAR(255) DEFAULT NULL,
  `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `user_type_id` INT(11),  -- Added `user_type_id` column
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_email` (`student_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `teacher` Table
CREATE TABLE `teacher` (
  `teacher_id` INT(11) NOT NULL AUTO_INCREMENT,
  `teacher_name` VARCHAR(100) NOT NULL,
  `teacher_email` VARCHAR(100) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `profile_image` VARCHAR(255) DEFAULT NULL,
  `registration_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `user_type_id` INT(11),  -- Added `user_type_id` column
  PRIMARY KEY (`teacher_id`),
  UNIQUE KEY `teacher_email` (`teacher_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create `uploaded_images` Table
CREATE TABLE `uploaded_images` (
  `image_id` INT(11) NOT NULL AUTO_INCREMENT,
  `image_name` VARCHAR(255) NOT NULL,
  `image_type` VARCHAR(100) NOT NULL,
  `image_data` VARCHAR(255) NOT NULL,
  `upload_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Add Foreign Key Constraints After Table Creation
ALTER TABLE `admin`
  ADD CONSTRAINT `fk_admin_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`);

ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`);

ALTER TABLE `teacher`
  ADD CONSTRAINT `fk_teacher_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`user_type_id`);

-- --------------------------------------------------------
-- Insert Data into Tables
-- Insert into `admin` Table
INSERT INTO `admin` (`admin_name`, `admin_email`, `user_password`, `profile_image`, `registration_date`, `user_type_id`) 
VALUES ('test', 'test@g.cu.edu.ph', '$2y$10$sZzHiv5RQJkgQeuFqWyA1OSASnnXM8FNHd9uJQ8tmrHrAVVUqWXdW', NULL, '2025-04-04 15:48:28', 1);

-- Insert into `students` Table
INSERT INTO `students` (`student_name`, `student_email`, `user_password`, `profile_image`, `registration_date`, `user_type_id`) 
VALUES ('test123', 'test@g.cu.edu.ph', '$2y$10$qrXsjlrynOvk4OFbajcbeu6/OAmM2E3PueUHHa8xAMriddTOhW/1K', NULL, '2025-04-04 15:47:26', 2);

-- Insert into `teacher` Table
INSERT INTO `teacher` (`teacher_name`, `teacher_email`, `user_password`, `profile_image`, `registration_date`, `user_type_id`) 
VALUES ('test', 'test@g.cu.edu.ph', '$2y$10$vqEc7afDxf89ZggA/cg60.jm89906iVvRYTBisB9smxMq09sM2I1a', NULL, '2025-04-04 15:48:19', 3),
       ('teacher', 'teacher@g.cu.edu.ph', '$2y$10$jI0Uo2.UNNpzdkzlF2RAD.gVnrd2eLkcD2sZ87GO8NtLty1Lfkkje', NULL, '2025-04-04 16:40:31', 3);

-- --------------------------------------------------------
-- Set Auto Increment for Tables
ALTER TABLE `admin` MODIFY `admin_id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `students` MODIFY `student_id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `teacher` MODIFY `teacher_id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

COMMIT;
