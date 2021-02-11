<?php 
  class User {
    private $conn;
    private $table = 'user';

    public $id;
    public $user;
    public $password;
    public $name;
    public $lastName;
    public $email;
    public $phone;
    public $createdAt;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 'SELECT 
                * FROM ' . $this->table . ' u
                u.createdAt DESC';
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function read_single() {
      $query = 'SELECT *
                FROM ' . $this->table . ' u
                WHERE
                p.id = ?
                LIMIT 0,1';

      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $this->id = $row['id'];
      $this->user = $row['user'];
      $this->password = $row['password'];
      $this->name = $row['name'];
      $this->lastName = $row['lastName'];
      $this->email = $row['email'];
      $this->phone = $row['phone'];
      $this->createdAt = $row['createdAt'];

    }

    public function create() {
      $query = 'INSERT INTO ' . $this->table . 
               ' SET user = :user, 
               password = :password, 
               name = :name, 
               lastName = :lastName, 
               email = :email, 
               phone = :phone';

      $stmt = $this->conn->prepare($query);

      $this->user = htmlspecialchars(strip_tags($this->user));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->lastName = htmlspecialchars(strip_tags($this->lastName));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->phone = htmlspecialchars(strip_tags($this->phone));

      $stmt->bindParam(':user', $this->user);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':lastName', $this->lastName);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':phone', $this->phone);

      if ($stmt->execute()) {
        return true;            
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function update() {
      $query = 'UPDATE ' . $this->table . 
                ' SET user = :user, 
                password = :password, 
                name = :name, 
                lastName = :lastName, 
                email = :email, 
                phone = :phone';

      $stmt = $this->conn->prepare($query);

      $this->user = htmlspecialchars(strip_tags($this->user));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->lastName = htmlspecialchars(strip_tags($this->lastName));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->phone = htmlspecialchars(strip_tags($this->phone));

      $stmt->bindParam(':user', $this->user);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':name', $this->name);
      $stmt->bindParam(':lastName', $this->lastName);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':phone', $this->phone);

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