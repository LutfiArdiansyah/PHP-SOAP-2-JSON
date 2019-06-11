<?php
$url = "https://cdaweb.sci.gsfc.nasa.gov:443/WS/jaxrpc"; // URL WSDL SOAP
// XML Parameter SOAP
$xml = "<env:Envelope env:encodingStyle='http://schemas.xmlsoap.org/soap/encoding/' xmlns:env='http://schemas.xmlsoap.org/soap/envelope/' xmlns:xsd='http://www.w3.org/2001/XMLSchema' xmlns:xsi='http://www.w3.org/2001/XMLSchema-instance' xmlns:enc='http://schemas.xmlsoap.org/soap/encoding/' xmlns:ns0='http://cdaweb.gsfc.nasa.gov/WS/types/CDASWS' xmlns:ns1='http://java.sun.com/jax-rpc-ri/internal'> <env:Body> <ans1:getAllInstrumentDescriptionsResponse xmlns:ans1='http://cdaweb.gsfc.nasa.gov/WS/CDASWS'> <result xsi:type='ns0:ArrayOfInstrumentDescription' enc:arrayType='ns0:InstrumentDescription[0]' xsi:nil='1'/> </ans1:getAllInstrumentDescriptionsResponse> </env:Body> </env:Envelope>";
// END XML Parameter SOAP
$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => $xml,
	CURLOPT_HTTPHEADER => array(
		"Content-Type: text/xml",
		"cache-control: no-cache"
	),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);
header('Content-Type: application/json');
if ($err) {
	$array = json_encode(array('Error' => $err),JSON_PRETTY_PRINT);
} else {
	$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
	$xml = new SimpleXMLElement($response);
	$array = json_encode((array)$xml,JSON_PRETTY_PRINT); 
}
echo $array;
