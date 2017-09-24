<?php

namespace components;

trait Helper
{
	public function fill_session_fields(array $data)
	{	
		foreach ($data as $field => $value) {
			$_SESSION[$field] = $value;
		}

		return true;
	}

	public function clean_session_fields(array $data)
	{
		foreach ($data as $field => $value) { 
			unset($_SESSION[$field]);
		}

		return true;
	}

	public function redirect(string $message, string $url='')
	{
		if ($message) {
			$_SESSION['success'] = $message;
		}

		if ($url) {
			header('Location: ' . $url);
		} else {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}

		exit();
	}

	/**
	 *
	 * For correct get data from select2.js if field null
	 *
	 *	
	*/
	public function get_select2_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
			$data = $request["$field"];
		} else {
			$data = '';
		}

		return $data;
    }

	public function get_checkbox_value(string $field, array $request)
    {
    	if (array_key_exists("$field", $request)) {
			$data = $request["$field"];
		} else {
			$data = '';
		}

		return $data;
    }

    public function create_select2_data(string $field, $data=''): array
    {
    	$result = [];
    	
    	$i = 0;
    	switch ($field) {
    		case 'roles':
		    	$arr = (array) $data;
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'groups':
				$arr = explode(',', $data);
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'windows':
				$arr = explode(',', $data);
				foreach($arr as $value) {
					$result[$i]['id'] = preg_replace('/[^0-9]/', '', $value);
					$result[$i]['name'] = preg_replace('/[^a-zA-ZА-Яа-я\s]/ui', '', $value);
					$i++;
				}
				break;
			case 'apartments':
				if ($data) {				
					$arr = explode(',', $data);
					foreach($arr as $value) {
						$result[$i]['id'] = $value;
						$i++;
					}
				}
				break;
    	}

		return $result;
    }

    public function do_query_to_amocrm_api($url, $data='', $method='')
    {
    	$subdomain = 'inpk';
        $link = 'https://'.$subdomain.'.amocrm.ru'.$url;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        if ($method == 'POST') {
	        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
	        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_COOKIEFILE,dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_COOKIEJAR,dirname(__FILE__) . '/cookie.txt');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $code = (int) $code;

        if ($code != 200 && $code != 204) {
        	return false;
        } else {
        	return $out;
        }
    }

    public function auth_amocrm()
    {
	    $url = '/private/api/auth.php?type=json';
	    $method = 'POST';
	    
	    $settings = array(
	        'USER_LOGIN' => 'it@in-pk.com',
	        'USER_HASH' => '43562a1e01abf5a1a3ce3fd4b78d82f8'
	    );

	    return $this->do_query_to_amocrm_api($url, $settings, $method);
    }
}