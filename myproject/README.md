# User Management System
Task 3 — Backend Development & Database Integration

## Technologies Used
- PHP 8.2
- MySQL
- HTML & CSS
- XAMPP (Apache + MySQL)

## Features
- User Registration with hashed passwords
- Login & Logout using Sessions
- Role Based Access (Admin / User)
- CRUD Operations (Create, Read, Update, Delete)
- Profile Management with photo upload
- Security with Prepared Statements
- Input validation and sanitization

## Database
- Database: mydb
- Tables: users, roles

## How to Run
1. Install XAMPP
2. Start Apache and MySQL
3. Import database from mydb.sql
4. Copy project to C:\xampp\htdocs\myproject
5. Open http://localhost/myproject/login.php

## Project Structure
myproject/

├── config.php        → Database connection

├── index.php         → View all users

├── add_user.php      → Add new user

├── edit_user.php     → Edit user

├── delete_user.php   → Delete user

├── register.php      → User registration

├── login.php         → User login

├── logout.php        → User logout

├── dashboard.php     → User dashboard

├── profile.php       → Profile management

├── uploads/          → Profile photos

└── README.md         → Project info

## Security Features
- Passwords hashed with password_hash()
- SQL Injection prevented with prepared statements
- XSS prevented with htmlspecialchars()
- Session based authentication
- File upload validation

## Login Credentials (Demo)
- Email: admin@gmail.com
- Password: admin123