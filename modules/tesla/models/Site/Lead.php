<?php

namespace Site;

use \models\Model as Model;

class Lead extends Model
{
	public function get_success_implement()
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
	        $url = '/private/api/v2/json/leads/list?status[]=16042321&status[]=15289882&status[]=16042324&status[]=16042327&status[]=16042330&status[]=16042333&status[]=16042336&status[]=142&tags=ТЕСЛА | дом';
	    	$leads = $this->do_query_to_amocrm_api($url);

	    	return $leads;
		} else {
			return false;
		}
	}

	public function get_reserved()
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
			$url = '/private/api/v2/json/leads/list?status[]=16042315&status[]=15289879&tags=ТЕСЛА | дом';
	    	$leads = $this->do_query_to_amocrm_api($url);

	    	return $leads;
		} else {
			return false;
		}
	}

	public function get_paid_reserve()
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
			$url = '/private/api/v2/json/leads/list?status[]=16063342&tags=ТЕСЛА | дом';
			$leads = $this->do_query_to_amocrm_api($url);

			return $leads;
		} else {
			return false;
		}
	}

	public function get_closed_not_implement()
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
			$url = '/private/api/v2/json/leads/list?status[]=143&tags=ТЕСЛА | дом';
			$leads = $this->do_query_to_amocrm_api($url);

			return $leads;
		} else {
			return false;
		}		
	}

	public function create(array $data)
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
			$name = 'Сделка' . ' №' . $data['apartment_num'] . '/' . $data['apartment_num'];
	        $url = '/private/api/v2/json/leads/set';
	        $method = 'POST';

	        $leads['request']['leads']['add'] = array(
	            array(
	                'name' => $name,
	                'status_id' => 15289873,
	                'price' => rand(5, 900000),
	                'tags' => 'ТЕСЛА | дом',
	                'created_user_id' => 15289867,
	            ),
	        );
			
			$lead = $this->do_query_to_amocrm_api($url, $leads, $method);
			return $lead;
		} else {
			return false;
		}
	}

	public function lead(array $data)
	{
		$auth = $this->auth_amocrm();

		if ($auth) {
			$lead = $this->create($data);
			$convert_lead = json_decode($lead, true);
			$lead_id = $convert_lead['response']['leads']['add'][0]['id'];

			if ($lead) {
				$contact = new Contact();
				$contact = $contact->create($data, $lead_id);

				if ($contact) {
					return true;
				} else {
					return true;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}