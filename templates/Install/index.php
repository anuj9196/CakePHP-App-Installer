<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Cache\Cache;

$check = true;
?>
<div class="mt-4 p-3 bg-light rounded">
    <h2><?= __('Configuration Check') ?></h2>
</div>

<div class="row">
    <h2><?= __('Tests') ?></h2>

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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
    ?>

    <?php
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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
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
    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
    ?>

    <?php
    if (version_compare(PHP_VERSION, '7.4.0') < 0) {
        $check = false;
        $class = 'danger';
        $glyphicon = 'remove';
        $message = __('Your PHP version must be equal or higher than 7.4.0 to use CakePHP (' . PHP_VERSION . ')');
    } else {
        $class = 'success';
        $glyphicon = 'ok';
        $message = __('Your PHP version is equal or higher than 7.4.0 to use CakePHP (' . PHP_VERSION . ')');
    }

    echo '<div class="alert alert-' . $class . '"><span class="glyphicon glyphicon-' . $glyphicon . '"></span> ' . $message . '</div>';
    ?>
</div>

<div class="row">
    <?php if ($check): ?>
        <div class="row mt-5">
            <div class="text-center">
                <?= __('Your configuration passed all tests successfully') ?>
                <h2><?= __('Continue to Database Configuration') ?></h2>
                <div class="text-center">
                    <?= $this->Html->link(__('Configure Database') . '
 <span class="glyphicon glyphicon-menu-right"></span>',
                        ['action' => 'connection'],
                        ['class' => 'btn btn-primary', 'escape' => false]) ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-remove"></span>
            <?= __('Your configuration does not correspond to the minimum required.
                    Please update it and retry.') ?>
        </div>
    <?php endif; ?>
</div>
