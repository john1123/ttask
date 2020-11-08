<form action="index.php" method="get">
    <input type="hidden" name="controller" value="users"/>
    <input type="hidden" name="action" value="login"/>
        <div class="form-group">
            <label for="inputUsername">Имя пользователя:</label>
            <input type="text" class="form-control" name="username" id="inputUsername" required="required" value="<?= $username ?>" maxlength="32" aria-describedby="usernameHelp">
            <small id="usernameHelp" class="form-text text-muted">Имя пользователя может содержать только буквы и цифры</small>
        </div>
    <div class="form-group">
        <label for="inputPassword">Пароль:</label>
        <input type="password" class="form-control" name="password" id="inputPassword" value="<?= $password ?>">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>