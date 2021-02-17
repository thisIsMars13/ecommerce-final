<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/order-history-style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function()
            {
                getdata('<?= base_url()?>orders/orders_history_load');
                async function getdata(data)
                {
                    await $.get(data, function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`${index}`).html(value);
                        })
                    }, "json");
                }

                $(document).on('submit', 'form', function()
                {
                    $.post($(this).attr('action'), $(this).serialize(), function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`${index}`).html(value);
                        })
                    });
                    return false;
                })

                $(document).on("click", "#review_button", function()
                {
                    getdata($(this).attr("url"))
                    .then(function()
                    {
                        $("#leave_review").fadeIn(200);
                    })
                })

                $(document).on('click', "#done_review", function(e)
                {
                    
                    $("#leave_review").fadeOut();
                    
                })
                
                $(document).on("click", ".rating label", function()
                {
                    $(this).text("★").nextAll().text("★")
                    $(this).prevAll().text("☆")
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
        <div id="leave_review">
        </div>
        <h3>ORDER HISTORY</h3>  
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Shipped to</td>
                    <td>Date</td>
                    <td>Billing Address</td>
                    <td>Total</td>
                    <td>Status Order</td>
                    <td></td>
                </tr>                
            </thead>
            <tbody>
            </tbody>
        </table>
    </body>
</html>