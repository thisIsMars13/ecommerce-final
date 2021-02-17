

<div class="loader-dialog">
    <img src="<?= base_url() ?>assets/img/ajax-loader.gif"/>
</div>
<form id= "update_category" action="<?= base_url() ?>dashboards/update_category" method="post">
    <input id="id_category" type="hidden" name="id" value="">
</form>
<form id="organize_img" action="<?= base_url() ?>dashboards/organize_img/<?= $product['id'] ?>" method="post"></form>
<form action="<?= base_url() ?>dashboards/edit_products/<?= $product['id'] ?>" method="POST" enctype='multipart/form-data'>

    <label for="name">Name:</label>
    <input type="text" name="name" value="<?= $product['name'] ?>"/>

    <label for="name">Price:</label>
    <input type="text" name="price" value="<?= $product['price'] ?>"/>

    <label for="name">Inventory Count:</label>
    <input type="text" name="stock_count" value="<?= $product['stock_count'] ?>"/>

    <label for="description">Description:</label>
    <textarea name="description"><?= $product['description'] ?></textarea>

    <label for="categories">Categories:</label>
    <div class="dropdown">
        <button type="button" id="category_btn"><?= $product['category'] ?>▼</button>
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
    
    
    <ul id="sortable">
<?php if($product['img_src'] != '' or $product['img_src'] != null){?>
<?php   foreach(explode(",", $product['img_src']) as $image){?>
<?php       if($image != ''){?>
        <li class="ui-state-default">
            <input type="hidden" name="images[]" value="<?= $image ?>" form="organize_img">
            <img src="<?= base_url() ?>assets/img/draggable.png"/>
            <img src="<?= base_url() ?>uploads/<?= $image ?>"/>
            <img url="<?= base_url() ?>dashboards/delete_image/<?= $product['id'] ?>/<?= $image ?>" class="remove" title="<?= $image ?>" src="<?= base_url() ?>assets/img/trash-can.png"/>
        </li>
<?php   }}}   ?>

    </ul>
    <button type="button" id="cancel">Cancel</button>
    <button type="button" id="preview">Preview</button>
    <input type="submit" value="Update"/>
</form>