<?php
class Category{
    public $id;
    public $name;
    public $image;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM category";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Category");
            return $stmt->fetchall();
        }
    }

    public static function getOneByID ($pdo, $id)
    {
        $sql = "SELECT * category WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindPram(":id",$id,PDO::PARAM_INT);

        if ($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Category");
            return $stmt->fetch();
        }
    }
}

?>
