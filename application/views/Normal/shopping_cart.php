<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href = "https://code.jquery.com/ui/1.10.4/themes/overcast/jquery-ui.css" rel="stylesheet">
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?=base_url()?>assets/css/shopping-cart-style.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://checkout.stripe.com/checkout.js"></script>
    </head>
    <script>
        $(document).ready(function() {
            getdata('<?= base_url() ?>carts/cart_load');

            $("#message_dialog").dialog({
                autoOpen: false
            });

            $('#message_dialog').on('dialogclose', function(event) {
                if($("#message_dialog").text() == "Order has been processed!")
                {
                    location.href="<?= base_url() ?>orders/orders_history";
                }
            });

            $(document).on('click', "img", function() {
                if (confirm($(this).attr('product-name') + " will be deleted. Click to confirm.")) {
                    $(this).parent().submit();
                    alert($(this).attr('product-name')+" is now deleted.");
                }
            });

            $(document).on('submit', 'form', function()
            {
                $.post($(this).attr('action'), $(this).serialize(), function(res)
                {
                    $.each(res, function(index, value)
                    {
                        $(`#${index}`).html(value);
                    })

                    if(res.valid)
                    {
                        pay(res.total);
                    }

                    if($("#message_dialog").text() != "")
                    {
                        $("#message_dialog").dialog("open");
                    }
                });
                return false;
            })

            $(document).on('click', "button#update", function() {
                if($(this).siblings("input[type='number']").attr("readonly"))
                {
                    $(this).siblings("input[type='number']").attr("readonly", false)
                }
                else
                {
                    $(this).parent().submit()
                    return false
                }
            });
            
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

            function pay(amount)
            {
                var handler = StripeCheckout.configure({
                    key: 'pk_test_51IKafyGNDYgSC82y7s1MIqrBzzzVQgZwQCcMNj5mwDrmeStD2pniKCPT1mvVwYAThL5D9Gu3o3uLl2CgJAdcHurX00nmU2mhRv',
                    locale: 'auto',
                    token: function (token) {
                            $.ajax({
                            url:"<?php echo base_url(); ?>stripe/payment",
                            method: 'post',
                            data: { tokenId: token.id, amount: amount },
                            dataType: "json",
                            success: function( response ) {
                                $('#shipping_billing_form').append(`<input type='hidden' name='token' value='${token.id}'><input type='hidden' name='charge' value='${parseFloat(response['data'].amount / 100)}'>`);
                                $('#need_validate').attr("value", "0")
                                $('#shipping_billing_form').submit();
                            }
                        })
                    }
                });
                handler.open({
                    name: 'Stripe Payment',
                    amount: amount * 100
                });
            }
        });
    </script>
    <body>
        <header>
            <a href="<?=base_url()?>products">Dojo eCommerce</a>
            <a href="<?=base_url()?>logoff">Log off</a>
            <a href="<?= base_url() ?>profiles/settings_page">Settings</a>
            <a href="<?= base_url() ?>cart">Shopping Cart(<span id="count"></span>)</a>
        </header>  
        <a href="<?= base_url() ?>orders/orders_history">View Order History</a>
        
        <div id="message_dialog"></div>
        <section id ="products_table">
        </section>
        <form id="shipping_billing_form" action="<?= base_url() ?>orders/process_order" method="post">
        </form>
    </body>
</html>