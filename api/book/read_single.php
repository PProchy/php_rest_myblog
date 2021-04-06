<?php

  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Book.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog category object
  $book = new Book($db);

  // Get ID
  $book->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $book->read_single();

  // Create array
  $book_arr = array(
    'id' => $book->id,
    'name' => $book->name
  );

  // Make JSON
  print_r(json_encode($book_arr));
