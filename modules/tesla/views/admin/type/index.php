<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content">
	<div class="main__content">
		<?php if(isset($_SESSION['errors'])): ?>
			<?php print $_SESSION['errors']; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php elseif(isset($_SESSION['success'])): ?>
			<?php print $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>            
		<?php endif; ?>

		<form action="/module/tesla/admin/type/create" method="POST">
			<label>Тип:</label>
			<input type="text" name="type" value="<?php isset($_SESSION['type']) ? print $_SESSION['type'] : ''; ?>">
			<button type="submit">Создать</button>
		</form>

	<?php unset($_SESSION['type']); ?>

	<?php foreach($essences as $essence): ?>
		<p><?php print $essence['type']; ?></p>

		<a href="/module/tesla/admin/type/edit/<?php print $essence['id']; ?>">редактировать</a>

		<form action="/module/tesla/admin/type/delete" method="POST">
			<input type="hidden" name="id" value="<?php print $essence['id']; ?>">
			<button type="submit">удалить</button>
		</form>
	<?php endforeach; ?>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>