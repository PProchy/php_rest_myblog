<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Address.php';

$database = new Database();
$db = $database->connect();

$address = new Address($db);

$result = $address->read();
$num = $result->rowCount();

if ($num > 0) {

    $addresss_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $address_item = array(
            'id' => $id,
            'street' => $street,
            'house_number' => $house_number,
            'postal_code' => $postal_code,
            'city' => $city,
            'state' => $state
        );

        array_push($addresss_arr, $address_item);
    }

    echo json_encode($addresss_arr);

} else {
    echo json_encode(
        array('message' => 'Nenalezeno.')
    );
}
