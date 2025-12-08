<?php
session_start(); 
require_once('../private/authentication.php');

logout_user();

header('Location: index.php');
exit;
?>