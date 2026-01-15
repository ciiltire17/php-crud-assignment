<?php
require_once "db.php";
$result = $conn->query("SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Students CRUD</title>
</head>
<body>
  <h2>Students List</h2>
  <a href="create.php">+ Add Student</a>
  <br><br>

  <table border="1" cellpadding="10">
    <tr>
      <th>ID</th>
      <th>Full Name</th>
      <th>Address</th>
      <th>Actions</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row["id"] ?></td>
          <td><?= htmlspecialchars($row["fullname"]) ?></td>
          <td><?= htmlspecialchars($row["address"]) ?></td>
          <td>
            <a href="edit.php?id=<?= $row["id"] ?>">Edit</a> |
            <a href="delete.php?id=<?= $row["id"] ?>" onclick="return confirm('Delete this student?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4">No students yet.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
