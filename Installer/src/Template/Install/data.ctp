<div class="jumbotron">
 	<h1><?php echo __("Database construction")?></h1>
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Database connection test"); ?></h2>

		<p><?php echo __("We are successfully connected to the database, click on the link below to construct it."); ?></p>
		
        <?= $this->Form->postLink(__('Copy Schema'), ['plugin' => 'Installer', 'controller' => 'Install', 'action' => 'data'], ['class' => 'btn btn-primary']) ?>

	</div> <!-- .span12 -->
</div> <!-- .row -->
