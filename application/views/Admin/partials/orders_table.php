<?php foreach($tables as $table){?>
<tr>
    <td><a href="<?= base_url() ?>dashboards/order_details/<?=  $table['id'] ?>"><?=  $table['id'] ?></a></td>
    <td><?= $table['first_name'] ?></td>
    <td><?= $table['created_at'] ?></td>
    <td><?= $table['address1'] . ', ' . $table['address2'] . ', ' . $table['city']?></td>
    <td>$<?= $table['total'] ?></td>
    <td>
        <form action="<?= base_url() ?>dashboards/update_status/<?= $table['id'] ?>" method="post">
            <select name="status">
                <option value="1" <?= ($table['status_id'] == '1') ? 'selected' : null ?>>Order in process</option>
                <option value="2" <?= ($table['status_id'] == '2') ? 'selected' : null ?>>Shipped</option>
                <option value="3" <?= ($table['status_id'] == '3') ? 'selected' : null ?>>Cancelled</option>
            </select>
        </form>
    </td>
</tr>
<?php }?>