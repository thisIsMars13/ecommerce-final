<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/order-details-style.css"/>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function()
            {
                getdata('<?= base_url()?>dashboards/order_details_load/<?= $id ?>');
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
                    })
                    return false;
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
        <summary>         
        </summary>
        <section>
        </section>
    </body>
</html>