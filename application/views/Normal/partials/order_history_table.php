<?php foreach($data as $datum){?>
<tr>
    <td><a href="<?= base_url() ?>orders/order_details/<?= $datum['id'] ?>"><?= $datum['id'] ?></a></td>
    <td><?= $datum['first_name']. ' ' . $datum['last_name'] ?></td>
    <td><?= $datum['created_at'] ?></td>
    <td><?= $datum['address1']. ', ' . $datum['address2'] . ', ' . $datum['city'] . ', ' . $datum['state'] . ', ' . $datum['zipcode']?></td>
    <td>$<?= $datum['total'] ?></td>
    <td><?= $datum['status'] ?></td>
<?php if($datum['status'] == "Shipped"){?>
<?php if($datum['is_review'] == "0"){?>
    <td><button id = "review_button" url = "<?= base_url() ?>orders/load_form_review/<?= $datum['id'] ?>">Leave a Review</button></td>
<?php } else{?>
    <td><span>Reviewed</span></td>
<?php }?>
<?php } else { ?>
    <td></td> 
<?php }?>
</tr>

<?php }?>