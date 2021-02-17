<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/landing_page.css">
</head>
<body>
    <nav>
        <ul>
            <li><h2>TEST App</h2></li>
            <li><a href="<?= base_url() ?>" class="active">Home</a></li>
        </ul>
        <a href="signin">Signin</a>
    </nav>
    <div id="container">
        <div>
            <h1>Welcome to the Test</h1>
            <p>Were going to build a cool application using MVC framwork! This application was built with the Village88 folks!</p>
            <a href="signin">Start</a>
        </div>
        <ul>
            <li>
                <h4>Manage Users</h4>
                <p>Using this application, you'll learn how to add, remove and edit users for the application</p>
            </li>
            <li>
                <h4>Leave Messages</h4>
                <p>Users will be able to leave a message to another user using this application</p>
            </li>
            <li>
                <h4>Edit User Information</h4>
                <p>Admins will be able to edit another user's information (email address, first name, last name, etc)</p>
            </li>
        </ul>
    </div>
</body>
</html>