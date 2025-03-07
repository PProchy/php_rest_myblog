<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Address.php';


$database = new Database();
$db = $database->connect();

$address = new Address($db);

$data = json_decode(file_get_contents("php://input"));

$address->street = $data->street;
$address->house_number = $data->house_number;
$address->postal_code = $data->postal_code;
$address->city = $data->city;
$address->state = $data->state;

if ($address->create()) {
    echo json_encode(
        array('message' => 'Adresa vytvořena.')
    );
} else {
    echo json_encode(
        array('message' => 'Někde se stala chyba. Adresa nevytvořena.')
    );
}

