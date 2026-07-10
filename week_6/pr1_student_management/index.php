<?php
include 'db.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'view';

if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $enrollment_date = trim($_POST['enrollment_date'] ?? '');

    // Basic validation
    if ($first_name === '' || $last_name === '' || $email === '' || $enrollment_date === '') {
        $error_msg = 'Please fill required fields.';
    } else {
        $stmt = $conn->prepare("INSERT INTO students (first_name, last_name, email, phone, enrollment_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $first_name, $last_name, $email, $phone, $enrollment_date);
        if ($stmt->execute()) {
            $success_msg = "Student added successfully!";
        } else {
            $error_msg = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

if ($action == 'edit' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = intval($_POST['student_id'] ?? 0);
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $enrollment_date = trim($_POST['enrollment_date'] ?? '');
    $status = trim($_POST['status'] ?? 'active');

    if ($student_id <= 0) {
        $error_msg = 'Invalid student id.';
    } else {
        $stmt = $conn->prepare("UPDATE students SET first_name=?, last_name=?, email=?, phone=?, enrollment_date=?, status=? WHERE student_id=?");
        $stmt->bind_param('ssssssi', $first_name, $last_name, $email, $phone, $enrollment_date, $status, $student_id);
        if ($stmt->execute()) {
            $success_msg = "Student updated successfully!";
            $action = 'view';
        } else {
            $error_msg = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

if ($action == 'delete' && isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    if ($student_id > 0) {
        $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
        $stmt->bind_param('i', $student_id);
        if ($stmt->execute()) {
            $success_msg = "Student deleted successfully!";
            $action = 'view';
        } else {
            $error_msg = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error_msg = 'Invalid student id.';
    }
}

// Fetch student for editing
$edit_student = null;
if ($action == 'edit' && isset($_GET['id'])) {
    $student_id = intval($_GET['id']);
    if ($student_id > 0) {
        $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ? LIMIT 1");
        $stmt->bind_param('i', $student_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $edit_student = $res->fetch_assoc();
        $stmt->close();
    }
}

// Fetch all students
$students = [];
if ($action == 'view' || $action == 'edit' || $action == 'delete') {
    $result = $conn->query("SELECT * FROM students ORDER BY student_id DESC");
    $students = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        .content {
            padding: 30px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: none;
        }
        
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }
        
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }
        
        .nav-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .nav-buttons a, .nav-buttons button {
            padding: 10px 20px;
            background-color: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s;
        }
        
        .nav-buttons a:hover, .nav-buttons button:hover {
            background-color: #764ba2;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="tel"]:focus,
        input[type="date"]:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.5);
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }
        
        .form-actions button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-submit {
            background-color: #667eea;
            color: white;
        }
        
        .btn-submit:hover {
            background-color: #764ba2;
        }
        
        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }
        
        .btn-cancel:hover {
            background-color: #5a6268;
        }
        
        .table-responsive {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }
        
        table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
        }
        
        table td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .action-buttons a, .action-buttons button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9em;
            transition: opacity 0.3s;
        }
        
        .btn-edit {
            background-color: #ffc107;
            color: #333;
        }
        
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        
        .action-buttons a:hover, .action-buttons button:hover {
            opacity: 0.8;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        
        .badge.active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge.inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .form-section {
            display: none;
        }
        
        .form-section.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1> Student Management System</h1>
            <p>Manage student information with ease</p>
        </div>
        
        <div class="content">
            <?php if (isset($success_msg)): ?>
                <div class="alert success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_msg)): ?>
                <div class="alert error"><?php echo $error_msg; ?></div>
            <?php endif; ?>
            
            <div class="nav-buttons">
                <a href="index.php?action=view">View Students</a>
                <a href="index.php?action=add">Add New Student</a>
            </div>
            
            <!-- Add/Edit Form -->
            <?php if ($action == 'add' || $action == 'edit'): ?>
            <div class="form-section active">
                <h2><?php echo $action == 'add' ? 'Add New Student' : 'Edit Student'; ?></h2>
                <form method="POST" action="index.php?action=<?php echo $action; ?>">
                    <?php if ($action == 'edit' && $edit_student): ?>
                        <input type="hidden" name="student_id" value="<?php echo $edit_student['student_id']; ?>">
                    <?php endif; ?>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required 
                                   value="<?php echo $edit_student ? $edit_student['first_name'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required
                                   value="<?php echo $edit_student ? $edit_student['last_name'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required
                                   value="<?php echo $edit_student ? $edit_student['email'] : ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone"
                                   value="<?php echo $edit_student ? $edit_student['phone'] : ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="enrollment_date">Enrollment Date</label>
                            <input type="date" id="enrollment_date" name="enrollment_date" required
                                   value="<?php echo $edit_student ? $edit_student['enrollment_date'] : ''; ?>">
                        </div>
                        <?php if ($action == 'edit'): ?>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                <option value="active" <?php echo ($edit_student['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="inactive" <?php echo ($edit_student['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <?php echo $action == 'add' ? 'Add Student' : 'Update Student'; ?>
                        </button>
                        <a href="index.php?action=view" class="btn-cancel" style="padding: 12px; text-align: center;">Cancel</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>
            
            <!-- View Students Table -->
            <?php if ($action == 'view' || $action == 'delete'): ?>
            <div class="form-section active">
                <h2>All Students</h2>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Enrollment Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                            <tr>
                                <td>#<?php echo $student['student_id']; ?></td>
                                <td><?php echo htmlspecialchars($student['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($student['email']); ?></td>
                                <td><?php echo htmlspecialchars($student['phone'] ?? '-'); ?></td>
                                <td><?php echo $student['enrollment_date']; ?></td>
                                <td>
                                    <span class="badge <?php echo $student['status']; ?>">
                                        <?php echo ucfirst($student['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="index.php?action=edit&id=<?php echo $student['student_id']; ?>" class="btn-edit">Edit</a>
                                        <a href="index.php?action=delete&id=<?php echo $student['student_id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
