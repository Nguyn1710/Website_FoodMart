<?php
session_start();
$title = 'Home page';
require_once 'class/Database.php'; 
require_once 'class/Product.php';
require_once 'class/Category.php';
require_once 'class/Auth.php';
$db = new Database();
$pdo = $db->getConnect();
$data = Product::getAll($pdo);
$categorys = Category::getAll($pdo);
    ob_start();

    include "inc/header.php";
    if(!isset($_GET['pg'])){

        include 'include/home.php';
    }else{
        switch ($_GET['pg']) {
            case 'product':
                header('include/all-category.php');
                break;
            case 'login':
              include "include/login.php";
              break;
            case 'signup':
                include "include/signup.php";
                break;
            case 'logout':
                if (isset($_SESSION['user']) && ($_SESSION['user']!="") ){
                    unset($_SESSION['user']);
                    header('location:index.php');
                  }
                break;
            case 'updateuser':
                break;
            
            case 'about':
                include "include/about.php";
                break;
            case 'contact':
                  include "include/contact.php";
                  break;
            case 'home':
                include "include/home.php";
                break;
        }
    }
    

    include "inc/footer.php";

?>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>