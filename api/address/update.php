<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Address.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$address = new Address($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$address->id = $data->id;

$address->street = $data->street;
$address->house_number = $data->house_number;
$address->postal_code = $data->postal_code;
$address->city = $data->city;
$address->state = $data->state;

// Update post
if ($address->update()) {
    echo json_encode(
        array('message' => 'Adresa aktualizována.')
    );
} else {
    echo json_encode(
        array('message' => 'Někde se stala chyba. Adresa neaktualizována.')
    );
}

