<?php
    $pagination = ceil($pagination / 18);
    if($pagination == 0)
    {
        $pagination = 1;
    }
?>

<?php for($i = 1; $i <= $pagination; $i++){?>
<li>
    <input type="radio" name="pagination" value = "<?= $i ?>" form ="search_form" id = "<?= $i ?>" hidden <?= ($curr_page == $i) ? "checked" : null  ?>>
    <label for="<?= $i ?>"><?= $i ?></label>
</li>
<?php }?>