<?php 
    $count = 0;
?>
<table>
    <thead>
        <tr>
            <td>Item</td>
            <td>Price</td>
            <td>Quantity</td>
            <td>Total</td>
        </tr>                
    </thead>
    <tbody >
    <?php foreach($products as $product){?>
<?php       $count += $product['price'] * $product['quantity'] ?> 
<tr>
    <td><?= $product['name'] ?></td>
    <td>$<?= $product['price'] ?></td>
    <td>
        <form action="<?= base_url() ?>carts/update_quantity" method="post">
            <input type="hidden" name="carts_id" value="<?= $product['id'] ?>">
            <input type="number" min="1" max="<?= $product['stock_count'] ?>" value="<?= $product['quantity'] ?>" name="quantity" readonly/>
            <button clicks="0" type="button" id="update">update</button>
        </form>
        <form action="<?= base_url() ?>carts/delete" method="post">
            <input type="hidden" name="carts_id" value="<?= $product['id'] ?>">
            <img product-name="<?= $product['name'] ?>" src="<?= base_url() ?>assets/img/trash-can.png"/>
        </form>
    </td>
    <td>$<?= $product['price'] * $product['quantity'] ?></td>
</tr>
<?php }?>
    </tbody>
</table>
<p>Total: $<?= $count ?></p>
<button type="button" onclick="location.href='<?=base_url()?>products';">Continue Shopping</button>