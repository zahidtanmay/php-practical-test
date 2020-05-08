<?php

class Ecommerce
{
    protected $servername = "localhost";
    protected $database = "ecommerce";
    protected $username = "root";
    protected $password = "secret";
    protected $connection = null;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection = $conn;
            echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getTaskOne()
    {
        $connection = $this->connection;
        $query = $connection->query("SELECT cat.Name as 'Category Name', COUNT(*) as 'Total Items' FROM category as cat RIGHT JOIN Item_category_relations as icr ON cat.id = icr.categoryId GROUP BY icr.categoryId ORDER BY COUNT(*) DESC");
        print_r($query->fetchAll());
    }

    public function getTaskTwo()
    {

    }
}

$ecommerce = new Ecommerce();
$ecommerce->getTaskOne();