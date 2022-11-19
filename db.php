<?php
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];
$port = $_ENV['DB_PORT'];

if (!isset($conn)) {
  try {
    $conn = new PDO("mysql:host=$servername;post=$port;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
  } catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
  }
}