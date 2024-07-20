<?php
session_start();
$title = 'Home page';
require_once '../class/Database.php'; 
require_once '../class/Product.php';
require_once '../class/Category.php';
require_once '../class/Auth.php';
$db = new Database();
$pdo = $db->getConnect();
$data = Product::getAll($pdo);
$categorys = Category::getAll($pdo);
include "../inc/header.php";
?>
<?php
// $db = new Database();
// $pdo = $db->getConnect();
// $data = Product::getAll($pdo);

// $limit = 10; // Số sản phẩm trên mỗi trang
// $page = isset($_GET['page']) ? $_GET['page'] : 1;
// $offset = ($page - 1) * $limit;

// // Truy vấn để lấy tổng số sản phẩm
// $total_query = "SELECT COUNT(*) as total FROM product";
// $total_stmt = $pdo->prepare($total_query);
// $total_stmt->execute();
// $total_row = $total_stmt->fetch(PDO::FETCH_ASSOC);
// $total = $total_row['total'];
// $total_pages = ceil($total / $limit);

// // Truy vấn để lấy sản phẩm cho trang hiện tại
// $query = "SELECT * FROM product LIMIT :limit OFFSET :offset";
// $stmt = $pdo->prepare($query);
// $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
// $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
// $stmt->execute();
// $products = $stmt->fetchAll(PDO::FETCH_OBJ);

?>
<section class="py-5">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="bootstrap-tabs product-tabs">
              <div class="tabs-header d-flex justify-content-between border-bottom my-5">
                <h3>All Category </h3>
              </div>
              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                  <div class="product-grid row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                  <?php
                  if(isset($_POST['timkiem'])){
                    $kyw=$_POST['kyw'];
                  }else{
                    $kyw="";
                  }
                  if(!isset($_GET['page'])){
                    $page=1;
                  }else{
                    $page=$_GET['page'];
                  }
                  $soluongsp=10;
                  // kiểm tra có phải form search không?
                  if(isset($_POST["timkiem"])&&($_POST["timkiem"])){
                    $kyw=$_POST["kyw"];
                    $titlepage="Kết quả tìm kiếm với từ khóa: <span>".$kyw."</span>";
                  }

                  $dssp=Product::get_dssp_admin($pdo,$kyw,$page,$soluongsp);
                  $tongsosp=Product::getAll($pdo);
                  $sotrang = Product::so_trang($tongsosp,$soluongsp);
                  $hienthisotrang=Product::hien_thi_so_trang( $tongsosp,$soluongsp);?>
                    <?php foreach ($dssp as $product): ?>
                      <div class="col">
                        <div class="product-item">
                          <a href="#" class="btn-wishlist">
                            <svg width="24" height="24"><use xlink:href="#heart"></use></svg>
                          </a>
                          <figure> <a href="single-product.html" title="<?=$product->name;?>">
                              <img src="../<?=$product->image?>" class="tab-image fixed-height">
                            </a>
                           
                          </figure>
                          <div class="product-title">
                            <h3><?=$product->name;?></h3>
                          </div>                      
                          <span class="qty">1 Unit</span>
                          <span class="rating">
                            <svg width="24" height="24" class="text-primary">
                              <use xlink:href="#star-solid"></use>
                            </svg> 4.5
                          </span>
                          <span class="price"><?=$product->price?></span>
                          <div class="d-flex align-items-center justify-content-between">
                            <div class="input-group product-qty">
                              <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus">
                                  <svg width="16" height="16"><use xlink:href="#minus"></use></svg>
                                </button>
                              </span>
                              <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="10">
                              <span class="input-group-btn">
                                <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus">
                                  <svg width="16" height="16"><use xlink:href="#plus"></use></svg>
                                </button>
                              </span>
                            </div>
                            <button class="btn btn-primary add-to-cart">Add to Cart</button>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
           </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- Phân trang -->
    <style >
      .pagination { 
        display: flex;
    justify-content: center;
  margin-top: 20px;
  text-align: center;
}

.pagination a {
 
  display: inline-block;
  padding: 8px 16px;
  margin: 0 4px;
  border: 1px solid #ccc;
  background-color: #f7f7f7;
  color: #333;
  text-decoration: none;
  border-radius: 4px;
}

.pagination a:hover {
  background-color: #f7a422;
  
}

.pagination .current {
  background-color: #ffc43f;
  color: white;
}


    </style>
    <?php
    // Lấy số trang hiện tại từ URL (mặc định là 1)
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    ?>
    <div class="pagination ">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>"> Previous </a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $sotrang; $i++): ?>
        <a href="?page=<?= $i ?>"> <?= $i ?> </a>
    <?php endfor; ?>
    <?php if ($page < $sotrang): ?>
        <a href="?page=<?= $page + 1 ?>"> Next </a>
    <?php endif; ?>
   </div>
<?php
   include "../inc/footer.php";

?>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="js/plugins.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>

