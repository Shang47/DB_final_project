<?php  
session_start();

# If the admin is logged in
if (isset($_SESSION['user_id']) &&
    isset($_SESSION['user_email'])) {

	# Database Connection File
	include "../db_conn.php";


    /** 
	  check if admin 
	  name is submitted
	**/
	if (isset($_POST['admin_name']) &&
        isset($_POST['admin_buy']) &&
        isset($_POST['admin_send']) &&
        isset($_POST['admin_id'])) {
		/** 
		Get data from POST request 
		and store them in var
		**/
		$name = $_POST['admin_name'];
		$id = $_POST['admin_id'];
        $buy = $_POST['admin_buy'];
		$send = $_POST['admin_send'];
        $fb = $_POST['admin_fb'];

		#simple form Validation
		if (empty($name)) {
			$em = "請輸入名稱";
			header("Location: ../edit-admin.php?error=$em&id=$id");
            exit;
		}else if (empty($buy)) {
			$em = "請填入購買方式";
			header("Location: ../edit-admin.php?error=$em&id=$id");
            exit;
		}else if (empty($send)) {
			$em = "請填入寄件資料";
			header("Location: ../edit-admin.php?error=$em&id=$id");
            exit;
		}else if (empty($fb)) {
			$em = "請填入個人FB網址";
			header("Location: ../edit-admin.php?error=$em&id=$id");
            exit;
		}else {
			# UPDATE the Database
			$sql  = "UPDATE admin
			         SET full_name=?,
                     購買方式=?,
                     寄送方式=?,
                     fb網址=?
			         WHERE id=?";
			$stmt = $conn->prepare($sql);
			$res  = $stmt->execute([$name, $buy, $send, $fb, $id]);

			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Successfully updated!";
				header("Location: ../edit-admin.php?success=$sm&id=$id");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../edit-admin.php?error=$em&id=$id");
	            exit;
		     }
		}
	}else {
      header("Location: ../admin.php");
      exit;
	}

}else{
  header("Location: ../login.php");
  exit;
}