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
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getTaskOne()
    {
        $connection = $this->connection;
        $query = "SELECT cat.Name, COUNT(icr.categoryId) as 'count' FROM category as cat LEFT JOIN Item_category_relations as icr ON cat.id = icr.categoryId GROUP BY cat.id, icr.categoryId ORDER BY COUNT(icr.categoryId) DESC";
        $statement = $connection->query($query);
        $this->connection = null;
        return $statement->fetchAll();
    }

    public function getTaskTwo()
    {
        $connection = $this->connection;
        $parentCategoryQuery = "SELECT * FROM category WHERE id NOT IN (SELECT categoryId FROM catetory_relations)";
        $statement = $connection->query($parentCategoryQuery);
        $parentCategories = $statement->fetchAll();
        foreach ($parentCategories as $index => $value)
        {
            $parentCategories[$index]['child'] = $this->getChildCategory($value['Id'], 0);
        }
        $this->connection = null;
        return $parentCategories;
    }

    private function getChildCategory($id, $level)
    {
        $connection = $this->connection;
        $childCategoryQuery = "SELECT cat.* FROM category as cat JOIN catetory_relations as car ON cat.Id = car.categoryId WHERE car.ParentcategoryId = $id";
        $statement = $connection->query($childCategoryQuery);
        $child = $statement->fetchAll();
        if (count($child) > 0) {
            $level++;
            foreach ($child as $i => $c){
                $child[$i]['child'.$level] = $this->getChildCategory($c['Id'], $level);
                $child[$i]['items'] = $this->getItemCount($c['Id']);
            }
        }

        return $child;
    }

    private function getItemCount($id)
    {
        $connection = $this->connection;
        $itemCountQuery = "SELECT * FROM Item_category_relations WHERE categoryId = $id";
        $count = $connection->prepare($itemCountQuery);
        $count->execute();
        return $count->rowCount();
    }
}
