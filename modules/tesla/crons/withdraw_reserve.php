<?php

	$protocol = 'https://';
	$host_name = 'crm.inpk-development.ru';
	$url = '/module/tesla/apartment/auto-withdraw-reserve';
	$link = $protocol . $host_name . $url;

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_RETURNTRANSFER, value);
	curl_setopt($curl, CURLOPT_URL, $link);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        
    $out = curl_exec($curl);
    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    curl_close($curl);
