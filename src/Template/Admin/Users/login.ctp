<!-- File: src/Template/Users/login.ctp -->

<div class="users form">
<?= $this->Flash->render() ?>

<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
<button style='float:left'><?= $this->Html->link('New User Resgistration', ['action' => 'register']) ?></button>
<?= $this->Form->button(__('Login')); ?>
<?= $this->Form->end() ?>
</div>