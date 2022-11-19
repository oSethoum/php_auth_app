<?php
require("db.php");

if (
  isset($_POST['first_name']) &&
  isset($_POST["last_name"]) &&
  isset($_POST["email"]) &&
  isset($_POST["address"]) &&
  isset($_POST["phone"]) &&
  isset($_POST["birthday"]) &&
  isset($_POST["password"]) &&
  isset($_POST["password_confirm"])
) {

  $errors = array();
  // validate the data and fill the error array
  if ($_POST["password"] != $_POST["password_confirm"]) {
    $errors["password_confirm"] = "Password doesn't match";
  } else {
    try {
      $stmt = $conn->prepare("INSERT INTO users(first_name,last_name,email,address,phone,birthday,password) values(?,?,?,?,?,?,?)");
      $stmt->execute(
        array(
          $_POST['first_name'],
          $_POST["last_name"],
          $_POST["email"],
          $_POST["address"],
          $_POST["phone"],
          $_POST["birthday"],
          hash(hash_algos()[0], $_POST["password"]),
        )
      );

      echo "success";
      header("Location:login.php", false);
    } catch (PDOException $e) {
      echo "Register Error" . $e->getMessage();
    }
  }
} else {
  // destroy errors if they exist
  $errors = array();
}

?>
<?php require("header.php") ?>

<!-- register form -->
<div class="container container-sm mt-5 border p-3">
  <h3 class="mb-3">Register</h3>
  <?php
  if (isset($errors["password_confirm"])) {
    echo "Password doesn't match";
  }
  ?>
  <form method="post">
    <input class="form-control mb-2" name="first_name" placeholder="First Name" type="text" required />
    <input class="form-control mb-2" name="last_name" placeholder="Last Name" type="text" required />
    <input class="form-control mb-2" name="email" placeholder="Email" type="email" required />
    <input class="form-control mb-2" name="address" placeholder="Address" type="text" required maxlength="200" />
    <input class="form-control mb-2" name="phone" placeholder="Phone" type="tel" required />
    <input class="form-control mb-2" name="birthday" placeholder="Birthday" type="date" required />
    <input class="form-control mb-2" name="password" placeholder="Passowrd" type="password" required />
    <input class="form-control mb-2" name="password_confirm" placeholder="Confirm Passowrd" type="password" required />

    <div class="mt-3">
      <input type="submit" class="btn btn-primary" value="Register" />
      <a href="http://localhost/app/login.php" class="btn btn-link">Login</a>
    </div>
  </form>
</div>


<?php require("footer.php") ?>