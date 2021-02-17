<?php  $subtotal = 0; ?>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Item</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Total</td>
        </tr>                
    </thead>
    <tbody>
<?php foreach($data as $datum){ ?>
<?php    $subtotal += $datum['quantity'] * $datum['product_price'] ?>
        <tr>
            <td><?= $datum['product_id'] ?></td>
            <td><?= $datum['product_name'] ?></td>
            <td>$<?= $datum['product_price'] ?></td>
            <td><?= $datum['quantity'] ?></td>
            <td>$<?= $datum['quantity'] * $datum['product_price'] ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>
<p>Status: <?= $data[0]['status'] ?></p>
<div>
    <p>Subtotal: $<?= $subtotal ?></p>
    <p>Shipping: $1.00</p>
    <p>Total Price: $<?= $subtotal + 1 ?></p>
</div>