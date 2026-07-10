<?php
include 'db.php';
include 'includes/auth.php';
start_secure_session();
require_login();
$action = $_GET['action'] ?? 'view';

if ($action=='add' && $_SERVER['REQUEST_METHOD']=='POST'){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($name=='' || $email=='') $error='Name and email required.';
    else{
        $stmt = $conn->prepare('INSERT INTO employees (name,email,position,phone) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss',$name,$email,$position,$phone);
        if ($stmt->execute()) $success='Employee added.'; else $error='DB error: '.$stmt->error;
        $stmt->close();
    }
}

if ($action=='edit' && $_SERVER['REQUEST_METHOD']=='POST'){
    $id = intval($_POST['employee_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    if ($id>0){
        $stmt = $conn->prepare('UPDATE employees SET name=?,email=?,position=?,phone=? WHERE employee_id=?');
        $stmt->bind_param('ssssi',$name,$email,$position,$phone,$id);
        if ($stmt->execute()) $success='Employee updated.'; else $error='DB error: '.$stmt->error;
        $stmt->close();
    } else $error='Invalid id.';
}

if ($action=='delete' && isset($_GET['id'])){
    $id = intval($_GET['id']);
    if ($id>0){ $stmt=$conn->prepare('DELETE FROM employees WHERE employee_id=?'); $stmt->bind_param('i',$id); $stmt->execute(); $success='Deleted.'; $stmt->close(); }
}

$q = trim($_GET['q'] ?? '');
if ($q!==''){
    $like='%'.$q.'%';
    $stmt=$conn->prepare('SELECT * FROM employees WHERE name LIKE ? OR email LIKE ? OR position LIKE ? ORDER BY employee_id DESC');
    $stmt->bind_param('sss',$like,$like,$like);
    $stmt->execute(); $res=$stmt->get_result(); $emps=$res->fetch_all(MYSQLI_ASSOC); $stmt->close();
} else { $res = $conn->query('SELECT * FROM employees ORDER BY employee_id DESC'); $emps = $res ? $res->fetch_all(MYSQLI_ASSOC) : []; }

$edit=null; if ($action=='edit' && isset($_GET['id'])){ $id=intval($_GET['id']); $stmt=$conn->prepare('SELECT * FROM employees WHERE employee_id=? LIMIT 1'); $stmt->bind_param('i',$id); $stmt->execute(); $res=$stmt->get_result(); $edit=$res->fetch_assoc(); $stmt->close(); }
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Employee Records</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<main class="container">
  <h1>Employee Records Management</h1>
  <div style="float:right"><a href="logout.php">Logout</a></div>
  <?php if (!empty($success)): ?><div class="alert success"><?php echo $success;?></div><?php endif;?>
  <?php if (!empty($error)): ?><div class="alert error"><?php echo $error;?></div><?php endif;?>
  <form method="get" class="search-form"><input name="q" placeholder="Search name/email/position" value="<?php echo htmlspecialchars($q);?>"><button type="submit">Search</button></form>
  <div class="nav"><a href="index.php?action=view">View</a> <a href="index.php?action=add">Add New</a></div>

  <?php if ($action=='add' || ($action=='edit' && $edit)): ?>
  <section class="form-box">
    <h2><?php echo $action=='add' ? 'Add Employee' : 'Edit Employee'; ?></h2>
    <form method="post" action="index.php?action=<?php echo $action;?>">
      <?php if ($action=='edit'): ?><input type="hidden" name="employee_id" value="<?php echo $edit['employee_id'];?>"><?php endif; ?>
      <label>Name<br><input name="name" required value="<?php echo $edit?htmlspecialchars($edit['name']):'';?>"></label>
      <label>Email<br><input name="email" type="email" required value="<?php echo $edit?htmlspecialchars($edit['email']):'';?>"></label>
      <label>Position<br><input name="position" value="<?php echo $edit?htmlspecialchars($edit['position']):'';?>"></label>
      <label>Phone<br><input name="phone" value="<?php echo $edit?htmlspecialchars($edit['phone']):'';?>"></label>
      <button type="submit"><?php echo $action=='add'?'Add':'Update'; ?></button>
    </form>
  </section>
  <?php endif; ?>

  <section class="table">
    <h2>Employees</h2>
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Position</th><th>Phone</th><th>Actions</th></tr></thead>
      <tbody>
      <?php foreach($emps as $e): ?>
        <tr>
          <td data-label="ID"><?php echo $e['employee_id'];?></td>
          <td data-label="Name"><?php echo htmlspecialchars($e['name']);?></td>
          <td data-label="Email"><?php echo htmlspecialchars($e['email']);?></td>
          <td data-label="Position"><?php echo htmlspecialchars($e['position']);?></td>
          <td data-label="Phone"><?php echo htmlspecialchars($e['phone']);?></td>
          <td data-label="Actions"><a href="index.php?action=edit&id=<?php echo $e['employee_id'];?>">Edit</a> | <a href="index.php?action=delete&id=<?php echo $e['employee_id'];?>" onclick="return confirm('Delete?')">Delete</a></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>
</body>
</html>
