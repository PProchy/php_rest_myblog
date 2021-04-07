<?php

class User
{
    private $conn;
    private $table = 'user';

    public $id;
    public $name;
    public $surname;
    public $birth;
    public $address_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = ?';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->surname = $row['surname'];
        $this->birth = $row['birth'];
        $this->address_id = $row['address_id'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET
        name = :name,
        surname = :surname,
        birth = :birth,
        address_id = :address_id';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->birth = htmlspecialchars(strip_tags($this->birth));
        $this->address_id = htmlspecialchars(strip_tags($this->address_id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':birth', $this->birth);
        $stmt->bindParam(':address_id', $this->address_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: $s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET 
        name = :name,
        surname = :surname,
        birth = :birth,
        address_id = :address_id
        WHERE
        id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->surname = htmlspecialchars(strip_tags($this->surname));
        $this->birth = htmlspecialchars(strip_tags($this->birth));
        $this->address_id = htmlspecialchars(strip_tags($this->address_id));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':birth', $this->birth);
        $stmt->bindParam(':address_id', $this->address_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: $s.\n", $stmt->error);

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

        printf("Error: $s.\n", $stmt->error);

        return false;
    }
}
