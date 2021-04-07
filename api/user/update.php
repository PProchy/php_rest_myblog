<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

$database = new Database();
$db = $database->connect();

$user = new User($db);
$data = json_decode(file_get_contents("php://input"));

$user->id = $data->id;
$user->name = $data->name;
$user->surname = $data->surname;
$user->birth = $data->birth;
$user->address_id = $data->address_id;

if ($user->update()) {
    echo json_encode(
        array('message' => 'Uživatel upraven.')
    );
} else {
    echo json_encode(
        array('message' => 'Někde se stala chyba. Uživatel nebyl upraven.')
    );
}

