-- ====================================================================
-- CAMPUS CONNECT: A COLLEGE EVENT MANAGEMENT AND PARTICIPATION SYSTEM
-- Mini Project: U21CS503 - Web Technology
-- Department of Computer Science and Engineering
-- KPR Institute of Engineering and Technology (KPRIET), Coimbatore
-- Student: PRASANNAVENKATESH B (Reg No: 24CS152)
-- Database: campus_connect (MySQL / MariaDB on XAMPP)
-- ====================================================================

-- 1. Create and select the database
CREATE DATABASE IF NOT EXISTS `campus_connect` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `campus_connect`;

-- Disable foreign key checks during schema creation
SET FOREIGN_KEY_CHECKS = 0;

-- 2. Drop existing tables if re-importing
DROP TABLE IF EXISTS `REGISTRATION`;
DROP TABLE IF EXISTS `EVENT`;
DROP TABLE IF EXISTS `ADMIN`;
DROP TABLE IF EXISTS `STUDENT`;

SET FOREIGN_KEY_CHECKS = 1;

-- ====================================================================
-- TABLE 1: STUDENT
-- Stores registered students who can browse and register for events
-- ====================================================================
CREATE TABLE `STUDENT` (
  `student_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `register_number` VARCHAR(30) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `department` VARCHAR(100) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- TABLE 2: ADMIN
-- Stores authorized college/department administrators
-- ====================================================================
CREATE TABLE `ADMIN` (
  `admin_id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'admin',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- TABLE 3: EVENT
-- Stores technical events, symposiums, workshops, coding contests
-- ====================================================================
CREATE TABLE `EVENT` (
  `event_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(150) NOT NULL,
  `category` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `event_date` DATE NOT NULL,
  `event_time` VARCHAR(30) DEFAULT '09:30 AM - 04:30 PM',
  `venue` VARCHAR(150) NOT NULL,
  `eligibility` VARCHAR(150) DEFAULT 'All B.E. / B.Tech Students',
  `seats` VARCHAR(50) DEFAULT 'Limited (First-Come Basis)',
  `publication_status` ENUM('Draft', 'Published', 'Closed') DEFAULT 'Draft',
  `created_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX (`category`),
  INDEX (`event_date`),
  INDEX (`publication_status`),
  CONSTRAINT `fk_event_admin` FOREIGN KEY (`created_by`) REFERENCES `ADMIN` (`admin_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- TABLE 4: REGISTRATION
-- Connects a student to an event. Unique constraint prevents duplicates
-- Status: 'Registered', 'Pending review', 'Confirmed'
-- ====================================================================
CREATE TABLE `REGISTRATION` (
  `registration_id` INT AUTO_INCREMENT PRIMARY KEY,
  `student_id` INT NOT NULL,
  `event_id` INT NOT NULL,
  `registration_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('Registered', 'Pending review', 'Confirmed') DEFAULT 'Registered',
  `remarks` VARCHAR(255) DEFAULT 'Registration received successfully',
  INDEX (`student_id`),
  INDEX (`event_id`),
  INDEX (`status`),
  CONSTRAINT `fk_reg_student` FOREIGN KEY (`student_id`) REFERENCES `STUDENT` (`student_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_reg_event` FOREIGN KEY (`event_id`) REFERENCES `EVENT` (`event_id`) ON DELETE CASCADE,
  CONSTRAINT `unique_student_event` UNIQUE (`student_id`, `event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- SEED DATA: Realistic Initial Records
-- ====================================================================

-- Default Admin Account:
-- Username: admin
-- Password: Admin@123
INSERT INTO `ADMIN` (`admin_id`, `username`, `email`, `password_hash`, `role`) VALUES
(1, 'admin', 'admin@kpriet.ac.in', '$2y$10$Ei.y1TY8F0GIld2qUBII.eudsmc.y8GsOm7.bceq7jzbxDz.MmiB.', 'Administrator');

-- Sample Students:
-- Student 1: student@kpriet.ac.in / Student@123 (PRASANNAVENKATESH B)
-- Student 2: aarthi.k@kpriet.ac.in / Student@123 (Aarthi K)
-- Student 3: dinesh.m@kpriet.ac.in / Student@123 (Dinesh M)
INSERT INTO `STUDENT` (`student_id`, `name`, `register_number`, `email`, `department`, `password_hash`) VALUES
(1, 'PRASANNAVENKATESH B', '24CS152', 'student@kpriet.ac.in', 'Computer Science and Engineering', '$2y$10$qk1STqglWXJi.1YBT3JWUO7xOQ655cfD39D4A9uL4rV2Duz9aXfA6'),
(2, 'Aarthi K', '24CS101', 'aarthi.k@kpriet.ac.in', 'Computer Science and Engineering', '$2y$10$qk1STqglWXJi.1YBT3JWUO7xOQ655cfD39D4A9uL4rV2Duz9aXfA6'),
(3, 'Dinesh M', '24IT045', 'dinesh.m@kpriet.ac.in', 'Information Technology', '$2y$10$qk1STqglWXJi.1YBT3JWUO7xOQ655cfD39D4A9uL4rV2Duz9aXfA6');

-- Sample Events (matching Chapter 4 Project Report Screenshots):
INSERT INTO `EVENT` (`event_id`, `title`, `category`, `description`, `event_date`, `event_time`, `venue`, `eligibility`, `seats`, `publication_status`, `created_by`) VALUES
(1, 'Technovation 2026', 'Symposium', 'Annual National Level Technical Symposium organized by the Department of CSE. Features Paper Presentation, Project Expo, Web Design, and Technical Quiz with exciting cash prizes and certificates.', '2026-11-12', '09:00 AM - 04:30 PM', 'Main Auditorium', 'All Engineering Departments (UG/PG)', 'Limited (Sample display)', 'Published', 1),
(2, 'Code Sprint', 'Competition', 'A fast-paced 3-round competitive programming and algorithm optimization contest. Test your speed and efficiency in C++, Java, and Python on real-world problem sets.', '2026-11-18', '10:00 AM - 01:00 PM', 'Computing Lab 2', 'Open to all CSE, IT, AI-DS Students', '60 Participants', 'Published', 1),
(3, 'Design Arena', 'Workshop', 'Hands-on interactive masterclass on UI/UX Design, Wireframing, and Design Systems using modern industry prototyping tools and design thinking frameworks.', '2026-11-22', '09:30 AM - 03:30 PM', 'CAD/Design Studio 3', 'Open to all registered college students', '40 Participants', 'Published', 1),
(4, 'Data Day', 'Seminar', 'An intensive expert seminar on Applied Data Analytics, Big Data Pipelines, and Machine Learning applications in modern industry by guest speakers.', '2026-11-25', '02:00 PM - 05:00 PM', 'Seminar Hall 1', 'Open to 2nd, 3rd, and Final Year students', '120 Seats', 'Published', 1),
(5, 'Hack-A-Thon 24H', 'Hackathon', 'Non-stop 24-hour innovation hackathon to build scalable smart campus and healthcare solutions. Mentorship provided by tech leaders.', '2026-12-05', '09:00 AM (24 Hours)', 'Innovation Center', 'Teams of 3-4 students from any dept', '25 Teams', 'Published', 1),
(6, 'RoboWars 2026', 'Robotics', 'Department of Mechatronics and CSE autonomous combat robotics arena battle. Robots will compete under standard weight categories.', '2026-12-10', '10:00 AM - 04:00 PM', 'Indoor Sports Complex', 'Engineering students with valid bots', '16 Teams', 'Draft', 1);

-- Sample Registrations (matching Chapter 4 Figure 4.6 My Registrations):
-- Prasannavenkatesh registered for Technovation (Registered), Code Sprint (Pending review), Design Arena (Confirmed)
INSERT INTO `REGISTRATION` (`registration_id`, `student_id`, `event_id`, `registration_time`, `status`, `remarks`) VALUES
(1, 1, 1, '2026-11-01 10:15:00', 'Registered', 'Slot reserved, pending desk verification'),
(2, 1, 2, '2026-11-02 11:30:00', 'Pending review', 'Lab workstation assignment in progress'),
(3, 1, 3, '2026-11-02 14:45:00', 'Confirmed', 'Participation confirmed. Seat #14 allocated'),
(4, 2, 1, '2026-11-03 09:10:00', 'Confirmed', 'Confirmed for Paper Presentation'),
(5, 2, 4, '2026-11-03 16:20:00', 'Registered', 'Seminar ticket issued'),
(6, 3, 2, '2026-11-04 08:50:00', 'Registered', 'Registered for Round 1');
