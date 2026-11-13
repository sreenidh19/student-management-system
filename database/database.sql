CREATE DATABASE IF NOT EXISTS student_management_system
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_management_system;

CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS students (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  enrollment_no VARCHAR(50) NOT NULL UNIQUE,
  branch VARCHAR(100) NOT NULL,
  semester TINYINT UNSIGNED NOT NULL,
  email VARCHAR(150) NULL,
  phone VARCHAR(20) NULL,
  gender ENUM('Male','Female','Other','Prefer not to say') NOT NULL DEFAULT 'Prefer not to say',
  address TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS attendance (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  attendance_date DATE NOT NULL,
  status ENUM('Present','Absent') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_student_day (student_id, attendance_date),
  CONSTRAINT fk_attendance_student FOREIGN KEY (student_id)
    REFERENCES students(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Sample student rows are included so the dashboard is not empty on first use.
INSERT IGNORE INTO students (name, enrollment_no, branch, semester, email, phone, gender, address) VALUES
('Aarav Sharma', 'DEMO001', 'CSE', 3, 'aarav@example.com', '9000000001', 'Male', 'Bengaluru'),
('Diya Reddy', 'DEMO002', 'CSE', 3, 'diya@example.com', '9000000002', 'Female', 'Bengaluru'),
('Ishaan Kumar', 'DEMO003', 'AIML', 3, 'ishaan@example.com', '9000000003', 'Male', 'Mysuru'),
('Meera Nair', 'DEMO004', 'ECE', 2, 'meera@example.com', '9000000004', 'Female', 'Bengaluru');
