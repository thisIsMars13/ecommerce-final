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
        <link rel="stylesheet" href="<?=  base_url() ?>assets/css/catalog-style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function()
            {
                getdata('<?= base_url()?>products/catalog_load');
                
                $(document).on('submit', 'form', function()
                {
                    $.post($(this).attr('action'), $(this).serialize(), function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                    });
                    return false;
                })

                async function getdata(data)
                {
                    await $.get(data, function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`#${index}`).html(value);
                        })
                        
                    }, "json");
                }

                $(document).on('change keyup paste', "form input[type='search'], form input[type='checkbox']", function()
                {
                    $("input[type='radio']").attr('value', '1')
                    $(this.form).submit();
                })
                
                $(document).on('change', "select, input[type='radio'] ", function()
                {
                    $("#search_form").submit();
                })
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
        <form id="search_form" action="<?= base_url() ?>products/search" method="POST">
            <div>
                <img src='<?= base_url() ?>assets/img/magnifying_glass.png' />
                <input type="search" name="keyword" placeholder="search">
            </div>
            <ul id="categories">
            </ul>
        </form>
        <main>
            <h2 id="current_page"></h2>
            <div>
                <label for="sorted_by">Sorted by</label>
                <select name="sorted_by" form="search_form">
                    <option value="price" selected>Price</option>
                    <option value="sold_count">Most Popular</option>
                </select>
            </div>
            <!-- Display Products -->
            <section id="section">
            </section>
            <footer>
                <ul id="pagination">
                </ul>
            </footer>
        </main>
    </body>
</html>