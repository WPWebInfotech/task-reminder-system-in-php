### **Database Setup**

#### Create the Database and Tables
1. Open **phpMyAdmin** or your preferred MySQL interface.
2. Run the following SQL script to create the database and tables:

```sql
-- Create Database
CREATE DATABASE task_reminder;

-- Use the Database
USE task_reminder;

-- Create Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Create Tasks Table
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    task_name VARCHAR(255),
    status ENUM('pending', 'completed') DEFAULT 'pending',
    due_time DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```
