<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="assets/css/login-register-style.css"/>
    </head>
    <body>
        <div class="error">
<?php   if($this->session->flashdata('error')){
            foreach($this->session->flashdata('error') as $err){    ?>
            <p><?= $err ?></p>
<?php       }
        }                                                                   ?>
        </div>
        <div class="success">
<?php   if($this->session->flashdata('success')){           ?>
            <p><?= $this->session->flashdata('success') ?></p>
<?php   }   ?>
        </div>
        <form action="<?= base_url() ?>signin_process" method="POST">  
            <h1>Login</h1>
   
            <label for="email">Email address:</label>
            <input type="text" name="email">

            <label for="password">Password:</label>
            <input type="password" name="password">
        
            <input type="submit" value="Signin">
            <a href="register">Don't have an account? Register</a>
        </form>
    </body>
</html>

