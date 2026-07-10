<?php
include 'db.php';
$action = $_GET['action'] ?? 'view';

if ($action=='add' && $_SERVER['REQUEST_METHOD']=='POST'){
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if ($title=='') $error = 'Title required.';
    else{
        $stmt = $conn->prepare('INSERT INTO books (title,author,category) VALUES (?,?,?)');
        $stmt->bind_param('sss',$title,$author,$category);
        if ($stmt->execute()) $success='Book added.'; else $error='DB error: '.$stmt->error;
        $stmt->close();
    }
}

if ($action=='edit' && $_SERVER['REQUEST_METHOD']=='POST'){
    $id = intval($_POST['book_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $category = trim($_POST['category'] ?? '');
    if ($id>0){
        $stmt = $conn->prepare('UPDATE books SET title=?,author=?,category=? WHERE book_id=?');
        $stmt->bind_param('sssi',$title,$author,$category,$id);
        if ($stmt->execute()) $success='Book updated.'; else $error='DB error: '.$stmt->error;
        $stmt->close();
    } else $error='Invalid id.';
}

if ($action=='delete' && isset($_GET['id'])){
    $id = intval($_GET['id']);
    if ($id>0){
        $stmt = $conn->prepare('DELETE FROM books WHERE book_id=?');
        $stmt->bind_param('i',$id);
        if ($stmt->execute()) $success='Book deleted.'; else $error='DB error: '.$stmt->error;
        $stmt->close();
    }
}

$q = trim($_GET['q'] ?? '');
$books = [];
$sql = "SELECT * FROM books";
if ($q!==''){
    $like = '%'.$q.'%';
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ? OR category LIKE ? ORDER BY book_id DESC");
    $stmt->bind_param('sss',$like,$like,$like);
    $stmt->execute();
    $res = $stmt->get_result();
    $books = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $res = $conn->query("SELECT * FROM books ORDER BY book_id DESC");
    $books = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

$edit = null;
if ($action=='edit' && isset($_GET['id'])){
    $id = intval($_GET['id']);
    $stmt = $conn->prepare('SELECT * FROM books WHERE book_id=? LIMIT 1');
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $res = $stmt->get_result();
    $edit = $res->fetch_assoc();
    $stmt->close();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Library Book Management</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <main class="container">
    <h1>Library Book Management</h1>
    <?php if (!empty($success)): ?><div class="alert success"><?php echo $success;?></div><?php endif;?>
    <?php if (!empty($error)): ?><div class="alert error"><?php echo $error;?></div><?php endif;?>

    <form method="get" class="search-form"><input name="q" placeholder="Search title/author/category" value="<?php echo htmlspecialchars($q); ?>"><button type="submit">Search</button></form>

    <div class="nav"><a href="index.php?action=view">View</a> <a href="index.php?action=add">Add New</a></div>

    <?php if ($action=='add' || ($action=='edit' && $edit)): ?>
    <section class="form-box">
      <h2><?php echo $action=='add' ? 'Add Book' : 'Edit Book'; ?></h2>
      <form method="post" action="index.php?action=<?php echo $action; ?>">
        <?php if ($action=='edit'): ?><input type="hidden" name="book_id" value="<?php echo $edit['book_id'];?>"><?php endif;?>
        <label>Title<br><input name="title" required value="<?php echo $edit ? htmlspecialchars($edit['title']) : ''; ?>"></label>
        <label>Author<br><input name="author" value="<?php echo $edit ? htmlspecialchars($edit['author']) : ''; ?>"></label>
        <label>Category<br><input name="category" value="<?php echo $edit ? htmlspecialchars($edit['category']) : ''; ?>"></label>
        <button type="submit"><?php echo $action=='add' ? 'Add' : 'Update'; ?></button>
      </form>
    </section>
    <?php endif; ?>

    <section class="table">
      <h2>Books</h2>
      <table>
        <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Actions</th></tr></thead>
        <tbody>
        <?php foreach($books as $b): ?>
          <tr>
            <td><?php echo $b['book_id']; ?></td>
            <td><?php echo htmlspecialchars($b['title']); ?></td>
            <td><?php echo htmlspecialchars($b['author']); ?></td>
            <td><?php echo htmlspecialchars($b['category']); ?></td>
            <td><a href="index.php?action=edit&id=<?php echo $b['book_id'];?>">Edit</a> | <a href="index.php?action=delete&id=<?php echo $b['book_id'];?>" onclick="return confirm('Delete?')">Delete</a></td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
