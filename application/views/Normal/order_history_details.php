<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/order-history-details-style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function()
            {
                getdata('<?= base_url()?>orders/order_details_load/<?= $id ?>');
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
        <summary>            
        </summary>
        <section>
        </section>
    </body>
</html>