<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate object
$user = new User($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
if (isset($data->id)) $user->id = $data->id;

// Get user
$user->read_single();

if (isset($data->user)) $user->user = $data->user;
if (isset($data->password)) $user->password = $data->password;
if (isset($data->name)) $user->name = $data->name;
if (isset($data->lastName)) $user->lastName = $data->lastName;
if (isset($data->email)) $user->email = $data->email;
if (isset($data->phone)) $user->phone = $data->phone;

// Update user
if ($user->update()) {
  echo json_encode(
    array('message' => 'User Updated')
  );
} else {
  echo json_encode(
    array('message' => 'User Not Updated')
  );
}
