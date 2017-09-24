<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="home-login">
	<div class="grid-content">
		<form action="/login/user" method="POST">
			<img src="/public/image/logo/inpk_logo.svg">

			<?php if(isset($_SESSION['errors'])): ?>
				<div class="login-error">
					<?php print $_SESSION['errors']; ?>
					<?php unset($_SESSION['errors']); ?>
				</div>
			<?php elseif(isset($_SESSION['success'])): ?>
				<div class="login-error">
					<?php print $_SESSION['success']; ?>
					<?php unset($_SESSION['success']); ?>  
				</div>          
			<?php endif; ?>

			<div class="login-field-group">
				<img src="/public/image/icon/login/user.png">
				<input type="text" name="login" placeholder="Логин" value="<?php isset($_SESSION['login']) ? print $_SESSION['login'] : '';  ?>">
			</div>
		
			<div class="login-field-group">
				<img src="/public/image/icon/login/password.png">
				<input type="password" name="password" placeholder="Пароль" value="<?php isset($_SESSION['password']) ? print $_SESSION['password'] : '';  ?>">
			</div>

			<button type="submit" name="submit">Войти</button>
		</form>

		<?php unset($_SESSION['login']); ?>
		<?php unset($_SESSION['password']); ?>
	</div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>