# Student Management System

A beginner-friendly student records and attendance web application built with HTML, CSS, JavaScript, Core PHP and MySQL.

## Requirements
- Windows computer
- XAMPP (Apache and MySQL)
- Web browser
- Optional: Visual Studio Code

## Installation using XAMPP
1. Install XAMPP from https://www.apachefriends.org/.
2. Open XAMPP Control Panel.
3. Click **Start** beside Apache and MySQL.
4. Extract the project folder into `C:\xampp\htdocs\`.
5. Confirm the folder path is `C:\xampp\htdocs\student-management-system\`.
6. Open `http://localhost/phpmyadmin/`.
7. Select **Import**, choose `database/database.sql` from this project, and click **Go**.
8. Open `config/database.php`. The default XAMPP settings are host `localhost`, user `root`, password empty, and database `student_management_system`. If you configured a MySQL password, enter it there.
9. Visit `http://localhost/student-management-system/`.
10. On first launch, choose **Create the first admin account**. This option is available only while the admins table is empty.
11. Log in using the admin email and password you just created.

## Main modules
- Admin registration (first admin only), login and logout
- Dashboard statistics from MySQL
- Add, list, search and filter students
- Edit and delete student records
- Mark attendance by date
- Attendance history and date filter

## Demo data
The SQL file inserts four clearly labelled demo student records (DEMO001–DEMO004). Delete or edit these records before presenting if your faculty expects only your own data.

## Troubleshooting
- **Apache does not start:** another program may be using port 80/443. Check XAMPP's port settings.
- **MySQL does not start:** check whether another MySQL service is already running.
- **Database connection failed:** make sure MySQL is running and the settings in `config/database.php` match your XAMPP setup.
- **404 page:** confirm the folder is named exactly `student-management-system` inside `C:\xampp\htdocs`.
- **CSS not loading:** open the project using the localhost URL, not by double-clicking a PHP file.

## Security and learning notes
- Passwords are stored using PHP `password_hash()` and checked with `password_verify()`.
- Database queries use PDO prepared statements.
- Form submissions use a session CSRF token.
- Output is escaped with `htmlspecialchars()`.
- This is a local college demonstration project. Before public deployment, add HTTPS, stronger operational security, backups, role management and production configuration.

## Testing checklist
- [ ] Create the first admin account
- [ ] Log in and log out
- [ ] Check dashboard counts
- [ ] Add a student
- [ ] Search by name and enrollment number
- [ ] Filter by branch and semester
- [ ] Edit a student
- [ ] Delete a demo student
- [ ] Mark Present/Absent for a date
- [ ] Save attendance again for the same date and verify it updates rather than duplicates
- [ ] View attendance history
- [ ] Test on a narrow/mobile browser width

## Project report checklist
Include: introduction, problem statement, objectives, scope, requirements, architecture, ER diagram, database design, implementation details, screenshots, testing table, conclusion, future enhancements and references.

## ER relationship
`students (1) ---- (many) attendance`

An admin account is stored separately in `admins`. Each attendance row belongs to one student. The unique key on `(student_id, attendance_date)` prevents duplicate attendance for the same student on the same date.
