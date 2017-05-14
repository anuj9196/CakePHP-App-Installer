<?php
	$check = true;
?>

<div class="jumbotron">
	<h1><?php echo __("Configuration tests"); ?></h1>
</div> <!-- .hero-unit -->

<div class="row">
	<div class="span12">
		<h2><?php echo __("Tests")?></h2>
		<?php
			if (is_writable(TMP)) {
				$class = "success";
				$message = __("The TMP folder is writable");
			} else {
				$check = false;
				$class = "danger";
				$message = __("The TMP folder is not writable");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';
		?>

		<?php
			if (is_writable(CONFIG)) {
				$class = "success";
				$message = __("The Config folder is writable");
			} else {
				$check = false;
				$class = "danger";
				$message = __("The Config folder is not writable");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';
		?>

		<?php
			if (extension_loaded('intl')) {
				$class = "success";
				$message = __("intl extension enabled");
			} else {
				$check = false;
				$class = "danger";
				$message = __("You must enable the intl extension to use CakePHP");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';
		?>

		<?php
			if (extension_loaded('mbstring')) {
				$class = "success";
				$message = __("mbstring extension enabled");
			} else {
				$check = false;
				$class = "danger";
				$message = __("You must enable the mbstring extension to use CakePHP");
			}
			echo '<div class="alert alert-'.$class.'"><p>' .$message. '</p></div>';
		?>

		<?php
			if (version_compare(PHP_VERSION, '5.6.0') < 0) {
				$check = false;
				$class = "danger";
				$message = __("Your PHP version must be equal or higher than 5.6.0 to use CakePHP (".PHP_VERSION.")");
			} else {
				$class = "success";
				$message = __("Your PHP version is equal or higher than 5.6.0 to use CakePHP (".PHP_VERSION.")");
			}

			echo '<div class="alert alert-'.$class.'"><p>' .$message. '<p></div>';
		?>
	</div> <!-- .span12 -->
</div> <!-- .row -->

<div class="row">
	<div class="span12">
		<?php if($check): ?>
			<p><?= __("Your configuration passed all tests successfully. What do you want to do?") ?></p>
			<div class="row" style="margin-top: 60px;">
				<div class="span6">
					<h2>Create new database</h2>
					<p>You want to create a new database and create the tables and entries associated.</p>

					<?= $this->Form->create() ?>
						<?= $this->Form->control('create', ['type'  => 'hidden', 'value' => 1]) ?>
						<div class="form-actions">
							<?= $this->Form->control("Create database", ['label' => false, 'type'  => 'submit', 'class' => 'btn btn-primary']) ?>
						</div>
					<?= $this->Form->end()?>
				</div> <!-- .span -->

				<div class="span6">
					<h2>Connect to existing database</h2>
					<p>The database and tables are already created, you just want to connect your application.</p>

					<?= $this->Form->create()?>
						<?= $this->Form->input("connect", ['type'  => 'hidden', 'value' => 1]) ?>
						<div class="form-actions">
							<?= $this->Form->control("Connect database", ['label' => false, 'type'  => 'submit', 'class' => 'btn btn-primary']) ?>
						</div>
					<?= $this->Form->end() ?>
				</div> <!-- .span -->
			</div> <!-- .row -->
		<?php else : ?>
			<div class="alert alert-danger">
				<p><?php echo __("You configuration does not correspond to the minimal required. Please update it and retry."); ?></p>
			</div> <!-- .alert -->
		<?php endif; ?>
	</div> <!-- .span12 -->
</div> <!-- .row -->
