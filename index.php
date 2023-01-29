<?php
// load composer
require_once __DIR__ . '/vendor/autoload.php';
use \Firebase\JWT\JWT;
// Synfony Dotenv component
use Symfony\Component\Dotenv\Dotenv; 
// load .env file
$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');
// load config file
$token = $_ENV['TOKEN'];
$api = $_ENV['API'];
$apikey = $_ENV['APIKEY'];
$body = array();
$body['a'] = rand(1, 100);
$body['b'] = rand(1, 100);
$body['exp'] = time() + 60;
$body['iss'] = $apikey;
$jsonBody = json_encode($body);
// generate JWT token
$jwt = JWT::encode($body, $token, 'HS256');
// print JWT token
print $jwt."\n";
// send request
$url = $api . "?a=" . $body['a'] . "&b=" . $body['b'];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $jwt
));
$result = curl_exec($ch);
curl_close($ch);
// print result
print $result."\n";
