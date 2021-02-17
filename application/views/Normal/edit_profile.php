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
        <link href = "https://code.jquery.com/ui/1.10.4/themes/overcast/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>        
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/edit-profile-style.css"/>
        <script>
            $(document).ready(function() {
                $("#message-dialog").dialog({
                    autoOpen: false
                });

                load_data('<?= base_url() ?>profiles/settings_page_load');
                
                $(document).on('submit', 'form', function()
                {
                    $.post($(this).attr('action'), $(this).serialize(), function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                        $("#message-dialog").dialog("open");
                    })
                    $(this).trigger("reset");
                    return false;
                })
                
                function load_data(url)
                {
                    $.get(url, function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                    }, "json")
                }
            });
        </script>
    </head>
    <body>
        <header>
            <a href="<?=base_url()?>products">Dojo eCommerce</a>
            <a href="<?=base_url()?>logoff">Log off</a>
            <a href="<?= base_url() ?>profiles/settings_page">Settings</a>
            <a href="<?= base_url() ?>cart">Shopping Cart(<span id="count"></span>)</a>
        </header>  
        <div id="message-dialog">
        </div>
        <fieldset>            
            <legend>Edit Password</legend>
            <form action="<?= base_url() ?>profiles/update_password" method="POST">
                <label for="old_password">Old Password:</label>
                <input type="password" name="old_password" />
    
                <label for="password">New Password:</label>
                <input type="password" name="password" />
    
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password" name="confirm_password" />

                <input type="submit" message="Password successfully updated!" value="Save">
            </form>
        </fieldset>

        <fieldset>
            <legend>Edit Default Shipping</legend>
            <form id="shipping_form" action="<?= base_url() ?>profiles/update_default_shipping" method="POST">
            </form>
        </fieldset>

        <fieldset>
            <legend>Edit Default Billing</legend>
            <form id="billing_form" action="<?= base_url() ?>profiles/update_default_billing" method="POST">
            </form>
        </fieldset>

    </body>
</html>