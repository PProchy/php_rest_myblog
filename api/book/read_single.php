<?php

// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

$database = new Database();
$db = $database->connect();

$book = new Book($db);

$book->id = isset($_GET['id']) ? $_GET['id'] : die();

$book->read_single();

$book_arr = array(
    'id' => $book->id,
    'name' => $book->name,
    'pages' => $book->pages,
    'is_borrowed' => $book->is_borrowed,
    'user_id' => $book->user_id
);

print_r(json_encode($book_arr));
