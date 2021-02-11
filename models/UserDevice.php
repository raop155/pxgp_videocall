<?php 
  class UserDevice {
    private $conn;
    private $table = 'user_device';

    public $id;
    public $branchId;
    public $deviceId;
    public $userId;
    public $createdAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 'SELECT 
                * FROM ' . $this->table . ' u_d
                r.createdAt DESC';
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function read_single() {
      $query = 'SELECT *
                FROM ' . $this->table . ' u_d
                WHERE
                p.id = ?
                LIMIT 0,1';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row['id'];
      $this->branchId = $row['branchId'];
      $this->deviceId = $row['deviceId'];
      $this->userId = $row['userId'];
      $this->createdAt = $row['createdAt'];
    }

    public function create() {
      $query = 'INSERT INTO ' . $this->table . 
               ' SET branchId = :branchId, 
               deviceId = :deviceId,
               userId = :userId';

      $stmt = $this->conn->prepare($query);

      $this->userId = htmlspecialchars(strip_tags($this->userId));
      $this->status = htmlspecialchars(strip_tags($this->status));


      $stmt->bindParam(':branchId', $this->branchId);
      $stmt->bindParam(':deviceId', $this->deviceId);
      $stmt->bindParam(':userId', $this->userId);

      if ($stmt->execute()) {
        return true;            
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function update() {
      $query = 'UPDATE ' . $this->table . 
                ' SET branchId = :branchId, 
                deviceId = :deviceId,
                userId = :userId';

      $stmt = $this->conn->prepare($query);

      $this->userId = htmlspecialchars(strip_tags($this->userId));
      $this->status = htmlspecialchars(strip_tags($this->status));
 
      $stmt->bindParam(':branchId', $this->branchId);
      $stmt->bindParam(':deviceId', $this->deviceId);
      $stmt->bindParam(':userId', $this->userId);

      if ($stmt->execute()) {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function delete() {
      $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

      $stmt = $this->conn->prepare($query);

      $this->id = htmlspecialchars(strip_tags($this->id));

      $stmt->bindParam(':id', $this->id);

      if ($stmt->execute()) {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }  
  }