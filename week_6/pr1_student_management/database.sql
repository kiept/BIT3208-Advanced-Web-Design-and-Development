-- Student Management System Database
CREATE TABLE IF NOT EXISTS students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    enrollment_date DATE,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO students (first_name, last_name, email, phone, enrollment_date, status) VALUES
('John', 'Doe', 'john.doe@university.com', '+1234567890', '2024-01-15', 'active'),
('Jane', 'Smith', 'jane.smith@university.com', '+1234567891', '2024-02-20', 'active'),
('Robert', 'Johnson', 'robert.j@university.com', '+1234567892', '2024-01-10', 'active');
