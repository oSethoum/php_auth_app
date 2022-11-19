<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location:login.php", false);
}

if (isset($_POST["logout"])) {
  session_destroy();
  header("Location:login.php", false);
}
?>
<?php require("header.php") ?>

<form method="post">
  <input class="btn btn-danger" name="logout" type="submit" value="logout" />
</form>
<h1>My app</h1>

<?php require("footer.php") ?>