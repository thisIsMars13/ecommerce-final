<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <link href = "https://code.jquery.com/ui/1.10.4/themes/overcast/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/product-details-style.css"/>
        <script>
            $(document).ready(function() {
                $("#image-preview-dialog").dialog({
                    autoOpen: false
                });

                $(document).on("click", "img.mini-image", function() {
                    $("#image-preview-dialog img").attr("src", $(this).attr("src"));
                    $("#image-preview-dialog").dialog("open");
                });

                $(document).on("change", "input[type='number']", function()
                {
                    originalPrice = $(this).siblings("span").attr("orig-price");
                    $(this).siblings("span").text("($"+(originalPrice*$(this).val()).toFixed(2)+")");
                })

                $(document).on('submit', 'form', function() {
                    $("main em").fadeIn(1000);
                    $("main em").fadeOut(5000);
                    $.post($(this).attr('action'), $(this).serialize(), function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                    });
                    $(this).trigger("reset");
                    return false;
                });

                getdata('<?= base_url() ?>products/show_load/<?= $id ?>')
                
                function getdata(data)
                {
                    $.get(data, function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                        
                    }, "json");
                }
            });
        </script>
    </head>
    <body>
        <div id="image-preview-dialog">
            <img src=""/>
        </div>
        <header>
            <a href="<?=base_url()?>products">Dojo eCommerce</a>
            <a href="<?=base_url()?>logoff">Log off</a>
            <a href="<?= base_url() ?>profiles/settings_page">Settings</a>
            <a href="<?= base_url() ?>cart">Shopping Cart(<span id="count"></span>)</a>
        </header>  
        <main id="product_overview">
        </main>
        <article id = "related_items">
        </article>
        <section id="questions_and_answers">
        </section>
    </body>
</html>