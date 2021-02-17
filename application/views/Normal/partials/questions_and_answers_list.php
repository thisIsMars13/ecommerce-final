<?php foreach($questions_and_answers as $qa){?>
<li>
    <div>
        <span>Q</span><p><?= $qa['question'] ?><span><?= $qa['asker'] ?></span></p>
    </div>
<?php if($qa['answer'] != null or $qa['answer'] != ''){?>
    <div>
        <span>A</span><p><?= $qa['answer'] ?><span>seller</span></p>
    </div>
</li>
<?php }}?>