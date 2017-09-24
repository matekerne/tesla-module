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

		<form action="/module/tesla/admin/num/create" method="POST">
			<label>Номер квартиры №:</label>
			<input type="number" name="num" value="<?php isset($_SESSION['num']) ? print $_SESSION['num'] : ''; ?>">
			<button type="submit">Создать</button>
		</form>

	<?php unset($_SESSION['num']); ?>

	<?php foreach($essences as $essence): ?>
		<p><?php print $essence['num']; ?></p>

		<a href="/module/tesla/admin/num/edit/<?php print $essence['id']; ?>">редактировать</a>

		<form action="/module/tesla/admin/num/delete" method="POST">
			<input type="hidden" name="id" value="<?php print $essence['id']; ?>">
			<button type="submit">удалить</button>
		</form>
	<?php endforeach; ?>
</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>