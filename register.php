<?php  
session_start();

# If the admin is logged in
if (!isset($_SESSION['user_id']) &&
    !isset($_SESSION['user_email'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
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
	<title>Coshop | 註冊</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

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
				</ul>
				</div>
			</nav>
			</div>
		</header>
		<div class="d-flex justify-content-center align-items-center "
			style="min-height: 100vh;">
			<form class="p-5 rounded shadow"
				style="max-width: 30rem; width: 100%"
				method="POST"
				action="php/register.php">

			<h1 class="text-center display-4 pb-5">註冊帳號</h1>
			<?php if (isset($_GET['error'])) { ?>
			<div class="alert alert-danger" role="alert">
				<?=htmlspecialchars($_GET['error']); ?>
			</div>
			<?php } ?>

			<?php if (isset($_GET['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?=htmlspecialchars($_GET['success']); ?>
		  </div>
		<?php } ?>

			<div class="mb-3 ">
				<label for="exampleInputEmail1" 
					class="form-label">名字</label>
				<input type="text" 
					class="form-control" 
					name="name" 
					id="exampleInputEmail1" 
					aria-describedby="emailHelp"
					placeholder="摳死不累">
			</div>

			<div class="mb-3 ">
				<label for="exampleInputEmail1" 
					class="form-label">fb連結</label>
				<input type="text" 
					class="form-control" 
					name="fb_link" 
					id="exampleInputEmail1" 
					aria-describedby="emailHelp"
					placeholder="https://www.facebook.com/Cosplay/">
			</div>

			<div class="mb-3 ">
				<label for="exampleInputEmail1" 
					class="form-label">信箱</label>
				<input type="email" 
					class="form-control" 
					name="email" 
					id="exampleInputEmail1" 
					aria-describedby="emailHelp"
					placeholder="cosplay@example.com">
			</div>

			<div class="mb-3">
				<label for="exampleInputPassword1" 
					class="form-label">密碼</label>
				<input type="password" 
					class="form-control" 
					name="password" 
					id="exampleInputPassword1">
			</div>

			<div class="mb-3 ">
				<label for="exampleInputPurchase1" 
					class="form-label">可提供的購買方式</label>
				<input type="text" 
					class="form-control" 
					name="purchase_means" 
					id="exampleInputPurchase1" 
					>
			</div>

			<div class="mb-3 ">
				<label for="exampleInputLogi1" 
					class="form-label">寄送方式</label>
				<input type="text" 
					class="form-control" 
					name="delivery_method" 
					id="exampleInputLogi1" 
					>
			</div>

			<button type="submit" 
					class="btn btn-primary btn-large">
					註冊</button>
					<a href="login.php">登入</a>
			</form>
			
		</div>
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

<?php }else{
  header("Location: admin.php?loggedin=true");
  exit;
} ?>