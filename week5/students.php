<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getPDO();
$action = $_GET['action'] ?? '';
if ($action === 'delete' && !empty($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM students WHERE id = :id');
    $stmt->execute([':id'=>$_GET['id']]);
    header('Location: students.php'); exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $reg = trim($_POST['reg_no'] ?? '');
    $email = trim($_POST['email'] ?? '');
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare('UPDATE students SET name=:n,reg_no=:r,email=:e WHERE id=:id');
        $stmt->execute([':n'=>$name,':r'=>$reg,':e'=>$email,':id'=>$_POST['id']]);
    } else {
        $stmt = $pdo->prepare('INSERT INTO students (name,reg_no,email) VALUES (:n,:r,:e)');
        $stmt->execute([':n'=>$name,':r'=>$reg,':e'=>$email]);
    }
    header('Location: students.php'); exit;
}
$students = $pdo->query('SELECT * FROM students ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Students CRUD</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Students</h1>
    <section>
      <h2>Add / Edit Student</h2>
      <form method="post">
        <input type="hidden" name="id" id="sid">
        <label>Name<br><input name="name" id="sname" required></label>
        <label>Reg No<br><input name="reg_no" id="sreg"></label>
        <label>Email<br><input name="email" id="semail" type="email"></label>
        <button type="submit">Save</button>
      </form>
    </section>

    <section>
      <h2>All Students</h2>
      <table border="1" cellpadding="6" cellspacing="0">
        <thead><tr><th>ID</th><th>Name</th><th>Reg</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($students as $s): ?>
          <tr>
            <td><?php echo $s['id']; ?></td>
            <td><?php echo htmlspecialchars($s['name']); ?></td>
            <td><?php echo htmlspecialchars($s['reg_no']); ?></td>
            <td><?php echo htmlspecialchars($s['email']); ?></td>
            <td>
              <a href="#" onclick="edit(<?php echo $s['id']; ?>,'<?php echo addslashes($s['name']); ?>','<?php echo addslashes($s['reg_no']); ?>','<?php echo addslashes($s['email']); ?>')">Edit</a>
              | <a href="?action=delete&id=<?php echo $s['id']; ?>" onclick="return confirm('Delete?')">Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script>
    function edit(id,name,reg,email){
      document.getElementById('sid').value=id;
      document.getElementById('sname').value=name;
      document.getElementById('sreg').value=reg;
      document.getElementById('semail').value=email;
      window.scrollTo(0,0);
    }
  </script>
</body>
</html>
