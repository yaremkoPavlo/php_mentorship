<?php require_once 'header.php'; ?>
<div class="center">
    <a href="/logout.php">Logout</a>
    <table>
        <tr>
            <th></th>
            <th><a href="/list.php?sort=task&order=ASC">Sort by Task ↑</a></th>
            <th><a href="/list.php?sort=created&order=ASC">Sort by Created ↑</a></th>
            <th><a href="/list.php?sort=updated&order=ASC">Sort by Updated ↑</a></th>
            <th><a href="/list.php?sort=completed&order=ASC">Sort by Completed ↑</a></th>
            <th></th>
        </tr>
        <tr>
            <th></th>
            <th><a href="/list.php?sort=task&order=DESC">Sort by Task ↓</a></th>
            <th><a href="/list.php?sort=created&order=DESC">Sort by Created ↓</a></th>
            <th><a href="/list.php?sort=updated&order=DESC">Sort by Updated ↓</a></th>
            <th><a href="/list.php?sort=completed&order=DESC">Sort by Completed ↓</a></th>
            <th></th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Task</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Completed</th>
            <th></th>
        </tr>
        <?php if(isset($items)): ?>
        <?php foreach ($items as $item): ?>
            <tr>
                <form method="POST">
                    <td><?php echo $item->getId(); ?></td>
                    <td><input type="text" name="task" value="<?php echo $item->getTask() ?>"/></td>
                    <td><?php echo $item->getCreated()->format('Y-m-d H:m:s') ?></td>
                    <td><?php echo $item->getUpdated()->format('Y-m-d H:m:s') ?></td>
                    <td><input type="checkbox" <?php echo $item->isCompleted() ? 'checked="checked"' : ''; ?> name="completed"/></td>
                    <td>
                        <button type="submit" name="update" value="<?php echo $item->getId(); ?>">Update task</button>
                        <button type="submit" name="delete" value="<?php echo $item->getId(); ?>">Delete task</button>
                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <div class="pagination">
    <a href="/list.php">All task</a>
    <a href="/list.php?per_page=2">Per 2 tasks</a>
    <a href="/list.php?per_page=5">Per 5 tasks</a>
    <a href="/list.php?per_page=10">Per 10 tasks</a>
    </div>
    <?php if(isset($itemCount)): ?>
    <div class="pagination">
        <?php //@todo implement next and previously page ?>
        <a href="/list.php">Next page</a>
        <a href="/list.php">Previous page</a>
    </div>
    <?php endif; ?>
    <br />
    <hr />
    <h4>Add new task to list</h4>
    <form method="POST">
        <label>Enter task name:
            <input type="text" name="task" />
        </label>
        <button type="submit" name="create">Add task to list</button>
    </form>
</div>
<?php require_once 'footer.php' ?>