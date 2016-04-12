<?php $this->beginContent('@app/views/layouts/main.php'); ?>

...child layout content here...
<h1> 测试镶嵌布局 </h1>

<?php if (isset($this->blocks['block3'])): ?>
    <?= $this->blocks['block3'] ?>
<?php else: ?>
    ... default content for block3 ...
<?php endif; ?>

// 记住要有以下内容以便注入
        <?= $content ?>

<?php $this->endContent(); ?>
