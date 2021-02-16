<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Room.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate object
$room = new Room($db);

// Blog post query
$result = $room->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if ($num > 0) {
  // Post array
  $arr = array();
  // $arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $item = array(
      'id' => $id,
      'userId' => $userId,
      'room' => $room,
      'status' => $status,
      'createdAt' => $createdAt,
    );

    // Push to "data"
    array_push($arr, $item);
    // array_push($arr['data'], $item);
  }

  // Turn to JSON & output
  echo json_encode($arr);
} else {
  echo json_encode(
    array('message' => 'No Rooms Found')
  );
}
