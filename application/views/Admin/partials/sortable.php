<?php if($sortable['img_src'] != '' or $sortable['img_src'] != null){?>
<?php   foreach(explode(",", $sortable['img_src']) as $image){?>
    <?php       if($image != ''){?>
        <li class="ui-state-default">
            <input type="hidden" name="images[]" value="<?= $image ?>" form="organize_img">
            <img src="<?= base_url() ?>assets/img/draggable.png"/>
            <img src="<?= base_url() ?>uploads/<?= $image ?>"/>
            <img url="<?= base_url() ?>dashboards/delete_image/<?= $sortable['id'] ?>/<?= $image ?>" class="remove" title="<?= $image ?>" src="<?= base_url() ?>assets/img/trash-can.png"/>
        </li>
<?php   }}}   ?>