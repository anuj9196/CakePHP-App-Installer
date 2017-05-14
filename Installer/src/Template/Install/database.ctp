<div class="jumbotron">
 	<h1><?= __("Database creation") ?></h2>
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?= __("Database creation in PhpMyAdmin") ?></h2>
		<h3><?=  __("Step 1 : Connection to PhpMyAdmin") ?></h3>
		<p>
            <?= __("To connect to PhpMyAdmin, you have to type the following url : ") ?>
			<?= $this->Html->link("http://".$_SERVER['SERVER_NAME']."/phpMyAdmin/") ?>.
        </p>
		<p>
            <?= __("Type your login and password") ?>
        </p>

		<h3><?= __("Step 2 : Database creation") ?></h3>
		<p>
            <?= __("Please, click on the Database tab.") ?>
        </p>
		<?= $this->Html->image('capture-1.jpg', array('class' => 'img-center')) ?>

		<p>
			<?= __("You just have to type the database name, here we will choose <strong>cakephp</strong>") ?>
			<?= $this->Html->image('capture-2.jpg', array('class' => 'img-center')) ?>
        </p>

		<p><?= __("That's all!") ?></p>

	</div> <!-- .span12 -->
</div> <!-- .row -->

<div class="row">
	<div class="span12">
		<h2><?= __("Database connection test") ?></h2>
        <?= $this->Html->link(__('Step 3 : Database connection test'), ['plugin' => 'Installer', 'controller' => 'Install', 'action' => 'connection'], ['class' => 'btn btn-primary']) ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->
