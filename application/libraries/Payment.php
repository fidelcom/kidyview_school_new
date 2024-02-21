<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment {

    function paymentProcess($postData)
    {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/payments",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($postData),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer FLWSECK_TEST-ec6b830b0dfc9beb2267ad55bea4c6c5-X",
                "cache-control: no-cache",
                "content-type: application/json",
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return $err;
            } else {
                return json_decode($response);
            }
  }
  function payment_verify($transaction_id=''){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/$transaction_id/verify",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"Content-Type: application/json",
		"Authorization: Bearer FLWSECK_TEST-ec6b830b0dfc9beb2267ad55bea4c6c5-X"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			return $err;
		} else {
			return json_decode($response,true);
		}
	}
  
}