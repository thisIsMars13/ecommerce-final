<span id="close_preview">&#10006; Close Preview</span>
<main>
    
    <div>
    <h1><?= $post['name'] ?></h1>
    <p>
        <span><i class="fas fa-star"></i></span>
        <span><i class="fas fa-star"></i></span>
        <span><i class="fas fa-star"></i></span>
        <span><i class="fas fa-star"></i></span>
        <span><i class="fas fa-star"></i></span>
        (199)
    </p>
    </div>
    <figure>
<?php if(isset($current_images) or isset($images)){?>
<?php if(isset($current_images)){
        foreach(explode(",", $current_images['img_src']) as $image){ 
        if($image != ''){ ?>
        <img class="mini-image" src="<?= base_url() ?>uploads/<?= $image ?>"/>
<?php }}}?>
<?php if(isset($images)){
        foreach($images as $image){?>
        <img class="mini-image" src="<?= $image ?>"/>
<?php }}}else{ ?>
    <img class="mini-image" src="<?= base_url() ?>/uploads/default.png"/>
<?php }?>

    </figure>
    <p><?= $post['description']?></p>
    <form>
        <span>($<?= $post['price'] ?>)</span>
        <button>Add to Cart</button>
    </form>
</main>