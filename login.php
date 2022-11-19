<?php
session_start();
if (isset($_SESSION["user"]))
  header("Location:index.php");

require("db.php");

if (isset($_POST['email']) && isset($_POST['password'])) {
  try {
    $stmt = $conn->prepare('SELECT * FROM users where email = ? and password = ?');
    // hash algo has to be the same with register
    $stmt->execute(array($_POST['email'], hash(hash_algos()[0], $_POST['password'])));

    if ($stmt->rowCount() == 1) {
      // login success
      $user = $stmt->fetch();
      $_SESSION["user"] = $user;
      header("Location:index.php");
    } else {
      $errors["email_or_password"] = "<b>Email or Password</b> Incorrect";
    }

  } catch (PDOException $e) {
    echo "Fetch failed: " . $e->getMessage();
  }

} else {
  // destory errors if they exist
  $errors = array();
}
?>

<?php require("header.php") ?>

<!-- login form -->
<div class="container container-sm mt-5 border p-3">
  <h3 class="mb-3">Login</h3>

  <!-- Errors -->
  <ul class="alert alert-danger <?php if (count($errors) == 0) {
    echo "d-none"; // in case of no error hide this alert
  } ?>" role="alert">
    <?php
    foreach ($errors as $key => $value) {
      echo `<li class="ml-2">` . $value . `</li>`;
    }
    ?>
  </ul>

  <!-- default action current php file -->
  <form method="post">
    <input value="<?php if (isset($_POST["email"]))
      echo $_POST["email"] ?>" class="form-control mb-2" placeholder="Email" name="email" type="email" required />
    <input value="<?php if (isset($_POST["password"]))
      echo $_POST["password"] ?>" class="form-control mb-2" placeholder="Password" name="password" type="password"
      required />
    <div class="mt-3">
      <input type="submit" class="btn btn-primary" value="Login" />
      <a href="register.php" class="btn btn-link">Register</a>
    </div>
  </form>
</div>

<?php require("footer.php") ?>