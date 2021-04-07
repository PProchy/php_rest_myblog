<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->connect();

$book = new Book($db);

$result = $book->read();

$num = $result->rowCount();

if ($num > 0) {

    $book_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $book_item = array(
            'id' => $id,
            'name' => $name,
            'pages' => $pages,
            'is_borrowed' => $is_borrowed,
            'user_id' => $user_id
        );

        array_push($book_arr, $book_item);
    }

    echo json_encode($book_arr);

} else {

    echo json_encode(
        array('message' => 'Žádná kniha nenalezena.')
    );
}
