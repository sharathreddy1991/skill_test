<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="../assets/style.css">
<h1>Dashboard!</h1>

<?php

if ($_SESSION['logged_in_user_id'] ) {
    echo "Employee ID: " . $_SESSION['logged_in_user_id'] . " is logged in!";
}