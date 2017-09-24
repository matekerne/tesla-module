<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
	<div class="main__content">
		<?php if(isset($_SESSION['errors'])): ?>
			<?php print $_SESSION['errors']; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php elseif(isset($_SESSION['success'])): ?>
			<?php print $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>            
		<?php endif; ?>

		<form action="/group/create" method="POST">
			<label>Имя:</label>
			<input type="text" name="name" value="<?php isset($_SESSION['name']) ? print $_SESSION['name'] : '';  ?>">
			<button type="submit">Создать</button>
		</form>

	<?php unset($_SESSION['name']); ?>

	<?php foreach($groups as $group): ?>
		<p id="data"><?php print $group['name']; ?></p>

		<a href="/group/edit/<?php print $group['id']; ?>">редактировать</a>

		<form action="/group/delete" method="POST">
			<input type="hidden" name="group_id" value="<?php print $group['id']; ?>">
			<button type="submit">удалить</button>
		</form>
	<?php endforeach; ?>
</div>
</div>	
<?php require ROOT . '/views/layouts/footer.php'; ?>