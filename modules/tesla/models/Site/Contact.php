<?php

namespace Site;

use \models\Model as Model;

class Contact extends Model
{
	public function create(array $data, $lead_id='')
	{
		$auth = $this->auth_amocrm();

		if ($auth) {	
			$url = '/private/api/v2/json/contacts/set';
			$name = $data['name'] . ' ' . $data['surname'] . ' [' . 'кв.' . $data['apartment_num'] . '] ' . '[' . $_SESSION['user_name_surname'] . ']';
			$method = 'POST';

	        $contacts['request']['contacts']['add'] = array(
	            array(
	                'name' => $name,
	                'linked_leads_id' => array(
	                	$lead_id
	                ),
	                'tags' => 'Шахматка, ТЕСЛА | дом',
	                'custom_fields' => array(
	                    array(
	                        'id' => 105089,
	                        'values' => array(
	                            array(
	                                'value' => $data['phone'],
	                                'enum' => 'WORK'
	                            ),
	                        )
	                    ),
	                    array(
	                        'id' => 105091,
	                        'values' => array(
	                            array(
	                                'value' => $data['email'],
	                                'enum' => 'WORK',
	                            ),
	                        )
	                    ),
	                ),
	            ),
	        );
	       $contacts = $this->do_query_to_amocrm_api($url, $contacts, $method);

	       return $contacts;
		} else {
			return false;
		}
	}
}