<?php
class Room
{
  private $conn;
  private $table = 'rooms';

  public $id;
  public $userId;
  public $room;
  public $status;
  public $createdAt;

  public function __construct($db)
  {
    $this->conn = $db;
  }

  public function read()
  {
    $query = 'SELECT 
                * FROM ' . $this->table . ' r
                ORDER BY r.createdAt DESC';

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  public function read_single()
  {
    $query = 'SELECT *
                FROM ' . $this->table . ' r
                WHERE
                p.id = ?
                LIMIT 0,1';

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $this->id = $row['id'];
    $this->userId = $row['userId'];
    $this->room = $row['room'];
    $this->status = $row['status'];
    $this->createdAt = $row['createdAt'];
  }

  public function create()
  {
    $query = 'INSERT INTO ' . $this->table .
      ' SET userId = :userId, 
            room = :room,
            status = :status';

    $stmt = $this->conn->prepare($query);

    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->room = htmlspecialchars(strip_tags($this->room));
    $this->status = htmlspecialchars(strip_tags($this->status));

    $stmt->bindParam(':userId', $this->userId);
    $stmt->bindParam(':room', $this->room);
    $stmt->bindParam(':status', $this->status);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s.\n", $stmt->error);

    return false;
  }

  public function update()
  {
    $query = 'UPDATE ' . $this->table .
      ' SET userId = :userId, 
            room = :room,
            status = :status
        WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->userId = htmlspecialchars(strip_tags($this->userId));
    $this->room = htmlspecialchars(strip_tags($this->room));
    $this->status = htmlspecialchars(strip_tags($this->status));

    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':userId', $this->userId);
    $stmt->bindParam(':room', $this->room);
    $stmt->bindParam(':status', $this->status);

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
