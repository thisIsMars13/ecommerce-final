<h2>Similar Items</h2>
<?php foreach($related as $product){?>
<figure>
    <a href="<?= base_url() ?>products/show/<?= $product['id'] ?>">
        <img src="<?= base_url() ?>uploads/<?= explode(",",$product['img_src'] )[0] ?>"/>
        <p>$<?= $product['price'] ?></p>
        <figcaption><?= $product['name'] ?></figcaption>
    </a>
</figure>
<?php }?>