<form action="index.php" method="get">
    <input type="hidden" name="controller" value="tasks"/>
    <input type="hidden" name="action" value="edit"/>
    <input type="hidden" name="id" value="0"/>
    <div class="form-group row">
        <label for="taskUsername" class="col-sm-2 col-form-label">Имя пользователя</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="taskUsername" name="username">
        </div>
    </div>
    <div class="form-group row">
        <label for="taskEmail" class="col-sm-2 col-form-label">E-mail</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="taskEmail" name="email">
        </div>
    </div>
    <div class="form-group row">
        <label for="taskText" class="col-sm-2 col-form-label">Текст задачи</label>
        <div class="col-sm-10">
            <textarea id="taskText" class="form-control" name="task" rows="5" cols="10">
            </textarea>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <div class="form-check">
                <input class="form-check-input" name="done" type="checkbox" id="isTaskDone">
                <label class="form-check-label" for="isTaskDone">
                    Задача выполнена
                </label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </div>
    </div>
</form>