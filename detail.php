<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
    
    # If book ID is not set
	if (!isset($_GET['id'])) {
		#Redirect to book.php page
        header("Location: book.php");
        exit;
	}

	$id = $_GET['id'];

	# Database Connection File
	include "db_conn.php";

  # admin helper function
  include "php/func-admin.php";
  $admin = get_all_admin($conn);

  # author helper function
  include "php/func-author.php";
  $authors = get_all_author($conn);

  # Category helper function
  include "php/func-category.php";
  $categories = get_all_categories($conn);

    # book helper function
	include "php/func-book.php";
    $book = get_book($conn, $id);
    
    # If the ID is invalid
    if ($book == 0) {
    	#Redirect to book.php page
        header("Location: book.php");
        exit;
    }
  }
?>

<!DOCTYPE html>
<!-- 從140行左右開始 -->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$book['title'] ?></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- gLightbox gallery-->
    <link rel="stylesheet" href="vendor/glightbox/css/glightbox.min.css">
    <!-- Range slider-->
    <link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
    <!-- Choices CSS-->
    <link rel="stylesheet" href="vendor/choices.js/public/assets/styles/choices.min.css">
    <!-- Swiper slider-->
    <link rel="stylesheet" href="vendor/swiper/swiper-bundle.min.css">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/favicon.png">
  </head>
  <body>
    <div class="page-holder bg-light">
      <!-- navbar-->
		<header class="header bg-white">
			<div class="container px-lg-3">
			<nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0"><a class="navbar-brand" href="index.html"><span class="fw-bold text-uppercase text-dark">COSTORE</span></a>
				<button class="navbar-toggler navbar-toggler-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto">
					<li class="nav-item">
					<!-- Link--><a class="nav-link" href="index.html">首頁</a>
					</li>
					<li class="nav-item">
					<!-- Link--><a class="nav-link active" href="index.php">商店</a>
					</li>
				</ul>
				<ul class="navbar-nav ms-auto">               
					<li class="nav-item"><a class="nav-link" href="#!"> 
					<?php if (isset($_SESSION['user_id'])) {?>
		          	<a class="nav-link" 
		             href="admin.php">個人設定</a>
		          <?php }else{ ?>
		          <a class="nav-link" 
		             href="login.php">登入</a>
		          <?php } ?></a></li>
				</ul>
				</div>
			</nav>
			</div>
		</header>
      <section class="py-5">
        <div class="container">
          <div class="row mb-5">
            <div class="col-lg-6">
              <!-- PRODUCT SLIDER-->
              <div class="row m-sm-0">
                <div class="col-sm-2 p-sm-0 order-2 order-sm-1 mt-2 mt-sm-0 px-xl-2">
                  <div class="swiper product-slider-thumbs">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="uploads/files/<?=$book['file']?>" alt="..."></div>
                      <div class="swiper-slide h-auto swiper-thumb-item mb-3"><img class="w-100" src="uploads/cover/<?=$book['cover']?>" alt="..."></div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-10 order-1 order-sm-2">
                  <div class="swiper product-slider">
                    <div class="swiper-wrapper">
                      <div class="swiper-slide h-auto"><a class="glightbox product-view" href="uploads/files/<?=$book['file']?>" data-gallery="gallery2" data-glightbox="Product item 1"><img class="img-fluid" src="uploads/files/<?=$book['file']?>" alt="..."></a></div>
                      <div class="swiper-slide h-auto"><a class="glightbox product-view" href="uploads/cover/<?=$book['cover']?>" data-gallery="gallery2" data-glightbox="Product item 2"><img class="img-fluid" src="uploads/cover/<?=$book['cover']?>" alt="..."></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- PRODUCT DETAILS-->
            <div class="col-lg-6">
            
              <h1><?=$book['title'] ?></h1>
              <p class="text-muted lead">$ <?=$book['price'] ?></p>

              <p class="text-sm mb-4">
                <strong class="text-uppercase">購買方式：</strong>
                  <?php foreach($admin as $user){ 
												if ($user['id'] == $book['賣家id']) {
													echo $user['購買方式'];
													break;
												}
											?>
									<?php } ?>
                <br>
                <strong class="text-uppercase">運送方式：</strong>
                <?php foreach($admin as $user){ 
												if ($user['id'] == $book['賣家id']) {
													echo $user['寄送方式'];
													break;
												}
											?>
									<?php } ?>
              </p>      
              
              <ul class="list-unstyled small d-inline-block">
                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">尺寸：</strong><span class="ms-2 text-muted"><?=$book['size'] ?></span></li>
                <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">作品：</strong><a class="reset-anchor ms-2" href="category.php?id=
                  <?php foreach($categories as $category){ 
												if ($category['id'] == $book['category_id']) {
													echo $category['id'];
													break;
												}
											?>
									<?php } ?>
                ">
                  <?php foreach($categories as $category){ 
												if ($category['id'] == $book['category_id']) {
													echo $category['name'];
													break;
												}
											?>
									<?php } ?>
                </a></li>
                <li class="px-3 py-2 mb-1 bg-white text-muted"><strong class="text-uppercase text-dark">角色：</strong><a class="reset-anchor ms-2" href="author.php?id=
                  <?php foreach($authors as $author){ 
												if ($author['id'] == $book['author_id']) {
													echo $author['id'];
													break;
												}
											?>
									<?php } ?>
                ">
                  <?php foreach($authors as $author){ 
												if ($author['id'] == $book['author_id']) {
													echo $author['name'];
													break;
												}
											?>
									<?php } ?>
                </a></li>
                <li class="px-3 py-2 mb-1 bg-white"><strong class="text-uppercase">廠牌：</strong><span class="ms-2 text-muted"><?=$book['廠牌'] ?></span></li>
              </ul>
              
              <div class="col-sm-5"><a class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0" href="
                <?php foreach($admin as $user){ 
                      if ($user['id'] == $book['賣家id']) {
                        echo $user['fb網址'];
                        break;
                      }
                    ?>
                <?php } ?>
              ">聯絡賣家</a></div>
          </div>
          <!-- DETAILS TABS-->
          <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link text-uppercase active" id="description-tab" data-bs-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">詳細說明</a></li>
            <li class="nav-item"><a class="nav-link text-uppercase" id="reviews-tab" data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="saler" aria-selected="false">賣家資料</a></li>
          </ul>
          <div class="tab-content mb-5" id="myTabContent">
            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
              <div class="p-4 p-lg-5 bg-white">
                <h6 class="text-uppercase">詳細說明</h6>
                <p class="text-muted text-sm mb-0"><?=$book['description']?></p>
              </div>
            </div>
            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
              <div class="p-4 p-lg-5 bg-white">
                <div class="row">
                  <div class="col-lg-8">
                    <div class="d-flex mb-3">
                      <div class="ms-3 flex-shrink-1">
                        <h6 class="mb-0 text-uppercase">
                        <?php foreach($admin as $user){ 
                              if ($user['id'] == $book['賣家id']) {
                                echo $user['full_name'];
                                break;
                              }
                            ?>
                        <?php } ?>
                        </h6>
                        <!-- <p class="small text-muted mb-0 text-uppercase">想加再加</p> -->
                        <p class="text-sm mb-0 text-muted">
                          <?php foreach($admin as $user){ 
                                if ($user['id'] == $book['賣家id']) {
                                  echo $user['fb網址'];
                                  break;
                                }
                              ?>
                          <?php } ?>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- JavaScript files-->
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/glightbox/js/glightbox.min.js"></script>
      <script src="vendor/nouislider/nouislider.min.js"></script>
      <script src="vendor/swiper/swiper-bundle.min.js"></script>
      <script src="vendor/choices.js/public/assets/scripts/choices.min.js"></script>
      <script src="js/front.js"></script>
      <script>
        // ------------------------------------------------------- //
        //   Inject SVG Sprite - 
        //   see more here 
        //   https://css-tricks.com/ajaxing-svg-sprite/
        // ------------------------------------------------------ //
        function injectSvgSprite(path) {
        
            var ajax = new XMLHttpRequest();
            ajax.open("GET", path, true);
            ajax.send();
            ajax.onload = function(e) {
            var div = document.createElement("div");
            div.className = 'd-none';
            div.innerHTML = ajax.responseText;
            document.body.insertBefore(div, document.body.childNodes[0]);
            }
        }
        // this is set to BootstrapTemple website as you cannot 
        // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
        // while using file:// protocol
        // pls don't forget to change to your domain :)
        injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 
        
      </script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    </div>
  </body>
</html>