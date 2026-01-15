<?php
require_once "db.php";

$id = intval($_GET["id"] ?? 0);

if ($id > 0) {
  $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
}

header("Location: index.php");
exit;
