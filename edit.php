<?php
require_once "db.php";

$id = intval($_GET["id"] ?? 0);
if ($id <= 0) {
  header("Location: index.php");
  exit;
}

$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$student = $stmt->get_result()->fetch_assoc();

if (!$student) {
  header("Location: index.php");
  exit;
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $fullname = trim($_POST["fullname"] ?? "");
  $address = trim($_POST["address"] ?? "");

  if ($fullname === "" || $address === "") {
    $msg = "Please fill all fields.";
  } else {
    $update = $conn->prepare("UPDATE students SET fullname = ?, address = ? WHERE id = ?");
    $update->bind_param("ssi", $fullname, $address, $id);

    if ($update->execute()) {
      header("Location: index.php");
      exit;
    }
    $msg = "Update failed.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit Student</title>
</head>
<body>
  <h2>Edit Student</h2>
  <a href="index.php">Back</a>
  <br><br>

  <?php if ($msg): ?>
    <p style="color:red;"><?= $msg ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Full Name</label><br>
    <input type="text" name="fullname" value="<?= htmlspecialchars($student["fullname"]) ?>" required><br><br>

    <label>Address</label><br>
    <input type="text" name="address" value="<?= htmlspecialchars($student["address"]) ?>" required><br><br>

    <button type="submit">Update</button>
  </form>
</body>
</html>
