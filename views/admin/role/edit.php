<?php require ROOT . '/views/layouts/header.php'; ?>
<div class="grid-content">
	<div class="main__content">
	<?php if (isset($_SESSION['errors'])): ?>
		<?php print $_SESSION['errors']; ?>
		<?php unset($_SESSION['errors']); ?>
	<?php elseif (isset($_SESSION['success'])): ?>
		<?php print $_SESSION['success']; ?>
		<?php unset($_SESSION['success']); ?>
	<?php endif; ?>

	<form action="/role/update" method="POST">
		<input type="text" name="name" value="<?php isset($role['name']) ? print $role['name'] : ''; ?>">
		<input type="hidden" name="role_id" value="<?php isset($role['id']) ? print $role['id'] : ''; ?>">
		<button type="submit">Обновить</button>
		<a href="/roles">Отмена</a>
	</form>
</div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>