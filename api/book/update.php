<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->connect();

$book = new Book($db);

$data = json_decode(file_get_contents("php://input"));

$book->id = $data->id;

$book->name = $data->name;
$book->pages = $data->pages;
$book->is_borrowed = $data->is_borrowed;
$book->user_id = $data->user_id;

if ($book->update()) {
    echo json_encode(
        array('message' => 'Kniha upravena.')
    );
} else {
    echo json_encode(
        array('message' => 'Někde se stala chyba. Kniha neupravena.')
    );
}
