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

	<form action="/group/update" method="POST">
		<input type="text" name="name" value="<?php isset($group['name']) ? print $group['name'] : ''; ?>">
		<input type="hidden" name="group_id" value="<?php isset($group['id']) ? print $group['id'] : ''; ?>">
		
		<button type="submit">Обновить</button>
		<a href="/groups">Отмена</a>
	</form>
</div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>