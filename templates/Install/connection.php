<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<div class="mt-4 p-3 bg-light rounded">
    <h2><?= __('Database Connection Setup') ?></h2>
</div>

<div class="row justify-content-center">
    <div class="col-md-9">
        <?= $this->Form->create() ?>

        <div class="row align-items-center my-3">
            <div class="col-3">
                <label for="host" class="col-form-label"><?= __('Host') ?></label>
            </div>
            <div class="col-5">
                <?= $this->Form->control('host', ['label' => false, 'value' => Configure::read('Installer.Connection.host'), 'class' => 'form-control', 'placeholder' => __('Host'), 'aria-describedby' => 'passwordHelpInline']) ?>
            </div>
            <div class="col-4">
                <span id="passwordHelpInline" class="form-text">
                  <?= __('Host Name or IP Address') ?>
                </span>
            </div>
        </div>

        <div class="row align-items-center my-3">
            <div class="col-3">
                <label for="username" class="col-form-label"><?= __('Username') ?></label>
            </div>
            <div class="col-5">
                <?= $this->Form->control('username', ['label' => false, 'value' => Configure::read('Installer.Connection.username'), 'class' => 'form-control', 'placeholder' => __('Database Username'), 'aria-describedby' => 'usernameHelpInline']) ?>
            </div>
            <div class="col-4">
                <span id="usernameHelpInline" class="form-text">
                  <?= __('Database connection login') ?>
                </span>
            </div>
        </div>

        <div class="row align-items-center my-3">
            <div class="col-3">
                <label for="password" class="col-form-label"><?= __('Password') ?></label>
            </div>
            <div class="col-5">
                <?= $this->Form->control('password', ['type' => 'password', 'label' => false, 'value' => '', 'class' => 'form-control', 'placeholder' => __('Password (leave blank, if no password)'), 'aria-describedby' => 'passwordHelpInline']) ?>
            </div>
            <div class="col-4">
                <span id="passwordHelpInline" class="form-text">
                  <?= __('Database connection password') ?>
                </span>
            </div>
        </div>

        <div class="row align-items-center my-3">
            <div class="col-3">
                <label for="database" class="col-form-label"><?= __('Database Name') ?></label>
            </div>
            <div class="col-5">
                <?= $this->Form->control('database', ['label' => false, 'value' => Configure::read('Installer.Connection.database'), 'class' => 'form-control', 'placeholder' => __('Database Name'), 'databaseHelpInline']) ?>
            </div>
            <div class="col-4">
                <span id="databaseHelpInline" class="form-text">
                  <?= __('Database must have been created') ?>
                </span>
            </div>
        </div>

        <div class="form-group my-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" name="change_salt">
                        <?= __('Change Salt') ?>
                    </label>
            </div>
        </div>

        <?php if (Configure::read('Installer.Import.ask')): ?>
            <div class="form-group my-3">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="import_database">
                            <?= __('Import Database File?') ?>
                        </label>
                    </div>
            </div>

            <div class="card card-body bg-light my-3">
                <h4><strong><?= __('NOTE:') ?></strong></h4>
                <p><?= __('If you have <strong>checked</strong> <i>Import Database</i> field, make sure the <i><b>config/{0}</b></i> file exists. Otherwise it will throw an error.',
                        Configure::read('Installer.Import.schema')) ?></p>
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
