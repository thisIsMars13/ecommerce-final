<div>
    
    <h1>Rate Our Products</h1>
    <ul>
<?php foreach($reviews as $review){?>
        <li>
            <p>Product ID: <?= $review['products_id'] ?></p>
            <p>Product Name: <?= $review['name'] ?></p>
            <h3>Tell us about your experience</h3>
            <form class="rating_form"action="<?= base_url() ?>orders/add_review/<?= $review['order_detail_id'] ?>/<?= $review['products_id'] ?>" method="post">
                <input type="radio" name="rating" id="zero" value="0" checked>
                <input type="radio" name="rating" id="five" value="1">
                <input type="radio" name="rating" id="four" value="2">
                <input type="radio" name="rating" id="three" value="3">
                <input type="radio" name="rating" id="two" value="4">
                <input type="radio" name="rating" id="one" value="5">
                <div class="rating">
                    <label for="one">☆</label>
                    <label for="two">☆</label>
                    <label for="three">☆</label>
                    <label for="four">☆</label>
                    <label for="five">☆</label>
                </div>
                <textarea name="review"></textarea>
                <input type="submit" value="Send Review">
            </form>
        </li>
<?php } ?>
    </ul>
    <form action="<?= base_url() ?>orders/done_review/<?= $reviews[0]['order_detail_id'] ?>" method="post">
        <input id="done_review" type="submit" value="Done">
    </form>
</div>