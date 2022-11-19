<?php
session_start();

require("db.php");

if (isset($_POST['email']) && isset($_POST['password'])) {
  try {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare('SELECT * FROM users where email = ? and password = ?');
    $stmt->execute(array($email, $password));
    if ($stmt->rowCount() == 1) {
      $user = $stmt->fetch();
      $_SESSION["user"] = $user;
      header("Location:index.php");
    }
  } catch (PDOException $e) {
    echo "Fetch failed: " . $e->getMessage();
  }
} else {
  $errors = array();
}
?>

<?php require("header.php") ?>

<!-- login form -->
<div class="container container-sm mt-5 border p-3">
  <h3 class="mb-3">Login</h3>
  <!-- default action current script -->
  <form method="post">
    <input class="form-control mb-2" placeholder="Email" name="email" type="email" required />
    <input class="form-control mb-2" placeholder="Password" name="password" type="password" required />
    <div class="mt-3">
      <input type="submit" class="btn btn-primary" value="Login" />
      <a href="http://localhost/app/register.php" class="btn btn-link">Register</a>
    </div>
  </form>
</div>

<?php require("footer.php") ?>