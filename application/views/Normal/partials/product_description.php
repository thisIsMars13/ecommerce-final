<a href="<?= base_url() ?>products">Go Back</a>
<div>
    <h1><?= $main['name'] ?></h1>
    <p>
<?php for($i = 1; $i <= 5; $i++){
        if($reviews[1] != null and $i <= $reviews[1][0]){?>
        <span><i class="fas fa-star"></i></span>
<?php  }elseif($reviews[1] != null and $i == ($reviews[1][0] + 1) and ($reviews[1][1] * 100) > 49){ ?>
        <span><i class="fas fa-star-half-alt"></i></span>
<?php }else{ ?>
        <span><i class="far fa-star"></i></span>
<?php }}?>
    (<?= count($reviews[0]) ?>)
    </p>
</div>
<figure>
<?php if(count(explode(",", $main['img_src'] )) > 1){?>
<?php foreach(explode(",", $main['img_src'] ) as $image ){?>
<?php   if($image != ''){?>
    <img class="mini-image" src="<?= base_url()?>uploads/<?= $image ?>"/>
<?php }?>
<?php }}?>
</figure>
<p><?= $main['description']?></p>
<form action="<?=base_url()?>products/add_cart" method="post">
    <span orig-price="<?= $main['price'] ?>">($<?= $main['price'] ?>)</span>
    <input type="hidden" name="product_id" value="<?= $main['id'] ?>">
    <input type="number" name="quantity" value="1" min="1" max="<?=$main['stock_count']?>">
    <input type="submit" <?= ($main['stock_count'] < 1) ? "class='no_stock' value='Out of stock'" : "value ='Add to Cart'" ?>/>
</form>
<em>Item added to the cart!</em>