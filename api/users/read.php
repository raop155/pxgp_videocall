<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate object
$user = new User($db);

// Blog post query
$result = $user->read();
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
      'user' => $user,
      'password' => $password,
      'name' => $name,
      'lastName' => $lastName,
      'email' => $email,
      'phone' => $phone,
      'createdAt' => $createdAt,
      'status' => $status
    );

    // Push to "data"
    array_push($arr, $item);
    // array_push($arr['data'], $item);
  }

  // Turn to JSON & output
  echo json_encode($arr);
} else {
  echo json_encode(
    array('message' => 'No Users Found')
  );
}
