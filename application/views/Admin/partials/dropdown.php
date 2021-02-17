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