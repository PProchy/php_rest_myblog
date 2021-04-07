<?php

class Address
{
    // DB Stuff
    private $conn;
    private $table = 'address';

    // Properties
    public $id;
    public $street;
    public $house_number;
    public $postal_code;
    public $city;
    public $state;

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
        $this->street = $row['street'];
        $this->house_number = $row['house_number'];
        $this->postal_code = $row['postal_code'];
        $this->city = $row['city'];
        $this->state = $row['state'];
    }

    public function create()
    {
        $query = 'INSERT INTO ' .
            $this->table . '
    SET
      street = :street,
      house_number = :house_number,
      postal_code = :postal_code,
      city = :city,
      state = :state';


        $stmt = $this->conn->prepare($query);

        $this->street = htmlspecialchars(strip_tags($this->street));
        $this->house_number = htmlspecialchars(strip_tags($this->house_number));
        $this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));

        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house_number', $this->house_number);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: $s.\n", $stmt->error);

        return false;
    }

    public function update()
    {
        $query = 'UPDATE ' .
            $this->table . '
    SET
      street = :street,
      house_number = :house_number,
      postal_code = :postal_code,
      city = :city,
      state = :state
      WHERE
      id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->street = htmlspecialchars(strip_tags($this->street));
        $this->house_number = htmlspecialchars(strip_tags($this->house_number));
        $this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house_number', $this->house_number);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);

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
