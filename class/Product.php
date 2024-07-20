<?php
class Product{
    public $id;
    public $tensp;
    public $img;
    public $gia;
    public $iddanhmuc;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM product";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Product");
            return $stmt->fetchall();
        }
    }

    public static function getOneByID ($pdo, $id)
    {
        $sql = "SELECT * product WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindPram(":id",$id,PDO::PARAM_INT);

        if ($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS,"product");
            return $stmt->fetch();
        }
    }
    public static function getProductByCategory($pdo, $category_id) {
        $sql = "SELECT * FROM product WHERE category_id=:category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, "Product");
            return $stmt->fetchAll();
        }
    }
    public static function hien_thi_so_trang($dssp,$soluongsp){
        $tongsanpham=count($dssp);
        $sotrang=ceil($tongsanpham/$soluongsp);
        $html_sotrang="";
        for ($i=1; $i <=$sotrang ; $i++) { 
            $html_sotrang.='<a href="index.php?pg=products&page='.$i.'">'.$i.'</a> ';
        }
        return $html_sotrang;
    }
    public static function so_trang($dssp,$soluongsp){
        $tongsanpham=count($dssp);
        $sotrang=ceil($tongsanpham/$soluongsp);
        return $sotrang;
    }

    public static function get_dssp_admin($pdo,$kyw,$page,$soluongsp){

        // kiểm tra đang ở trang nào? tạo limit
        // if(($page="")||($page=0)) $page=1;
        
        $batdau=($page-1)*$soluongsp;
         
    
        $sql = "SELECT * FROM product WHERE 1";
        if($kyw!=""){
            $sql .= " AND name like ?";
            $sql .= " ORDER BY id DESC";
            $sql .= " LIMIT ".$batdau.",".$soluongsp;
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute()){
            $stmt->setFetchMode(PDO::FETCH_CLASS,"Product");
            return $stmt->fetchall();
            }
        }
        else{
            $sql .= " ORDER BY id DESC";
            $sql .= " LIMIT ".$batdau.",".$soluongsp;
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute()){
                $stmt->setFetchMode(PDO::FETCH_CLASS,"Product");
                return $stmt->fetchall();
            }
        }
    
        
    }
}

?>
