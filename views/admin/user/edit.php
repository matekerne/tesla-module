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
	<form class="admin__add-user-body" action="/user/update" method="POST">
		<input type="hidden" name="id" value="<?php print $user['id']; ?>">

		<div class="main__content-input">
			<label>Логин:</label>
			<input type="text" name="login" value="<?php isset($user['login']) ? print $user['login'] : ''; ?>">
		</div>

		<div class="main__content-input">
			<label>Имя:</label>
			<input type="text" name="name" value="<?php isset($user['name']) ? print $user['name'] : ''; ?>">
		</div>

		<div class="main__content-input">
			<label>Фамилия:</label>
			<input type="text" name="surname" value="<?php isset($user['surname']) ? print $user['surname'] : ''; ?>">
		</div>

		<div class="main__content-input">
			<label>Отчество:</label>
			<input type="text" name="patronymic" value="<?php isset($user['patronymic']) ? print $user['patronymic'] : ''; ?>">
		</div>

		<div class="main__content-input">
			<label>Роль:</label>
			<select name="role">
				<option value="0"></option>
				
				<?php foreach ($all_roles as $role): ?>
					<?php $selected = ''; ?>			
					<?php foreach ($user_roles as $user_role): ?>
						<?php if ($role['id'] == $user_role['id']): ?>
							<?php $selected = 'selected'; ?>
						<?php else: ?>
							<?php $selected = ''; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<option <?php print $selected; ?> value="<?php print $role['id'] ?>"><?php print $role['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="main__content-input">
			<label>Группы:</label>
			<select class="js-example-basic-multiple" multiple="multiple" name="group[]">
				<option value="0"></option>
					<?php foreach ($all_groups as $group): ?>
						<?php $selected = ''; ?>
							<?php $user_groups = $this->create_select2_data('groups', $user['groups']); ?>
						<?php foreach($user_groups as $user_group): ?>
							<?php if ($group['id'] == $user_group['id']): ?>
								<?php $selected = 'selected'; ?>
							<?php endif; ?>
						<?php endforeach; ?>
						<option <?php print $selected; ?> value="<?php print $group['id'] ?>"><?php print $group['name'] ?></option>
					<?php endforeach; ?>
			</select>
		</div>

		<div class="main__content-input">
			<label>Квартиры:</label>
			<select class="js-example-basic-multiple" multiple="multiple" name="apartments[]">
				<option value="0"></option>

				<?php foreach ($all_apartments as $all_apartment): ?>
					<?php $selected = ''; ?>
					<?php foreach($user_apartments as $user_apartment): ?>
						<?php if ($all_apartment['id'] == $user_apartment['id']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<option <?php print $selected; ?> value="<?php print $all_apartment['id'] ?>"><?php print $all_apartment['num'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="main__content-input">
			<label>Пароль:</label>
			<input type="password" name="password">
		</div>	

		<?php if (count($user_apartments) > 0): ?>
			<?php foreach ($user_apartments as $user_apartment): ?>
				<input type="hidden" name="old_user_apartments[]" value="<?php print $user_apartment['id'] ?>" type="multiple">
			<?php endforeach; ?>
		<?php else: ?>
			<input type="hidden" name="old_user_apartments[]" value="" type="multiple">
		<?php endif; ?>
		
		<div class="main__content-button align-right">
			<button type="submit">Обновить</button>
			<a href="/users">Отмена</a>
		</div>

		
	</form>
</div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>