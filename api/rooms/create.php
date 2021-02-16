<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Room.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate object
$room = new Room($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$room->userId = $data->userId;
$room->room = $data->room;
$room->status = $data->status;

if ($room->create()) {
  echo json_encode(
    array('message' => 'Room Created')
  );
} else {
  echo json_encode(
    array('message' => 'Room Not Created')
  );
}
