<?php require_once(ROOT . '/views/layouts/header.php'); ?>

<div class="grid-content admin__panel">
	<div class="main__content">
		<?php if(isset($_SESSION['errors'])): ?>
			<?php print $_SESSION['errors']; ?>
			<?php unset($_SESSION['errors']); ?>
		<?php elseif(isset($_SESSION['success'])): ?>
			<?php print $_SESSION['success']; ?>
			<?php unset($_SESSION['success']); ?>            
		<?php endif; ?>
		
		<form class="admin__add-user-body" action="/module/tesla/admin/apartment/update" method="POST">
			<input type="hidden" name="id" value="<?php print $id ?>">

			<div class="main__content-input">
				<label>Тип:</label>
				<select name="type_id">
					<option value="0"></option>

					<?php foreach ($types as $type): ?>
						<?php $selected = ''; ?>

						<?php if ($type['id'] == $apartment['type_id']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>

						<option <?php print $selected; ?> value="<?php print $type['id'] ?>"><?php print $type['type'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Общая площадь:</label>
				<select name="total_area_id">
					<option value="0"></option>

					<?php foreach ($total_areas as $total_area): ?>
						<?php $selected = ''; ?>

						<?php if ($total_area['id'] == $apartment['total_area_id']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>

						<option <?php print $selected; ?> value="<?php print $total_area['id'] ?>"><?php print $total_area['total_area'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Фактическая площадь:</label>
				<input type="text" name="factual_area" value="<?php print $apartment['factual_area'] ?>">
			</div>

			<div class="main__content-input">
				<label>Этаж:</label>
				<select name="floor">
					<option value="0"></option>

					<?php foreach ($floors as $floor): ?>
						<?php $selected = ''; ?>

						<?php if ($floor['num'] == $apartment['floor']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>

						<option <?php print $selected; ?> value="<?php print $floor['num'] ?>"><?php print $floor['num'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="main__content-input">
				<label>Номер квартиры:</label>
				<select name="num">
					<option value="0"></option>

					<?php foreach ($nums as $num): ?>
						<?php $selected = ''; ?>
						
						<?php if ($num['num'] == $apartment['num']): ?>
							<?php $selected = 'selected'; ?>
						<?php endif; ?>

						<option <?php print $selected; ?> value="<?php print $num['num'] ?>"><?php print $num['num'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Окна на:</label>
				<select class="js-example-basic-multiple" multiple="multiple" name="window[]">
					<option value="0"></option>
					<?php foreach ($windows as $window): ?>
						<?php $selected = ''; ?>
						<?php foreach ($apart_windows as $apart_window): ?>
						
							<?php if ($window['id'] == $apart_window['id']): ?>
								<?php $selected = 'selected'; ?>
							<?php endif; ?>
						<?php endforeach; ?>

						<option <?php print $selected; ?> value="<?php print $window['id'] ?>"><?php print $window['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Цена:</label>
				<input type="number" name="price" value="<?php print $apartment['price'] ?>">
			</div>
			
			<div class="main__content-input">
				<label>Скидка:</label>
				<input type="number" name="discount" value="<?php print $apartment['discount'] ?>">
			</div>

			<div class="main__content-input">
				<label>Статус:</label>
				<select name="status">
					<option value=""></option>
					<option <?php ($apartment['status'] == $value = 0) ? print 'selected' : print ''; ?> value="0">Продана</option>
					<option <?php ($apartment['status'] == $value = 1) ? print 'selected' : print ''; ?> value="1">Свободна</option>
					<option <?php ($apartment['status'] == $value = 2) ? print 'selected' : print ''; ?> value="2">Забронирована</option>
				</select>
			</div>

			<div class="main__content-checkbox">
				<label>Тип остекления:</label>
				<?php foreach($glazings as $glazing): ?>
					<?php $checked = ''; ?>

					<?php foreach ($apart_glazings as $apart_glazing): ?>
						<?php if ($glazing['id'] == $apart_glazing): ?>
							<?php $checked = 'checked'; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<label>
						<input  type="checkbox" name="glazing[]" <?php print $checked; ?> value="<?php print $glazing['id']; ?>"><?php print $glazing['name']; ?>
					</label>
						
				<?php endforeach; ?>
			</div>
			
			<div class="main__content-button align-right">
				<button type="submit">Обновить</button>
				<a href="/module/tesla/admin/apartments">Отмена</a>
			</div>
			
		</form>
	</div>
	</div>
<?php require_once(ROOT . '/views/layouts/footer.php'); ?>