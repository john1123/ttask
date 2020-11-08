<form action="index.php" method="get">
    <input type="hidden" name="controller" value="tasks"/>
    <input type="hidden" name="action" value="edit"/>
    <input type="hidden" name="id" value="<?= $id ?>"/>
    <div class="form-group row">
        <label for="taskUsername" class="col-sm-2 col-form-label">Имя пользователя</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="taskUsername" name="username" value="<?= $username ?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="taskEmail" class="col-sm-2 col-form-label">E-mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="taskEmail" name="email"  value="<?= $email ?>"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="taskText" class="col-sm-2 col-form-label">Текст задачи</label>
        <div class="col-sm-10">
            <textarea id="taskText" class="form-control" name="task" rows="5" cols="10"><?= $task ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" name="done" type="checkbox" id="isTaskDone"<?php if (strlen($done) > 0) { ?> checked="checked"<?php } ?>>
                <label class="form-check-label" for="isTaskDone">
                    Задача выполнена
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Сохранить</button>
            <?php if ($id > 0) { ?><a href="?controller=tasks&action=delete&id=<?= $id ?>" onclick ="return confirm('Удалить задачу?');" class="btn btn-outline-secondary" role="button" aria-pressed="true">Удалить</a><?php } ?>
        </div>
    </div>
</form>