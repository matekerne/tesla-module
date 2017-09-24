<?php require ROOT . '/views/layouts/header.php'; ?>

	<?php if (isset($_SESSION['errors'])): ?>
		<?php print $_SESSION['errors']; ?>
		<?php unset($_SESSION['errors']); ?>
	<?php elseif (isset($_SESSION['success'])): ?>
		<?php print $_SESSION['success']; ?>
		<?php unset($_SESSION['success']); ?>
	<?php endif; ?>
<div class="grid-content admin__panel">
    <div class="main__content">
        <form class="admin__add-user-body" action="/user/create" method="POST">
            <div class="main__content-input">
                <label>Логин:</label>
                <input type="text" name="login" value="<?php isset($_SESSION['login']) ? print $_SESSION['login'] : '';  ?>">
            </div>
            
            <div class="main__content-input">
                <label>Пароль:</label>
                <input type="password" name="password" value="<?php isset($_SESSION['password']) ? print $_SESSION['password'] : '';  ?>">
            </div>

            <div class="main__content-input">
                <label>Роль:</label>
                <select name="role">
                    <option value="0"></option>
                    <?php foreach($roles as $role): ?>
                        <option value="<?php print $role['id'] ?>">
                            <?php print $role['name'] ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="main__content-input">
                <label>Группы:</label>
                <select class="js-example-basic-multiple" multiple="multiple" name="group[]">
                    <?php foreach($groups as $group): ?>
                        <option value="<?php print $group['id'] ?>">
                            <?php print $group['name'] ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>
           
            <div class="main__content-input">
                <label>Фамилия:</label>
                <input type="text" name="surname" value="<?php isset($_SESSION['surname']) ? print $_SESSION['surname'] : '';  ?>">
            </div>
           
            <div class="main__content-input">
                <label>Имя:</label>
                <input type="text" name="name" value="<?php isset($_SESSION['name']) ? print $_SESSION['name'] : '';  ?>">
            </div>

            <div class="main__content-input">
                <label>Отчество:</label>
                <input type="text" name="patronymic" value="<?php isset($_SESSION['patronymic']) ? print $_SESSION['patronymic'] : '';  ?>">
            </div>

            <div class="main__content-input">
                <label>Квартиры:</label>
                <select class="js-example-basic-multiple" multiple="multiple" name="apartments[]">
                    <?php foreach ($available_apartments as $available_apartment): ?>
                        <option value="<?php print $available_apartment['id'] ?>">
                            <?php print $available_apartment['num'] ?>
                        </option>
                        <?php endforeach; ?>
                </select>
            </div>
        
            <div class="main__content-button align-right">
                <button type="submit">Создать</button>
            </div>
        </form>

        <?php unset($_SESSION['login']); ?>
        <?php unset($_SESSION['name']); ?>
        <?php unset($_SESSION['surname']); ?>
        <?php unset($_SESSION['patronymic']); ?>
        <?php unset($_SESSION['password']); ?>

        <table class="admin__table" width="100%" border="0" cellspacing="0">
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td>
                            <div class="admin__table-name">
                                <?php print $user['surname']?>
                                    <?php print $user['name']?>
                                        <?php print $user['patronymic']?>
                            </div>
                            <div class="admin__table-role">
                                <?php print $user['role']?>
                            </div>
                        </td>

                        <td>
                            <?php print $user['groups']?>
                        </td>

                        <td>

                            <a href="/user/edit/<?php print $user['id'] ?>">Редактировать</a>
                            <form action="/user/delete" method="POST">
                                <input type="hidden" name="user_id" value="<?php print $user['id'] ?>">
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                        <?php endforeach; ?>
                    </tr>
            </tbody>
        </table>
   
    </div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>