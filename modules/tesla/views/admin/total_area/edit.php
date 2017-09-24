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
		
		<form action="/module/tesla/admin/total/area/update" method="POST">
			<input type="hidden" name="id" value="<?php isset($essence['id']) ? print $essence['id'] : ''; ?>">
			<label>Общая площадь:</label>
			<input type="number" name="total_area" value="<?php isset($essence['total_area']) ? print $essence['total_area'] : ''; ?>">
			<button type="submit">Обновить</button>
			<a href="/module/tesla/admin/total/areas">Отмена</a>
		</form>
	</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>