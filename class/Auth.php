<?php
class Auth {
    public $id;
    public $name;
    public $email;
    public $password;

    // public function login($username, $password) {
    //     if ($this->get_by_User($username)) {
    //         if (password_verify($password, $this->password_hash)) {
    //             session_start();
    //             $_SESSION["user"] = $username;
    //             $_SESSION["logged_in"] = true;
    //             return true;
    //         }
    //     }
    //     return false;
    // }
    // public static function checkuser($pdo , $email,$password){
    //     $sql="SELECT * FROM user WHERE email=? AND password=?";
    //     $sql_args = array_slice(func_get_args(), 1);
    //     $stmt = $pdo->prepare($sql);

    //     if ($stmt->execute($sql_args))
    //     {
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //         return $row;
    //     }
    //     else return null;
    // }
    public static function checkuser($pdo, $email, $password) {
        // Câu truy vấn SQL để chọn người dùng dựa trên email
        $sql = "SELECT * FROM user WHERE email=?";
        $stmt = $pdo->prepare($sql);
    
        if ($stmt->execute([$email])) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Kiểm tra xem người dùng có tồn tại và mật khẩu có khớp không
            if ($row && password_verify($password, $row['password'])) {
                return $row;
            }
        }
        
        // Trả về null nếu không tìm thấy người dùng hoặc mật khẩu không khớp
        return null;
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
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function is_logged_in() {
        session_start();
        return isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true;
    }

    public function get_user() {
        session_start();
        return $_SESSION["user"] ?? null;
    }

}
?>
