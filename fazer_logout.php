<?php
include("header.php");
?>

<?php
require("login_util.php");
delete_cookie($dbh, $_COOKIE['autologin']);
?>

Logout feito.

<?php
  header('Location: index.php');
?>

<?php
include("footer.php");
?>
