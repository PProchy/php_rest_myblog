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

  // Blog post query
  $result = $address->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any posts
  if($num > 0) {
    // Post array
    $addresss_arr = array();
    // $addresss_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $address_item = array(
        'id' => $id,
        'street' => $street,
        'house_number' => $house_number,
        'postal_code' => $postal_code,
        'city' => $city,
        'state' => $state
      );

      // Push to "data"
      array_push($addresss_arr, $address_item);
      // array_push($addresss_arr['data'], $address_item);
    }

    // Turn to JSON & output
    echo json_encode($addresss_arr);

  } else {
    // No Posts
    echo json_encode(
      array('message' => 'Nenalezeno.')
    );
  }
