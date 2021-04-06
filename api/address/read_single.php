<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Address.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $address = new Address($db);

  // Get ID
  $address->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $address->read_single();

  // Create array
  $address_arr = array(
      'id' => $address->id,
      'street' => $address->street,
      'house_number' => $address->house_number,
      'postal_code' => $address->postal_code,
      'city' => $address->city,
      'state' => $address->state
  );

  // Make JSON
  print_r(json_encode($address_arr));