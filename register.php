<?php

session_start();
if (isset($_SESSION["user"]))
  header("Location:index.php");

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
    $errors["password_confirm"] = "<b>Password</b> doesn't match";
  }

  if (strlen($_POST["first_name"]) > 50) {
    $errors["first_name"] = "<b>First Name</b> must be less than 50 letters";
  }

  if (strlen($_POST["last_name"]) > 50) {
    $errors["last_name"] = "<b>Last Name</b> must be less than 50 letters";
  }

  if (strlen($_POST["phone"]) != 10) {
    $errors["phone"] = "<b>Phone</b> must be 10 numbers";
  }

  if (strlen($_POST["address"]) > 200) {
    $errors["address"] = "<b>Address</b> must be less than 200 letters";
  }

  if (count($errors) == 0) {
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
  <ul class="alert alert-danger <?php if (count($errors) == 0) {
    echo "d-none";
  } ?>" role="alert">
    <?php
    foreach ($errors as $key => $value) {
      echo `<li class="ml-2">` . $value . `</li>`;
    }
    ?>
  </ul>
  <form method="post">
    <input value="<?php if (isset($_POST["first_name"]))
      echo $_POST["first_name"] ?>" class="form-control mb-2" name="first_name" placeholder="First Name" type="text"
      required />
    <input value="<?php if (isset($_POST["last_name"]))
      echo $_POST["last_name"] ?>" class="form-control mb-2" name="last_name" placeholder="Last Name" type="text"
      required />
    <input value="<?php if (isset($_POST["email"]))
      echo $_POST["email"] ?>" class="form-control mb-2" name="email" placeholder="Email" type="email" required />
    <input value="<?php if (isset($_POST["address"]))
      echo $_POST["address"] ?>" class="form-control mb-2" name="address" placeholder="Address" type="text" required
      maxlength="200" />
    <input value="<?php if (isset($_POST["phone"]))
      echo $_POST["phone"] ?>" class="form-control mb-2" name="phone" placeholder="Phone" type="tel" required />
    <input value="<?php if (isset($_POST["birthday"]))
      echo $_POST["birthday"] ?>" class="form-control mb-2" name="birthday" placeholder="Birthday" type="date"
      required />
    <input value="<?php if (isset($_POST["password"]))
      echo $_POST["password"] ?>" class="form-control mb-2" name="password" placeholder="Passowrd" type="password"
      required />
    <input value="<?php if (isset($_POST["password_confirm"]))
      echo $_POST["password_confirm"] ?>" class="form-control mb-2" name="password_confirm"
      placeholder="Confirm Passowrd" type="password" required />

    <div class="mt-3">
      <input type="submit" class="btn btn-primary" value="Register" />
      <a href="login.php" class="btn btn-link">Login</a>
    </div>
  </form>
</div>


<?php require("footer.php") ?>