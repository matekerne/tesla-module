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

		<form action="/module/tesla/admin/reserve/create" method="POST">
			<label>Бронь для риэлтора на (кол-во дней):</label>
			<input type="number" name="realtor" value="<?php isset($_SESSION['realtor']) ? print $_SESSION['realtor'] : ''; ?>">
			<label>Бронь для менеджера на (кол-во дней):</label>
			<input type="number" name="manager" value="<?php isset($_SESSION['manager']) ? print $_SESSION['manager'] : ''; ?>">
			<button type="submit">Создать</button>
		</form>

	<?php unset($_SESSION['realtor']); ?>
	<?php unset($_SESSION['manager']); ?>

	<?php foreach($essences as $essence): ?>
		<p><?php print $essence['realtor']; ?></p>
		<p><?php print $essence['manager']; ?></p>

		<a href="/module/tesla/admin/reserve/edit/<?php print $essence['id']; ?>">редактировать</a>

		<form action="/module/tesla/admin/reserve/delete" method="POST">
			<input type="hidden" name="id" value="<?php print $essence['id']; ?>">
			<button type="submit">удалить</button>
		</form>
	<?php endforeach; ?>
</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>