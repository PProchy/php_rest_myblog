<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->connect();

$book = new Book($db);

$data = json_decode(file_get_contents("php://input"));

$book->name = $data->name;
$book->pages = $data->pages;
$book->is_borrowed = $data->is_borrowed;
$book->user_id = $data->user_id;

if ($book->create()) {
    echo json_encode(
        array('message' => 'Kniha vytvořena.')
    );
} else {
    echo json_encode(
        array('message' => 'Někde se stala chyba. Kniha nevytvořena.')
    );
}
