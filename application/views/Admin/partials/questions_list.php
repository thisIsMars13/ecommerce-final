<?php foreach($questions as $question){?>
        <li>
            <p>Product ID: <?= $question['product_id'] ?></p>
            <p>Product Name: <?= $question['name'] ?></p>
            <p><span>Q</span><?= $question['question'] ?></p>
            <form action="<?= base_url() ?>dashboards/answer/<?= $question['id'] ?>" method="post">
                <textarea name="answer"></textarea>
                <input type="submit" value="Answer">
            </form>
        </li>
<?php }?>