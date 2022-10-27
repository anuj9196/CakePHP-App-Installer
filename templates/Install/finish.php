<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="mt-4 p-3 bg-light rounded">
    <h2><?= __('Installation complete!') ?></h2>
</div>


<div class="row my-3">
    <div class="text-center">
        <p class="text-success"><?= __('Your database has been correctly installed, you can now configure your website') ?></p>
        <?= $this->Html->link(__('Go to Website') . ' <span class="glyphicon glyphicon-menu-right"></span>', '/', ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </div>
</div>
