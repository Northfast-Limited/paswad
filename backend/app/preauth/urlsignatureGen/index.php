<?php

header("Content-Type: application/json");
 
$serveraddr = $_SERVER['SERVER_ADDR'];
$domain = $_SERVER['SERVER_NAME'];
encode_url($domain);

function encode_url($domain) {
$signature = base64_encode("$domain");
$decodedsignature = base64_decode($signature);
echo json_encode(array("url-signature" => $signature));
echo json_encode(array("url-signature-decoded" => $decodedsignature));
}