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

		<form action="/module/tesla/admin/total/area/create" method="POST">
			<label>Общая площадь:</label>
			<input type="number" name="total_area" value="<?php isset($_SESSION['total_area']) ? print $_SESSION['total_area'] : ''; ?>">
			<button type="submit">Создать</button>
		</form>

	<?php unset($_SESSION['total_area']); ?>

	<?php foreach($essences as $essence): ?>
		<p><?php print $essence['total_area']; ?></p>

		<a href="/module/tesla/admin/total/area/edit/<?php print $essence['id']; ?>">редактировать</a>

		<form action="/module/tesla/admin/total/area/delete" method="POST">
			<input type="hidden" name="id" value="<?php print $essence['id']; ?>">
			<button type="submit">удалить</button>
		</form>
	<?php endforeach; ?>
</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>