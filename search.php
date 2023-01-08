<?php 
session_start();

# If search key is not set or empty
if (!isset($_GET['key']) || empty($_GET['key'])) {
	header("Location: index.php");
	exit;
}
$key = $_GET['key'];

if (isset($_GET['sort']) || !empty($_GET['sort'])) {
	$sort = $_GET['sort'];
}else{
	$sort = 'none';
}

# Database Connection File
include "db_conn.php";

# Book helper function
include "php/func-book.php";
$books = search_books($conn, $key, $sort);

# author helper function
include "php/func-author.php";
$authors = get_all_author($conn);

# Category helper function
include "php/func-category.php";
$categories = get_all_categories($conn);
 $count = 0;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Coshop | 二手買賣網-搜索</title>
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
	
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="page-holder">
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
					<li class="nav-item">
					<!-- Link--><a class="nav-link" href="detail.html">商品頁面之後要刪掉</a>
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
		<!--  Modal -->
		<?php if ($books != 0){ ?>
			<?php  $i = 0; foreach ($books as $book) {  $i++;$count++;?>
				<div class="modal fade" id="productView<?=$i?>" tabindex="-1">
					<div class="modal-dialog modal-lg modal-dialog-centered">
						<div class="modal-content overflow-hidden border-0">
							<button class="btn-close p-4 position-absolute top-0 end-0 z-index-20 shadow-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
							<div class="modal-body p-0">
								<div class="row align-items-stretch">
									<div class="col-lg-6 p-lg-0"><a class="glightbox product-view d-block h-100 bg-cover bg-center" style="background: url(uploads/cover/<?=$book['cover']?>)" href="uploads/cover/<?=$book['cover']?>" data-gallery="gallery1" data-glightbox="Red digital smartwatch"></a>
									<a class="glightbox d-none" href="uploads/files/<?=$book['file']?>" data-gallery="gallery2" data-glightbox="Red digital smartwatch"></a>
									<a class="glightbox d-none" href="uploads/files/<?=$book['file']?>" data-gallery="gallery3" data-glightbox="Red digital smartwatch"></a></div>
										<div class="col-lg-6">
											<div class="p-4 my-md-4">
												<h2 class="h4"><?=$book['title']?></h2>
												<p class="text-muted">$<?=$book['price']?></p>
												<p class="text-sm mb-4">
												<strong class="text-uppercase">角色名稱：</strong>
												<?php foreach($authors as $author){ 
													if ($author['id'] == $book['author_id']) {
														echo $author['name'];
														break;
													}
												?>
												<?php } ?>
												<br>
												<strong class="text-uppercase">作品名稱：</strong>
												<?php foreach($categories as $category){ 
														if ($category['id'] == $book['category_id']) {
															echo $category['name'];
															break;
														}
													?>
													<?php } ?>
												</p>
												<div class="row align-items-stretch mb-4 gx-0">
												<div class="col-sm-7">
												</div>
												<div class="col-sm-5"><a class="btn btn-dark btn-sm w-100 h-100 d-flex align-items-center justify-content-center px-0" href="detail.php?id=<?=$book['id']?>">查看詳細資訊</a></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		
		<div class="container">
			<!-- HERO SECTION-->
			<section class="py-5 bg-light">
			<div class="container">
				<div class="row px-4 px-lg-5 py-lg-4 align-items-center">
				<div class="col-lg-6">
					<h1 class="h2 text-uppercase mb-0 nd"><a href="index.php">商店</a> / 搜尋結果：「<?=$key?>」</h1>
				</div>
				<div class="col-lg-6 text-lg-end">
					<nav aria-label="breadcrumb">
					<ol class="breadcrumb justify-content-lg-end mb-0 px-0 bg-light">
						<li class="breadcrumb-item"><a class="text-dark" href="index.html">Coshop</a></li>
						<li class="breadcrumb-item active" aria-current="page">商店</li>
					</ol>
					</nav>
				</div>
				</div>
			</div>
			</section>
			<section class="py-5">
			<div class="container p-0">
				<div class="row">
					<!-- SHOP SIDEBAR-->
					<div class="col-lg-3 order-2 order-lg-1">
						<form action="search.php"
								method="get" 
								style="width: 100%; max-width: 30rem">

							<div class="input-group my-5">
							<input type="text" 
									class="form-control"
									name="key" 
									placeholder="輸入關鍵字..." 
									aria-label="輸入關鍵字..." 
									aria-describedby="basic-addon2">

							<button class="input-group-text
											btn btn-primary" 
									id="basic-addon2">
									<img src="img/search.png"
										width="20">

							</button>
							</div>
						</form>
						<br>
						<div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase fw-bold">尺寸</strong></div>
						<div class="form-check mb-1">
						<input class="form-check-input" type="checkbox" id="checkbox_1">
						<label class="form-check-label" for="checkbox_1">S</label>
						</div>
						<div class="form-check mb-1">
						<input class="form-check-input" type="checkbox" id="checkbox_2">
						<label class="form-check-label" for="checkbox_2">M</label>
						</div>
						<div class="form-check mb-1">
						<input class="form-check-input" type="checkbox" id="checkbox_3">
						<label class="form-check-label" for="checkbox_3">L</label>
						</div>
						<div class="form-check mb-1">
						<input class="form-check-input" type="checkbox" id="checkbox_4">
						<label class="form-check-label" for="checkbox_4">XL</label>
						</div>
						<br>
						<div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase fw-bold">作品名稱</strong></div>
							<?php foreach ($categories as $category ) {?>
						
								<a href="category.php?id=<?=$category['id']?>"
									class="list-group-item list-group-item-action">
									<?=$category['name']?></a>
							<?php  } ?>
						<br>
						<div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase fw-bold">角色名稱</strong></div>
						<?php foreach ($authors as $author ) {?>
							<a href="author.php?id=<?=$author['id']?>"
								class="list-group-item list-group-item-action">
								<?=$author['name']?></a>
							<?php } ?>
							<br>
						<div class="py-2 px-4 bg-dark text-white mb-3"><strong class="small text-uppercase fw-bold">價格</strong></div>
						<div class="price-range pt-4 mb-5">
						<div id="range"></div>
						<div class="row pt-2">
							<div class="col-6"><strong class="small fw-bold text-uppercase">最低</strong></div>
							<div class="col-6 text-end"><strong class="small fw-bold text-uppercase">最高</strong></div>
						</div>
						</div>

					</div>
					
					<!-- SHOP LISTING-->
					<div class="col-lg-9 order-1 order-lg-2 mb-5 mb-lg-0">
						<div class="row mb-3 align-items-center">
						<div class="col-lg-6 mb-2 mb-lg-0">

							<?php if($count>0) {?>
								<p class="text-sm text-muted mb-0">Showing 1–<?=$count?> of <?=$count?> results</p><!-- 這邊需要改!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!-->
							<?php }else{?>
								<p class="text-sm text-muted mb-0">Showing 0 results</p>
							<?php }?>
						</div>
						<div class="col-lg-6">
							<ul class="list-inline d-flex align-items-center justify-content-lg-end mb-0">
							<li class="list-inline-item">
								<select class="selectpicker" data-customclass="form-control form-control-sm">
								<option value>排序方式</option>
								<option value="default">最新商品</option>
								<option value="low-high">價格：由低到高</option>
								<option value="high-low">價格：由高到低</option>
								</select>
							</li>
							</ul>
						</div>
						</div>
						<div class="row">
						<?php if ($books != 0){ ?>
							<!-- PRODUCT-->
							<?php  $i = 0; foreach ($books as $book) {  $i++;?>
								<div class="col-lg-4 col-sm-6">
									<div class="product text-center">
									<div class="mb-3 position-relative">
										<div class="badge text-white bg-primary"><?=$book['size']?></div>	<!--class="img-fluid w-100"這原本在底下img裡-->
										<a class="d-block" href="detail.php?id=<?=$book['id']?>"><img width="316" height="316"  src="uploads/cover/<?=$book['cover']?>" alt="..."></a>
										<div class="product-overlay">
										<ul class="mb-0 list-inline">
											<li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-bs-toggle="modal">
												<?php foreach($authors as $author){ 
													if ($author['id'] == $book['author_id']) {
														echo $author['name'];
														break;
													}
												?>
												<?php } ?>
											</a></li>
											<li class="list-inline-item m-0 p-0"><a class="btn btn-sm btn-dark" href="#productView<?=$i?>" data-bs-toggle="modal">查看資訊</a></li>
											<li class="list-inline-item mr-0"><a class="btn btn-sm btn-outline-dark" href="#productView" data-bs-toggle="modal">
												<?php foreach($categories as $category){ 
														if ($category['id'] == $book['category_id']) {
															echo $category['name'];
															break;
														}
													?>
													<?php } ?>
											</a></li>
										</ul>
										</div>
									</div>
									<h6> <a class="reset-anchor" href="detail.php?id=<?=$book['id']?>" ><?=$book['title']?></a></h6>
									<p class="small text-muted">$<?=$book['price']?></p>
									</div>
								</div>
							<?php } ?>
						<?php }else{?>
						<div class="alert alert-warning 
										text-center p-5" 
								role="alert">
								<img src="img/empty.png" 
									width="100">
								<br>
							沒有找到商品
						</div>
					<?php }?>
					</div>
					
					</div>
			</div>
		</section>
		</div>
		
	</div>
	<div class="container">
		
		<!-- JavaScript files-->
		<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="vendor/glightbox/js/glightbox.min.js"></script>
      <script src="vendor/nouislider/nouislider.min.js"></script>
      <script src="vendor/swiper/swiper-bundle.min.js"></script>
      <script src="vendor/choices.js/public/assets/scripts/choices.min.js"></script>
      <script src="js/front.js"></script>
      <!-- Nouislider Config-->
      <script>
        var range = document.getElementById('range');
        noUiSlider.create(range, {
            range: {
                'min': 0,
                'max': 2000
            },
            step: 5,
            start: [100, 1000],
            margin: 300,
            connect: true,
            direction: 'ltr',
            orientation: 'horizontal',
            behaviour: 'tap-drag',
            tooltips: true,
            format: {
              to: function ( value ) {
                return '$' + value;
              },
              from: function ( value ) {
                return value.replace('', '');
              }
            }
        });
        
      </script>
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