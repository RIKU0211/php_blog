<?php 
  require_once("utility.php");

  $id = $_POST["delete"];

  $dbh = dbh();
  $stmt = $dbh->query("DELETE FROM tasks WHERE id = '$id'");

  header('Location: index.php');
  exit();
?>
