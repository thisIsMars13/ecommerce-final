<?php   foreach($tables as $table){?>
<tr>
    <td><img src="<?= base_url()?>uploads/<?= explode(",", $table['img_src'])[0] ?>"></td>
    <td><?= $table['id'] ?></td>
    <td><?= $table['name'] ?></td>
    <td><?= $table['stock_count'] ?></td>
    <td><?= $table['sold_count'] ?></td>
    <td> 
        <button url = "<?= base_url() ?>dashboards/load_edit_form/<?= $table['id'] ?>" id="edit">edit</button>
        <button id="delete" title="<?= $table['name'] ?>" url="<?= base_url() ?>dashboards/delete_product/<?= $table['id'] ?>">delete</a>
    </td>
</tr>
<?php   }?>