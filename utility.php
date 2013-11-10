<?php
  function dbh(){
    try{
    return new PDO("mysql:dbname=php_blog", "root", "");
    }catch(PDOException $e){
      echo $e->getMessage();
      exit();
    }
  }

  function h($s){
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }

  function setToken(){
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION["token"] = $token;
  }

  function checkToken(){
    if(empty($_SESSION["token"]) || $_SESSION["token"] != $_POST["token"]){
      echo "token error";
      exit();
    }
  }

  function emailExists($email, $dbh){
    $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(":email" => $email));
    $user = $stmt->fetch();

    return $user ? true : false;
  }

  function getSha1Password($s){
    return sha1($s);
  }

  function getUser($dbh, $name, $password){
    $sql = "SELECT * FROM users WHERE name = :name AND password = :password LIMIT 1";
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(":name" => $name, ":password" => getSha1Password($password)));
    $user = $stmt->fetch();
    
    return $user ? true : false;
  }
?>
