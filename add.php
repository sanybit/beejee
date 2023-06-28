<?php 
require 'db.php';

$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$text = htmlspecialchars($_POST['text']);

$sql = "INSERT INTO list(name, email, text, status) VALUES(:name, :email, :text, :status)";

$query = $pdo->prepare($sql);
  
if ($query->execute(['name' => $name, 'email' => $email, 'text' => $text, 'status' => 1])) header('Location: index.php?message=added');
else header('Location: index.php?message=error');
?>