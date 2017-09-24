<?php require_once(ROOT . '/views/layouts/header.php'); ?>
<div class="grid-content">
	<div class="main__content">
		<?php if(isset($_SESSION['error_access'])): ?>
			<?php print $_SESSION['error_access']; ?>
			<?php unset($_SESSION['error_access']); ?>          
		<?php endif; ?>

		<?php if(isset($_SESSION['errors'])): ?>
			<?php print $_SESSION['errors']; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php elseif(isset($_SESSION['success'])): ?>
			<?php print $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>            
		<?php endif; ?>

</div>
</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>