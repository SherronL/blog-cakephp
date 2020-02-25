<?php
$cakeDescription = 'CakePHP: the rapid development php framework';
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('style.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
            <!--Accessing ArticlesController and link the button to indexs
            first it reads the controller then the method--> 
                <h1><a>
                <?= $this->Html->link('Articles', array('controller' => 'Articles',
                'action' => 'index')) ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <!-- short hand if and else-->
            <?php if($loggedIn) : ?>
                <?php if($isAdmin) : ?>
                <li>
                    <?= $this->Html->link('Manage users',
                ['controller' => 'users', 'action' => 'index', 'prefix' => 'admin']);?>
                </li>
  
                <?php endif; ?>
                <li>
                <!-- displays Logout, and we call logout() from UserController-->
                    <?= $this->Html->link('Logout',
                ['controller' => 'users', 'action' => 'logout', 'prefix' => false]);?>
                
                </li>

            <?php else : ?>
                <li>
                    <?= $this->Html->link('Login',
                ['controller' => 'users', 'action' => 'login']);?>
                </li>
                <li>
                    <?= $this->Html->link('Register',
                ['controller' => 'users', 'action' => 'register']);?>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
