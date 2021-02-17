<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="E-commerce Capstone Project">
        <meta name="author" content="Karen Marie E. Igcasan">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link href = "https://code.jquery.com/ui/1.10.4/themes/overcast/jquery-ui.css" rel="stylesheet">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/dashboard-products-style.css"/>
    </head>
    <script>
        $(document).ready(function() {
            getdata('<?= base_url() ?>admin/dashboards/products_load');
            $( "#sortable" ).sortable();
			$( "#sortable" ).disableSelection();

            $("#form-edit-dialog").dialog({
                autoOpen: false,
                title: "Edit Product"
            });
            
            $("#form-add-dialog").dialog({
                autoOpen: false,
                title: "Add new Product"
            });

            function show_hide_loader() {
                $(".loader-dialog").show(); // Show loading image
                setTimeout(function() { 
                    $(".loader-dialog").hide(); // Hide loading image
                }, 1000);
            }

            $("#table").on("click", 'button#edit', function()
            {
                getdata($(this).attr('url'))
                .then(function(){
                    $("#form-edit-dialog").dialog("open");
                    $( "#sortable" ).sortable();
                    $( "#sortable" ).disableSelection();
                })
            });

            $("nav button").on("click", function()
            {
                getdata('<?= base_url() ?>dashboards/load_add_form')
                .then(function(){
                    $("#form-add-dialog").dialog("open");
                })
            });

            $(document).on('keyup', "input.category", function()
             {
                setTimeout(function() { 
                    show_hide_loader();
                    $("input.category").attr("readonly", "true");
                }, 2000);
            });

            $(document).on('click', "button#cancel", function()
             {
                $(".form-dialog").dialog("close");
            });

            $(document).on('click', "button#preview", function()
             {
                $('#form-add-dialog #is_preview').val('1');
                $('#form-edit-dialog #is_preview').val('1');
                $(this).parent().submit()
            });

            $(document).on('click', "#close_preview", function()
             {
                $('#form-add-dialog #is_preview').val('0');
                $('#form-edit-dialog #is_preview').val('0');
                $("#previews").slideUp(100);
            });

            $(document).on('click', "button#delete, img.remove", function()
             {
                 var product = $(this).attr('title');
                if (confirm(product + " will be deleted. Click to confirm.")) {
                    getdata($(this).attr('url')).then(function(){
                        alert(product +" is now deleted.");
                    })
                }
            });

            $(document).on('click', "#category_btn", function()
            {
                $('#category_dropdown').addClass("show")
            });

            $(document).on('click', ".edit", function()
            {
                var $el = $(this).siblings('p');
                var $input = $('<input name="category" form="update_category"/>').val($el.text());
                $el.replaceWith($input)

                var save = function()
                {
                    $('#id_category').attr('value', $el.attr('data'))
                    $('#update_category').submit();
                }
                $input.one('blur', save).focus();
            });

            $(document).on('click', "[choices]", function()
            {
                $('#default_category').attr('value', $(this).attr('data'))
                $('#category_btn').text($(this).text()+'▼');
                $('#category_dropdown').removeClass('show');
            });

            $(document).on('mouseleave', '#sortable', function()
            {
                $('#organize_img').submit();
            })

            $(document).on('change keyup paste', "input[type='search']", function()
            {
                $(this).parent().submit();
            })

            $('body').on('submit', 'form', function(e)
            {
                e.preventDefault();
                var formData = new FormData($(this)[0]);
                show_hide_loader()
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (res) {
                        $.each(res, function(index, value){
                            $(`${index}`).html(value);
                        })
                        if(res['#notification'])
                        {
                            $("#notification").fadeIn(100);
                            if((res['#notification']).includes("Success"))
                            {
                                $("#form-add-dialog").dialog("close");
                                $("#form-edit-dialog").dialog("close");
                            }
                        }
                        if(res['#previews'])
                        {
                            $("#previews").slideDown(200);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        alert(textStatus);
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
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

            $(document).on('change keyup paste', "input[type='search']", function()
            {
                $("input[type='radio']").attr('value', '1')
                $("#search_products").submit();
            })

            $(document).on('change', "input[type='radio']", function()
            {
                $("#search_products").submit();
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

            $(document).on('click', "#notification #close_btn", function()
            {
                $('#notification').fadeOut(100);
            })
        });
    </script>
    <body> 
        <div class="form-dialog" id="form-edit-dialog">
        </div>
        <div class="form-dialog" id="form-add-dialog">
        </div>
        <div id="notification">
        </div>
        <div id="previews">
        </div>
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
            <div>
                <form id="search_products" action="<?= base_url() ?>dashboards/get_products_by_filter" method="post">
                    <img src='<?= base_url() ?>assets/img/magnifying_glass.png' />
                    <input type="search" name="keyword" placeholder="search by name..">
                </form>
            </div>
            <button>Add New Product</button>
        </nav>
        <table>
            <thead>
                <tr>
                    <td>Picture</td>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Inventory Count</td>
                    <td>Quantity Sold</td>
                    <td>Action</td>
                </tr>                
            </thead>
            <tbody id="table">
            </tbody>
        </table>
        <footer id ="pagination">
        </footer>
    </body>
</html>