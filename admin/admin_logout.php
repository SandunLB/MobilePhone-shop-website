<?php
session_start();
$_SESSION = [];
session_destroy();
header("Location: admin_login.php");
exit();
?>
