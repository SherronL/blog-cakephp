<h1>Admin page</h1>

<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user->id ?></td>

        <td>
            <?= $user->created->format(DATE_RFC850) ?>
        
        </td>
   
        <td>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $user->id],
                ['confirm' => 'Are you sure?'])
            ?>
        </td>
    </tr>
    <?php endforeach; ?>

</table>