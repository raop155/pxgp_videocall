<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/UserDevice.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate object
$userDevice = new UserDevice($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$userDevice->branchId = $data->branchId;
$userDevice->deviceId = $data->deviceId;
$userDevice->userId = $data->userId;
$userDevice->description = $data->description;
$userDevice->status = $data->status;

if ($userDevice->create()) {
  echo json_encode(
    array('message' => 'UserDevice Created')
  );
} else {
  echo json_encode(
    array('message' => 'UserDevice Not Created')
  );
}
