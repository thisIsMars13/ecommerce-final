<h1>Questions about this product:</h1>
<form action="<?=base_url()?>questions/ask_question/<?= $main['id'] ?>" method="post">
    <input type="text" name="question" placholder="question here..">
    <input type="submit" value="Ask as question">
</form>
<h3>Other questions asked by customer</h3>
<ul id= "questions_and_answers_list">
<?php foreach($questions_and_answers as $qa){?>
    <li>
        <div>
            <span>Q</span><p><?= $qa['question'] ?><span><?= $qa['asker'] ?></span></p>
        </div>
<?php if($qa['answer'] != null or $qa['answer'] != ''){?>
        <div>
            <span>A</span><p><?= $qa['answer'] ?></p>
        </div>
    </li>
<?php }}?>
</ul>