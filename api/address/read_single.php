<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Address.php';

$database = new Database();
$db = $database->connect();

$address = new Address($db);

$address->id = isset($_GET['id']) ? $_GET['id'] : die();

$address->read_single();

$address_arr = array(
    'id' => $address->id,
    'street' => $address->street,
    'house_number' => $address->house_number,
    'postal_code' => $address->postal_code,
    'city' => $address->city,
    'state' => $address->state
);

print_r(json_encode($address_arr));