<?php

class Book
{
    // DB stuff
    private $conn;
    private $table = 'book';

    // Post Properties
    public $id;
    public $name;
    public $pages;
    public $is_borrowed;
    public $user_id;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function read()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table;

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
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

        $this->name = $row['name'];
        $this->pages = $row['pages'];
        $this->is_borrowed = $row['is_borrowed'];
        $this->user_id = $row['user_id'];
    }

    // Create Post
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, pages = :pages, is_borrowed = :is_borrowed, user_id = :user_id';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->pages = htmlspecialchars(strip_tags($this->pages));
        $this->is_borrowed = htmlspecialchars(strip_tags($this->is_borrowed));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':pages', $this->pages);
        $stmt->bindParam(':is_borrowed', $this->is_borrowed);
        $stmt->bindParam(':user_id', $this->user_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Post
    public function update()
    {
        $query = 'UPDATE ' . $this->table . '
                                SET name = :name, pages = :pages, is_borrowed = :is_borrowed, user_id = :user_id
                                WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->pages = htmlspecialchars(strip_tags($this->pages));
        $this->is_borrowed = htmlspecialchars(strip_tags($this->is_borrowed));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':pages', $this->pages);
        $stmt->bindParam(':is_borrowed', $this->is_borrowed);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':id', $this->id);

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