<?php
use Cake\Cache\Cache;
?>
<?php
$check = true;
?>
<div class="jumbotron">
    <h2><?= __('Configuration Check') ?></h2>
</div>

<div class="row">
    <div class="span12">
        <h2><?= __('Tests')?></h2>

        <?php if (is_writable(TMP)):
            $class = 'success';
            $glyphicon = 'ok';
            $message = __('Your tmp directory is writable');
        else:
             $check = false;
             $class = 'danger';
             $glyphicon = 'remove';
             $message = __('Your tmp directory is NOT writable');
        endif;
        echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php if (is_writable(LOGS)):
            $class = 'success';
            $glyphicon = 'ok';
            $message = __('Your logs directory is writable');
        else:
             $check = false;
             $class = 'danger';
             $glyphicon = 'remove';
             $message = __('Your logs directory is NOT writable');
        endif;
        echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php
//        $settings = Cache::config('_cake_core_');
        $settings = Cache::getConfig('_cake_core_');
        if (!empty($settings)):
            $class = 'success';
            $glyphicon = 'ok';
            $message = __('The <em>{0}Engine</em> is being used for core caching. To change the config edit config/app.php', $settings['className']);
         else:
             $check = false;
             $class = 'danger';
             $glyphicon = 'remove';
             $message = __('Your cache is NOT working. Please check the settings in config/app.php');
        endif;
        echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php
            if (is_writable(CONFIG)) {
                $class = 'success';
                $glyphicon = 'ok';
                $message = __('Your config directory is writable');
            } else {
                $check = false;
                $class = 'danger';
                $glyphicon = 'remove';
                $message = __('Your config directory is not writable');
            }
            echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php
            if (extension_loaded('intl')) {
                $class = 'success';
                $glyphicon = 'ok';
                $message = __('intl extension enabled');
            } else {
                $check = false;
                $class = 'danger';
                $glyphicon = 'remove';
                $message = __('You must enable the intl extension to use CakePHP');
            }
            echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php
            if (extension_loaded('mbstring')) {
                $class = 'success';
                $glyphicon = 'ok';
                $message = __('mbstring extension enabled');
            } else {
                $check = false;
                $class = 'danger';
                $glyphicon = 'remove';
                $message = __('You must enable the mbstring extension to use CakePHP');
            }
            echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '</p></div>';
        ?>

        <?php
            if (version_compare(PHP_VERSION, '5.6.0') < 0) {
                $check = false;
                $class = 'danger';
                $glyphicon = 'remove';
                $message = __('Your PHP version must be equal or higher than 5.6.0 to use CakePHP ('.PHP_VERSION.')');
            } else {
                $class = 'success';
                $glyphicon = 'ok';
                $message = __('Your PHP version is equal or higher than 5.6.0 to use CakePHP ('.PHP_VERSION.')');
            }

            echo '<div class="alert alert-'.$class.'"><p><span class="glyphicon glyphicon-'.$glyphicon.'"></span> ' .$message. '<p></div>';
        ?>
    </div> <!-- .span12 -->
</div> <!-- .row -->

<div class="row">
    <div class="span12">
        <?php if ($check): ?>
            <div class="row" style="margin-top: 60px;">
                <div class="col-md-8 col-md-offset-2 text-center">
                    <p><?= __('Your configuration passed all tests successfully') ?></p>
                    <h2><?= __('Continue to Database Configuration') ?></h2>
                    <div class="text-center">
                        <?= $this->Html->link(__('Configure Database').' <span class="glyphicon glyphicon-menu-right"></span>', ['action' => 'connection'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
                    </div>
                </div>
            </div> <!-- .row -->
        <?php else : ?>
            <div class="alert alert-danger">
                <p><span class="glyphicon glyphicon-remove"></span> <?= __('Your configuration does not correspond to the minimum required. Please update it and retry.') ?></p>
            </div> <!-- .alert -->
        <?php endif; ?>
    </div> <!-- .span12 -->
</div> <!-- .row -->
