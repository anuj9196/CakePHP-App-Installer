<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 * @var string $title_for_layout
 */

$cakeDescription = __('Cake App Installer');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>
        <?= $title_for_layout ?> |
        <?= $cakeDescription ?>
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php
    echo $this->Html->meta('icon');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT"
          crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><?= $cakeDescription ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<div class="container">

    <?= $this->Flash->render() ?>

    <?= $this->fetch('content') ?>

    <hr>
    <footer>
        <p class="float-end">
            <?= $this->Html->link(__('GitHub Repository'), 'https://github.com/anuj9196/CakePHP-App-Installer') ?>
            &copy; <?= date('Y') ?>
        </p>
        <p>
            <?= __('Developed with the {0}.', $this->Html->link('CakePHP Framework', 'https://cakephp.org')) ?><br/>
            <?= __('Designed with {0}.', $this->Html->link('Bootstrap', 'https://getbootstrap.com/')) ?>
        </p>
    </footer>
</div>
</body>
</html>
