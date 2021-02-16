<?php
class UserDevice
{
  private $conn;
  private $table = 'users_devices';

  public $id;
  public $branchId;
  public $deviceId;
  public $userId;
  public $description;
  public $createdAt;
  public $status;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function read()
  {
    $query = 'SELECT 
                * FROM ' . $this->table . ' u_d
                ORDER BY u_d.createdAt DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function read_single()
  {
    $query = 'SELECT *
                FROM ' . $this->table . ' u_d
                WHERE
                u_d.id = ?
                LIMIT 0,1';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
    $this->branchId = $row['branchId'];
    $this->deviceId = $row['deviceId'];
    $this->userId = $row['userId'];
    $this->description = $row['description'];
    $this->createdAt = $row['createdAt'];
  }

  public function getByUserId()
  {
    $query = 'SELECT u_d.*, r.room
              FROM ' . $this->table . ' u_d
              LEFT JOIN rooms r
              ON u_d.userId = r.userId                
              WHERE
              u_d.userId = ?';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->userId);
    $stmt->execute();

    return $stmt;
  }

  public function getByDevice()
  {
    $query = 'SELECT u_d.*, r.room
                FROM ' . $this->table . ' u_d
                LEFT JOIN rooms r
                ON u_d.userId = r.userId                
                WHERE
                u_d.branchId = ? AND
                u_d.deviceId = ?';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->branchId);
    $stmt->bindParam(2, $this->deviceId);
    $stmt->execute();

    return $stmt;
  }

  public function create()
  {
    $query = 'INSERT INTO ' . $this->table .
      ' SET branchId = :branchId, 
        deviceId = :deviceId,
        userId = :userId,
        description = :description';

    $stmt = $this->conn->prepare($query);

    $this->branchId = htmlspecialchars(strip_tags($this->branchId));
    $this->deviceId = htmlspecialchars(strip_tags($this->deviceId));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->description = htmlspecialchars(strip_tags($this->description));

    $stmt->bindParam(':branchId', $this->branchId);
    $stmt->bindParam(':deviceId', $this->deviceId);
    $stmt->bindParam(':userId', $this->userId);
    $stmt->bindParam(':description', $this->description);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function update()
  {
    $query = 'UPDATE ' . $this->table .
      ' SET branchId = :branchId, 
            deviceId = :deviceId,
            userId = :userId,
            description = :description
        WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->branchId = htmlspecialchars(strip_tags($this->branchId));
    $this->deviceId = htmlspecialchars(strip_tags($this->deviceId));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->description = htmlspecialchars(strip_tags($this->description));

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':branchId', $this->branchId);
    $stmt->bindParam(':deviceId', $this->deviceId);
    $stmt->bindParam(':userId', $this->userId);
    $stmt->bindParam(':description', $this->description);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function delete()
  {
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
