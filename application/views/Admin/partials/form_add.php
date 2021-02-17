<div class="loader-dialog">
    <img src="<?= base_url() ?>assets/img/ajax-loader.gif"/>
</div>
<form id= "update_category" action="<?= base_url() ?>dashboards/update_category" method="post">
    <input id="id_category" type="hidden" name="id" value="">
</form>
<form action="<?= base_url() ?>dashboards/add_products" method="POST" enctype='multipart/form-data'>
    <label for="name">Name:</label>
    <input type="text" name="name"/>

    <label for="name">Price:</label>
    <input type="text" name="price"/>

    <label for="name">Inventory Count:</label>
    <input type="text" name="stock_count"/>

    <label for="description">Description:</label>
    <textarea name="description"></textarea>
    
    <label for="categories">Categories:</label>
    <div class="dropdown">
        <button type="button" id="category_btn"><?= $categories[0]['category'] ?>▼</button>
        <div id="category_dropdown" class="dropdown-content">
<?php   foreach($categories as $category){?>
        <div>
            <p choices data="<?= $category['id'] ?>"><?= $category['category'] ?></p>
            <img class="edit" src="<?= base_url() ?>assets/img/pencil.png"/>
            <img class="remove" src="<?= base_url() ?>assets/img/trash-can.png"/>
        </div>
<?php   }?>
        </div>
    </div>

    <input id="default_category" type="hidden" name="category_id" value="1">
    <input id="is_preview" type="hidden" name="is_preview" value="0">


    <label for="new_category">or add new category:</label>
    <input type="text" name="new_category"/>

    <p>Images:</p>
    <label for="files">Upload</label>        
    <input type="file" id="files" name="files[]" multiple>
    <ul></ul>

    <button type="button" id="cancel">Cancel</button>
    <button type="button" id="preview">Preview</button>
    <input type="submit" value="Add"/>
</form>