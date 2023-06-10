<?php
//PDOの設定
$dsn = 'mysql:host=db;dbname=craft;charset=utf8';
$user = 'root';
$password = 'root';

try {
  $dbh = new PDO($dsn, $user, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
