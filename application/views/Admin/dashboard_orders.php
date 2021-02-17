<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/dashboard-orders-style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function()
            {
                getdata('<?= base_url()?>dashboards/orders_load');
                
                $(document).on('submit', 'form', function()
                {
                    $.post($(this).attr('action'), $(this).serialize(), function(res)
                    {
                        $.each(res, function(index, value)
                        {
                            $(`${index}`).html(value);
                        })
                    })
                    return false;
                })

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

                $(document).on("change", "select", function()
                {
                    $(this).parent().submit();
                })

                $(document).on('change keyup paste', "input[type='search'], #select_search", function()
                {
                    $("input[type='radio']").attr('value', '1')
                    $("#search_orders").submit();
                })

                $(document).on('change', "input[type='radio']", function()
                {
                    $("#search_orders").submit();
                })

                $('#question_notif').click(function(){
                    getdata("<?= base_url()?>dashboards/load_questions")
                    .then(function()
                    {
                        $("#customer_questions").fadeIn(200);
                    })
                    
                })

                $(document).on('click', "#customer_questions, #close_modal", function(e)
                {
                    if(e.target.id == "customer_questions" || e.target.id == "close_modal")
                    {
                        $("#customer_questions").fadeOut();
                    }
                })
            });
        </script>
    </head>
    <body>
        <header>
            <h2>Dashboard</h2>
            <a href="<?= base_url() ?>dashboards/orders">Orders</a>
            <a href="<?= base_url() ?>dashboards/products/1">Products</a>
            <a id="question_notif">Customer Questions</a>
            <a href="<?= base_url() ?>logoff">Logoff</a>
        </header>
        <div id="customer_questions">
        </div>  
        <nav>
            <form id="search_orders" action="<?= base_url() ?>dashboards/get_orders_by_filter" method="post"></form>
            <div>
                <img src='<?= base_url() ?>assets/img/magnifying_glass.png' />
                <input form="search_orders" type="search" name="keyword" placeholder="search by name..">
            </div>
            <select id="select_search" form="search_orders" name="status">
                <option value="all" selected>Show All</option>
                <option value="1">Order in process</option>
                <option value="2">Shipped</option>
                <option value="3">Cancelled</option>
            </select>
        </nav>
        <table>
            <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Name</td>
                    <td>Date</td>
                    <td>Billing Address</td>
                    <td>Total</td>
                    <td>Status Order</td>
                </tr>                
            </thead>
            <tbody>
            </tbody>
        </table>
        <footer>
        </footer>
    </body>
</html>