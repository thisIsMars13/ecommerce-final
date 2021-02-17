<?php
    $category = array();
    foreach($categories as $value)
    {
        $category[$value['category']] = array(
            'name' => $value['category'],
            'id' => $value['id'],
            'count' => '0'
        );
    }
    foreach($data as $datum)
    {
        $category[$datum['category']]['count'] = $datum['prod_count'];
    }
?>
<?php   foreach($category as $datum){    ?>
<li>
        <input type='checkbox' name='categories[]' id='<?= $datum['name']?>' value='<?= $datum['id']?>' hidden <?= in_array($datum['id'], $checked) ? 'checked' : null ?>>
        <label for='<?= $datum['name']?>'><?= $datum['name']?> (<?= $datum['count']?>)</label>
</li>
<?php   }       ?>
