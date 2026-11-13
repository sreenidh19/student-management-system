# Student Management System – Mini Project Report

## 1. Introduction
The Student Management System is a responsive web application designed to organize student information and attendance records in one place. An administrator can maintain student profiles and record daily attendance through a browser.

## 2. Problem Statement
Manual student record and attendance management can take time and may lead to errors. A centralized web application helps store, search, update and review these records more consistently.

## 3. Objectives
- Develop a responsive and user-friendly student management website.
- Provide administrator login and session-based access.
- Perform Create, Read, Update and Delete (CRUD) operations.
- Search and filter student information.
- Record and review date-wise attendance.
- Apply validation and basic security practices.

## 4. Scope and Requirements
The system is intended for an administrator managing student records. It includes authentication, dashboard summaries, student management and attendance history.

Software: Windows, XAMPP, Apache, PHP, MySQL, phpMyAdmin, Visual Studio Code and a modern browser.

## 5. System Architecture
Browser (HTML/CSS/JavaScript) → Apache web server → PHP application → MySQL database.

The browser sends requests to PHP pages. PHP validates the input, performs prepared SQL queries and returns the resulting page. Session authentication protects administrative pages.

## 6. Database Design
### admins
- id – primary key
- name
- email – unique
- password – password hash
- created_at

### students
- id – primary key
- name
- enrollment_no – unique
- branch, semester, email, phone, gender, address
- created_at, updated_at

### attendance
- id – primary key
- student_id – foreign key referencing students.id
- attendance_date
- status – Present or Absent
- unique constraint on student_id and attendance_date

### ER diagram
```text
+------------------+          +----------------------+
|     students     | 1      M |      attendance      |
+------------------+----------+----------------------+
| PK id            |          | PK id                |
| name             |          | FK student_id        |
| enrollment_no    |          | attendance_date      |
| branch           |          | status               |
| semester         |          +----------------------+
| email            |
| phone            |
| gender           |
| address          |
+------------------+

+------------------+
|      admins      |
+------------------+
| PK id            |
| name             |
| email (unique)   |
| password_hash    |
+------------------+
```

## 7. Implementation Details
The frontend uses HTML forms, tables, CSS layouts and JavaScript interactions. PHP handles login, sessions, validation and database operations. MySQL stores administrator, student and attendance data. PDO prepared statements are used for database queries.

## 8. Screenshots to Capture
1. Admin login page
2. Dashboard with summary cards
3. Add student form
4. Student listing and search
5. Edit student form
6. Mark attendance page
7. Attendance history page
8. Database tables in phpMyAdmin

## 9. Testing
Complete the checklist in README.md and record the actual result and screenshot for each test. Do not claim a test passed until it has been performed on your computer.

## 10. Conclusion
The project demonstrates how HTML, CSS, JavaScript, PHP and MySQL can be combined to create a database-driven web application for student record and attendance management.

## 11. Future Enhancements
- Student and faculty roles
- Export attendance to CSV/PDF
- Attendance percentage reports
- Email notifications
- Online hosting with HTTPS

## 12. References
- MDN Web Docs: https://developer.mozilla.org/
- PHP Manual: https://www.php.net/manual/
- MySQL Documentation: https://dev.mysql.com/doc/
- Apache Friends: https://www.apachefriends.org/
