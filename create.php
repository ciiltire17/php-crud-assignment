<?php
require_once "db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $fullname = trim($_POST["fullname"] ?? "");
  $address = trim($_POST["address"] ?? "");

  if ($fullname === "" || $address === "") {
    $msg = "Please fill all fields.";
  } else {
    $stmt = $conn->prepare("INSERT INTO students (fullname, address) VALUES (?, ?)");
    $stmt->bind_param("ss", $fullname, $address);

    if ($stmt->execute()) {
      header("Location: index.php");
      exit;
    }
    $msg = "Insert failed.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Student</title>
</head>
<body>
  <h2>Add Student</h2>
  <a href="index.php">Back</a>
  <br><br>

  <?php if ($msg): ?>
    <p style="color:red;"><?= $msg ?></p>
  <?php endif; ?>

  <form method="post">
    <label>Full Name</label><br>
    <input type="text" name="fullname" required><br><br>

    <label>Address</label><br>
    <input type="text" name="address" required><br><br>

    <button type="submit">Save</button>
  </form>
</body>
</html>
