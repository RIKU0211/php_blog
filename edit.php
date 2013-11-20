<?php
  require_once("utility.php");

  $dbh = dbh();

  if(@$_POST["edit"]){
    $id = $_POST["edit"];
  }

  if(@$_POST["submit"]){
    $stmt = $dbh->prepare("UPDATE tasks SET title = :title, body = :body, created_at = NOW() WHERE id = :id");
    $params = array();
