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

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get addresses
    public function read()
    {
        // Create query
        $query = 'SELECT
        id, street, house_number, postal_code, city, state
      FROM
        ' . $this->table . '
      ORDER BY
        id DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Address
    public function read_single()
    {
        // Create query
        $query = 'SELECT
          id, street, house_number, postal_code, city, state
        FROM
          ' . $this->table . '
      WHERE id = ?';

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->id = $row['id'];
        $this->street = $row['street'];
        $this->house_number = $row['house_number'];
        $this->postal_code = $row['postal_code'];
        $this->city = $row['city'];
        $this->state = $row['state'];
    }

    // Create Category
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' .
            $this->table . '
    SET
      street = :street,
      house_number = :house_number,
      postal_code = :postal_code,
      city = :city,
      state = :state';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->street = htmlspecialchars(strip_tags($this->street));
        $this->house_number = htmlspecialchars(strip_tags($this->house_number));
        $this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));

        // Bind data
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house_number', $this->house_number);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }

    // Update Category
    public function update()
    {
        // Create Query
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

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->street = htmlspecialchars(strip_tags($this->street));
        $this->house_number = htmlspecialchars(strip_tags($this->house_number));
        $this->postal_code = htmlspecialchars(strip_tags($this->postal_code));
        $this->city = htmlspecialchars(strip_tags($this->city));
        $this->state = htmlspecialchars(strip_tags($this->state));

        // Bind data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':house_number', $this->house_number);
        $stmt->bindParam(':postal_code', $this->postal_code);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':state', $this->state);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }

    // Delete Category
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: $s.\n", $stmt->error);

        return false;
    }
}
