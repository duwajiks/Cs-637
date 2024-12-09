<?php
session_start();
session_unset();
session_destroy(); 
header('Location: /movie/public/login.php');
exit;
?>
