<?php

use Cake\Core\Configure;

?>
<div class="jumbotron">
    <h2><?= __('Database Connection Setup') ?></h2>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= $this->Form->create(null, ['class' => 'form-horizontal']) ?>
        <div class="form-group">
            <label class="control-label col-sm-4" for="host"><?= __('Host') ?> <span
                        class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top"
                        title="<?= __('Host Name or IP Address') ?>"></span></label>
            <div class="col-sm-8">
                <?= $this->Form->control('host', ['label' => false, 'value' => Configure::read('Installer.Connection.host'), 'class' => 'form-control', 'placeholder' => __('Host')]) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="username"><?= __('Username') ?> <span
                        class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top"
                        title="<?= __('Database connection login') ?>"></span></label>
            <div class="col-sm-8">
                <?= $this->Form->control('username', ['label' => false, 'value' => Configure::read('Installer.Connection.username'), 'class' => 'form-control', 'placeholder' => __('Datebase Username')]) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="password"><?= __('Password') ?> <span
                        class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top"
                        title="<?= __('Database connection password') ?>"></span></label>
            <div class="col-sm-8">
                <?= $this->Form->control('password', ['type' => 'password', 'label' => false, 'value' => '', 'class' => 'form-control', 'placeholder' => __('Password (leave blank, if no password)')]) ?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4" for="database"><?= __('Database Name') ?> <span
                        class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top"
                        title="<?= __('Database must have been created') ?>"></span></label>
            <div class="col-sm-8">
                <?= $this->Form->control('database', ['label' => false, 'value' => Configure::read('Installer.Connection.database'), 'class' => 'form-control', 'placeholder' => __('Database Name')]) ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-4" for="change_salt"><?= __('Change Salt') ?></label>
            <div class="col-sm-8">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="change_salt">
                        <?= __('Change Salt') ?>
                    </label>
                </div>
            </div>
        </div>

        <?php if (Configure::read('Installer.Import.ask')): ?>
            <div class="form-group">
                <label class="control-label col-sm-4" for="migrate_database"><?= __('Import Database File?') ?></label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="import_database">
                            <?= __('Import Database') ?>
                        </label>
                    </div>
                </div>
            </div>

            <div class="panel panel-danger">
                <div class="panel-body">
                    <h4><strong><?= __('NOTE:') ?></strong></h4>
                    <p><?= __('If you have <strong>checked</strong> <i>Import Database</i> field, make sure the <i><b>config/{0}</b></i> file exists. Otherwise it will throw an error.', Configure::read('Installer.Import.schema')) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary"><?= __('Submit') ?></button>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
