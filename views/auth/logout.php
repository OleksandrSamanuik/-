<?php
session_start(); 
session_unset(); 
session_destroy(); 
header('Location: /myshop/views/auth/login.php'); 
exit();
?>
