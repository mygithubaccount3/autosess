<!DOCTYPE html>
<html>
<head>
<title>Vladyslav Honcharov 5290f86d</title>
</head>
<body>
<div class="container">
<h1>Welcome to Auto Market</h1>
<?php
    session_start();

    if(isset($_SESSION['name']) && strlen($_SESSION['name']) > 0) {
        header('Location: view.php');
    }
?>
<a href="login.php">Please Log In</a>
</div>
</body>
