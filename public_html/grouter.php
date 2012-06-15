<?php

include 'default.php';

$APIkey = "AIzaSyCyZqs16u475EuNckqNXfhZDFEbm65Ihj4";
$autocompleteAPI = "https://maps.googleapis.com/maps/api/place/autocomplete/json";
$url = $autocompleteAPI ."?". $_SERVER["QUERY_STRING"] ."&key=". $APIkey ."&userip=". $_SERVER['REMOTE_ADDR'];

$ch = curl_init();
// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// grab URL and pass it back
$response = curl_exec($ch);
// close cURL resource, and free up system resources
curl_close($ch);

echo $response;
echo $url;
?>