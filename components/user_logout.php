<?php
// Include the database connection file
include 'components/connect.php';

// Start the session to access session variables
session_start();

// Unset all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect the user to the homepage or login page
header('Location: ../home.php');
exit;
