<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {
	

	# Database Connection File
	include "db_conn.php";

    # Category helper function
	include "php/func-category.php";
    $categories = get_all_categories($conn);

    # author helper function
	include "php/func-author.php";
    $authors = get_all_author($conn);

	# admin helper function
	include "php/func-admin.php";
    $admin = get_admin($conn, $_SESSION["user_id"]);

    if (isset($_GET['title'])) {
    	$title = $_GET['title'];
    }else $title = '';

    if (isset($_GET['desc'])) {
    	$desc = $_GET['desc'];
    }else $desc = '';

    if (isset($_GET['category_id'])) {
    	$category_id = $_GET['category_id'];
    }else $category_id = 0;

    if (isset($_GET['author_id'])) {
    	$author_id = $_GET['author_id'];
    }else $author_id = 0;

	if (isset($_GET['price'])) {
    	$price = $_GET['price'];
    }else $price = '';

	if (isset($_GET['size'])) {
    	$size = $_GET['size'];
    }else $size = '';

	if (isset($_GET['brand'])) {
    	$brand = $_GET['brand'];
    }else $brand = "無";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>新增商品</title>

    <!-- bootstrap 5 CDN-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <!-- bootstrap 5 Js bundle CDN-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="admin.php">個人管理頁面</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" 
		         id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		        <li class="nav-item">
		          <a class="nav-link" 
		             aria-current="page" 
		             href="index.php">進入商店</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-book.php">增加商品</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-category.php">增加作品</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="add-author.php">增加角色</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link" 
		             href="logout.php">登出</a>
		        </li>
		      </ul>
		    </div>
		  </div>
		</nav>
     <form action="php/add-book.php"
           method="post"
           enctype="multipart/form-data" 
           class="shadow p-4 rounded mt-5"
           style="width: 90%; max-width: 50rem;">

     	<h1 class="text-center pb-5 display-4 fs-3">
     		新增商品
     	</h1>
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
     	<div class="mb-3">
		    <label class="form-label">
		           商品名稱
		           </label>
		    <input type="text" 
		           class="form-control"
		           value="<?=$title?>" 
		           name="book_title">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           商品描述
		           </label>
		    <input type="text" 
		           class="form-control" 
		           value="<?=$desc?>"
		           name="book_description">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           商品價格
		           </label>
		    <input type="text" 
		           class="form-control"
		           value="<?=$price?>" 
		           name="book_price">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           尺寸(S,M,L,X)
		           </label>
		    <input type="text" 
		           class="form-control"
		           value="<?=$size?>" 
		           name="size">
		</div>

		

		<div class="mb-3">
		    <input type="text" 
		           class="form-control"
		           value="<?=$admin['id'] ?>" 
				   hidden
		           name="vendor">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           廠牌
		           </label>
		    <input type="text" 
		           class="form-control"
		           value="<?=$brand?>" 
		           name="brand">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           作品來源
		           </label>
		    <select name="book_category"
		            class="form-control">
		    	    <option value="0">
		    	    	選擇作品
		    	    </option>
		    	    <?php 
                    if ($categories == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($categories as $category) { 
		    	    	if ($category_id == $category['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$category['id']?>">
		    	    	  <?=$category['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$category['id']?>">
							<?=$category['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           角色
		           </label>
		    <select name="book_author"
		            class="form-control">
		    	    <option value="0">
		    	    	選擇角色
		    	    </option>
		    	    <?php 
                    if ($authors == 0) {
                    	# Do nothing!
                    }else{
		    	    foreach ($authors as $author) { 
		    	    	if ($author_id == $author['id']) { ?>
		    	    	<option 
		    	    	  selected
		    	    	  value="<?=$author['id']?>">
		    	    	  <?=$author['name']?>
		    	        </option>
		    	        <?php }else{ ?>
						<option 
							value="<?=$author['id']?>">
							<?=$author['name']?>
						</option>
		    	   <?php }} } ?>
		    </select>
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           商品照片
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="book_cover">
		</div>

		<div class="mb-3">
		    <label class="form-label">
		           其它照片
		           </label>
		    <input type="file" 
		           class="form-control" 
		           name="file">
		</div>

	    <button type="submit" 
	            class="btn btn-primary">
	            新增商品</button>
     </form>
	</div>
</body>
</html>

<?php }else{
  header("Location: login.php");
  exit;
} ?>