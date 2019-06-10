<?php

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "http://www.dneonline.com/calculator.asmx",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:tem=\"http://tempuri.org/\">
	<soapenv:Header/>
	<soapenv:Body>
	<tem:Multiply>
	<tem:intA>4</tem:intA>
	<tem:intB>2</tem:intB>
	</tem:Multiply>
	</soapenv:Body>
	</soapenv:Envelope>",
	CURLOPT_HTTPHEADER => array(
		"Content-Type: text/xml",
		"cache-control: no-cache"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$array = json_encode((array)$xml); 
	print_r($array);die();
	$this->output->set_content_type('application/json')->set_output(json_encode($array));
}