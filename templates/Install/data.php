<?php
/**
 * @var \App\View\AppView $this
 * @var mixed $database_connect
 */
?>
<div class="jumbotron">
    <h2><?= __('Database Construction') ?></h2>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2 text-center">
        <h2><?= __('Database connection test') ?></h2>

        <?php if ($database_connect === true): ?>
            <p class="text-success">
                <?= __('We are successfully connected to the database, click on the link below to construct it.') ?>
            </p>
            <p class="text-warning">
                <?= __('Database Import may take time depending on size of the database. Please, do not close this window or refresh this page after clicking <b>Create Schema</b> button below.') ?>
            </p>

            <?= $this->Form->postLink(__('Create Schema') . ' <span class="glyphicon glyphicon-menu-right"></span>', ['plugin' => 'CakePHPAppInstaller', 'controller' => 'Install', 'action' => 'data'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?php else: ?>
            <div class="alert alert-danger">
                <?= __('Database Connection could not be established') ?>
            </div>
            <h4 class="text-warning"><?= __('Re-run the connection wizard or check for database connection manually') ?></h4>
            <?= $this->Html->link(__('Re-run Connection Wizard') . ' <span class="glyphicon glyphicon-menu-right"></span>', ['action' => 'connection'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?php endif; ?>
    </div> <!-- .span12 -->
</div> <!-- .row -->
