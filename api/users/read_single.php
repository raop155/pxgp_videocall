<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/User.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$user = new User($db);

// Get ID
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get user
$user->read_single();

// Create array
$arr = array(
  'id' => $user->id,
  'user' => $user->user,
  'password' => $user->password,
  'name' => $user->name,
  'lastName' => $user->lastName,
  'email' => $user->email,
  'phone' => $user->phone,
  'createdAt' => $user->createdAt,
  'status' => $user->status,
);

// Make JSON
print_r(json_encode($arr));
