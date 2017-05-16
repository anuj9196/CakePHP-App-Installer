<div class="jumbotron">
    <h2><?php echo __("Database Connection Setup"); ?></h2>
</div>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <?= $this->Form->create(null, ['class' => 'form-horizontal']) ?>
            <div class="form-group">
                <label class="control-label col-sm-4" for="email">Host <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Host IP Adress"></span></label>
                <div class="col-sm-8">
                    <?= $this->Form->control('host', ['label' => false, 'value' => 'localhost', 'class' => 'form-control', 'placeholder' => 'Host']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Username <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database connection login"></span></label>
                <div class="col-sm-8">
                    <?= $this->Form->control('username', ['label' => false, 'value' => 'root', 'class' => 'form-control', 'placeholder' => 'Datebase Username']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Password <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database connection password"></span></label>
                <div class="col-sm-8">
                    <?= $this->Form->control('password', ['type' => 'password', 'label' => false, 'value' => '', 'class' => 'form-control', 'placeholder' => 'Password (leave blank, if no password)']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Database Name <span class="glyphicon glyphicon-info-sign" data-toggle="tooltip" data-placement="top" title="Database must have created"></span></label>
                <div class="col-sm-8">
                    <?= $this->Form->control('database', ['label' => false, 'value' => 'cakephp', 'class' => 'form-control', 'placeholder' => 'Database Name']) ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="migrate_database">Import Database File?</label>
                <div class="col-sm-8">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" value="1" name="import_database">
                            Import Database
                        </label>
                    </div>
                </div>
            </div>

            <div class="panel panel-danger">
                <div class="panel-body">
                    <h4><b>NOTE:</b></h4>
                    If you have <strong>checked</strong> <i>Import Database</i> field, make sure a file <i><b>my_schema.sql</b></i> exists in <i>config/</i> directory.
                    Otherwise it will throw an error
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</div>