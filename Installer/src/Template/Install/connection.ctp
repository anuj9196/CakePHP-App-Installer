<div class="jumbotron">
    <h1><?php echo __("Database connection test"); ?></h1>
</div> <!-- .hero-unit -->

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= $this->Form->create(null, ['class' => 'form-horizontal']) ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Host <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Host IP Adress"></span>:</label>
                <div class="col-sm-10">
                    <?= $this->Form->control('host', ['label' => false, 'value' => 'localhost', 'class' => 'form-control', 'placeholder' => 'Host']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Username <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database connection login"></span>:</label>
                <div class="col-sm-10">
                    <?= $this->Form->control('username', ['label' => false, 'value' => 'root', 'class' => 'form-control', 'placeholder' => 'Datebase Username']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Password <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database connection password"></span>:</label>
                <div class="col-sm-10">
                    <?= $this->Form->control('password', ['type' => 'password', 'label' => false, 'value' => '', 'class' => 'form-control', 'placeholder' => 'Password (leave blank, if no password)']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="pwd">Database Name <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database must have created"></span>:</label>
                <div class="col-sm-10">
                    <?= $this->Form->control('database', ['label' => false, 'value' => 'cakephp', 'class' => 'form-control', 'placeholder' => 'Database Name']) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>
