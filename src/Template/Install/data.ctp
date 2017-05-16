<div class="jumbotron">
 	<h2><?php echo __("Database Construction")?></h2>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2 text-center">
		<h2><?php echo __("Database connection test"); ?></h2>

        <?php if ($database_connect === true): ?>
		    <p class="text-success">
                <?php echo __("We are successfully connected to the database, click on the link below to construct it."); ?>
            </p>
            <p class="text-warning">
                Database Import may take time depending on size of the database. Please, do not close this window or refresh this page after clicking <b>Copy Schema</b> button below.
            </p>

            <?= $this->Form->postLink(__('Copy Schema').' <span class="glyphicon glyphicon-menu-right"></span>', ['plugin' => 'Installer', 'controller' => 'Install', 'action' => 'data'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?php else: ?>
            <div class="alert alert-danger">
                Database Connection could not be established
            </div>
            <h4 class="text-warning">Re-run the connection wizard or check for database connection manually</h4>
            <?= $this->Html->link(__('Re-run Connection Wizard').' <span class="glyphicon glyphicon-menu-right"></span>', ['action' => 'connection'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?php endif; ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->