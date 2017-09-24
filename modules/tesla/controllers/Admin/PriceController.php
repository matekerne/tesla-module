<?php

namespace Admin;

use \controllers\Controller as Controller;

class PriceController extends Controller
{
	private $price;

	public function __construct() 
	{
		$roles_groups = [
			'roles' => ['admin'],
			'groups' => ['tesla']
		];
		$this->check_access($roles_groups);

		$this->price = new Price();
	}

	public function index()
	{
		require_once(ROOT . '/modules/tesla/views/admin/price/index.php');
		return true;
	}

	public function send_excel_file($files_names)
	{
		foreach ($files_names as $file_name) {
			if (mime_content_type(ROOT . '/public/files/' . $file_name) == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {

				$emails = [
					'ilia.kaduk@in-pk.com',
					'dmitriy.sergeev@in-pk.com'
				];

				foreach ($emails as $email) {
					$to = $email;
					$from = "info@crm.inpk-development.ru";
					$subject = 'Тесла|дом - Обновились цены на квартиры';
					$message = '';

					$separator = md5(date('r', time()));
					$eol = PHP_EOL;

					$path_to_prices_excel = ROOT . '/public/files/' . $file_name;
					$attachment = chunk_split(base64_encode(file_get_contents($path_to_prices_excel)));

					$headers  = "From: ".$from.$eol;
					$headers .= "MIME-Version: 1.0".$eol; 
					$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";

					$body = "--".$separator.$eol;
					$body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;

					$body .= "--".$separator.$eol;
					$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
					$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
					$body .= $message.$eol;

					$body .= "--".$separator.$eol;
					$body .= "Content-Type: application/octet-stream; name=\"".$file_name."\"".$eol; 
					$body .= "Content-Transfer-Encoding: base64".$eol;
					$body .= "Content-Disposition: attachment;  filename=\"".$file_name."\"".$eol.$eol;
					$body .= $attachment.$eol;
					$body .= "--".$separator."--";

					$result = mail($to, $subject, $body, $headers);
				}

				return true;
			}
		}
	}

	public function upload()
	{
		$this->check_request($_POST);

		$path_to_uploaded_files = $_FILES['prices']['tmp_name'];
		$files_names = $_FILES['prices']['name'];
		$files_params = $_FILES['prices'];


		if (in_array('', $files_params['name']) || !array_key_exists(1, $files_params['name'])) {
			$_SESSION['errors'] = 'Должно быть добавленно 2 файла. Первый в формате csv с новыми ценами для тесла дома, второй в формате excel для отправки экономистам!';
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit();
		} else {

			// Удаление старых файлов с ценами
			$old_files = scandir(ROOT . '/public/files/', 1);
			foreach ($old_files as $old_file) {
				if (!is_dir($old_file)) {
					unlink(ROOT . '/public/files/' . $old_file);
				}
			}

			// Загрузка файлов с ценами
			$i = 0;
			foreach ($files_params['name'] as $file_name) {
				$new_path = ROOT . '/public/files/' . $file_name;
				$file = move_uploaded_file($files_params['tmp_name'][$i], $new_path);

				if (!$file) {
					$_SESSION['errors'] = 'Не удалось загрузить файлы, попробуйте позже!';
					header('Location ' . $_SERVER['HTTP_REFERER']);
					exit();
				}

				$i++;
			}

			// Обновление цен
			$new_files = scandir(ROOT . '/public/files/', 1);
			foreach ($new_files as $new_file) {
				// $test = ROOT . '/public/files/t.xlsx';
				if (mime_content_type(ROOT . '/public/files/' . $new_file) == 'text/plain') {
					// var_dump(1); die();

					$path_to_prices_csv = ROOT . '/public/files/' . $new_file;
					$open_file = fopen($path_to_prices_csv, 'r');
					$data = fgetcsv($open_file);

					$prices = [];
					$i = 0;
					while ($row = fgetcsv($open_file)) {
						$clean_string = str_replace(' ', '', $row[0]);
						$values = explode(';', $clean_string);

						$prices[$i]['num'] = $values[0];
						$prices[$i]['price'] = $values[1];
						$i++;
					}

					if (count($prices) < 1) {
						$_SESSION['errors'] = 'Файл с ценами не может быть пустым';
						header('Location: ' . $_SERVER['HTTP_REFERER']);
						exit();
					} else {
						$result = $this->price->upload($prices);
						$this->check_response($result);
					}

					$result = $this->send_excel_file($files_names);
					$this->check_response($result);

					return $this->redirect('Готово');
				}
			}
		}
	}
}