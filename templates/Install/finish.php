<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="jumbotron">
    <h2><?= __('Installation complete!') ?></h2>
</div>


<div class="row">
    <div class="col-md-8 col-md-offset-2 text-center">
        <p class="text-success"><?= __('Your database has been correctly installed, you can now configure your website') ?></p>
        <?= $this->Html->link(__('Go to Website') . ' <span class="glyphicon glyphicon-menu-right"></span>', '/', ['class' => 'btn btn-primary', 'escape' => false]) ?>
    </div> <!-- .span12 -->
</div> <!-- .row -->
