<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/UserDevice.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$userDevice = new UserDevice($db);

// Get userId
$userDevice->userId = isset($_GET['userId']) ? $_GET['userId'] : die();

// Get user
$result = $userDevice->getByUserId();
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
      'branchId' => $branchId,
      'deviceId' => $deviceId,
      'userId' => $userId,
      'description' => $description,
      'createdAt' => $createdAt,
      'status' => $status,
      'room' => $room,
    );

    // Push to "data"
    array_push($arr, $item);
    // array_push($arr['data'], $item);
  }

  // Turn to JSON & output
  echo json_encode($arr);
} else {
  echo json_encode(
    array('message' => 'No UsersDevices Found')
  );
}
