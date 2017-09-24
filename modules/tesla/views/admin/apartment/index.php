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

		<form class="admin__add-user-body" action="/module/tesla/admin/apartment/create" method="POST">
			
			<div class="main__content-input">
				<label>Тип:</label>
				<select name="type_id">
					<option value=""></option>
					<?php foreach($types as $type): ?>
						<option value="<?php print $type['id'] ?>"><?php print $type['type'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Общая площадь:</label>
				<select name="total_area_id">
					<option value=""></option>
					<?php foreach($total_areas as $total_area): ?>
						<option value="<?php print $total_area['id'] ?>"><?php print $total_area['total_area'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Фактическая площадь:</label>
				<input type="text" name="factual_area">
			</div>

			<div class="main__content-input">
				<label>Этаж:</label>
				<select name="floor">
					<option value=""></option>
					<?php foreach($floors as $floor): ?>
						<option value="<?php print $floor['num'] ?>"><?php print $floor['num'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Номер квартиры:</label>
				<select name="num">
					<option value=""></option>
					<?php foreach($nums as $num): ?>
						<option value="<?php print $num['num'] ?>"><?php print $num['num'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			
			<div class="main__content-input">
				<label>Окна на:</label>
				<select class="js-example-basic-multiple" multiple="multiple" name="window[]">
					<option value=""></option>
					<?php foreach($windows as $window): ?>
						<option value="<?php print $window['id'] ?>"><?php print $window['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="main__content-input">
				<label>Цена:</label>
				<input type="number" name="price" value="<?php isset($_SESSION['price']) ? print $_SESSION['price'] : ''; ?>">
			</div>

			<div class="main__content-input">
				<label>Скидка:</label>
				<input type="number" name="discount" value="<?php isset($_SESSION['discount']) ? print $_SESSION['discount'] : ''; ?>">
			</div>

			<div class="main__content-input">
				<label>Статус:</label>
				<select name="status">
					<option value=""></option>
					<option value="1">Свободна</option>
					<option value="2">Забронирована</option>
					<option value="3">Продана</option>
				</select>
			</div>
			
			<div class="main__content-checkbox">
				<label>Тип остекления:</label>
					<input type='hidden' value='' name="glazing[]">
					<?php foreach($glazings as $glazing): ?>
						<label>
							<input type="checkbox" name="glazing[]" value="<?php print $glazing['id']; ?>"><?php print $glazing['name']; ?>
						</label>
					<?php endforeach; ?>
			</div>
			
			<div class="main__content-button align-right">
				<button type="submit">Создать</button>
			</div>

			
		</form>

		<?php unset($_SESSION['price']) ?>
		<?php unset($_SESSION['discount']) ?>

		<table class="admin__table">
			<thead>
				<th>Номер</th>
				<th>Этаж</th>
				<th>Площадь</th>
				
				<th></th>
			</thead>
			<?php foreach($apartments as $apartment): ?>
					<tr>
						<td><?php print $apartment['num']; ?></td>
						<td class="table-align-center"><?php print $apartment['floor']; ?></td>
						<td class="table-align-center"><?php print $apartment['factual_area']; ?></td>

						

						<td>
							<a href="/module/tesla/admin/apartment/edit/<?php print $apartment['id']; ?>">редактировать</a>			
							<form action="/module/tesla/admin/apartment/delete" method="POST">
								<input type="hidden" name="id" value="<?php print $apartment['id']; ?>">
								<button type="submit">удалить</button>
							</form>
						</td>
					</tr>
			<?php endforeach; ?>
		</table>
	</div>
	</div>

<?php require_once(ROOT . '/views/layouts/footer.php'); ?>