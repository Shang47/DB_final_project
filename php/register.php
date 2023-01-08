<?php  
session_start();

# If not logged in
if (!isset($_SESSION['user_id']) ||
    !isset($_SESSION['user_email'])) {
    

	# Database Connection File
	include "../db_conn.php";

    # Validation helper function
    include "func-validation.php";

    /** 
	  If all Input field
	  are filled
	**/
	if (isset($_POST['name'])          &&
        isset($_POST['email'])          &&
        isset($_POST['password'])       &&
		isset($_POST['purchase_means']) &&
        isset($_POST['delivery_method'])
       ) {
		/** 
		Get data from POST request 
		and store them in var
		**/
        $name = $_POST['name'];
        $email       = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
		$purchase_means       = $_POST['purchase_means'];
		$delivery_method      = $_POST['delivery_method'];
        $fb_link              = $_POST['fb_link'];
		

/*
		# making URL data format
		$user_input = 'email='.$email.'&password='.$password.'&purchase_means='.$purchase_means.'&delivery_method='.$delivery_method;

		#simple form Validation

        $text = "Book title";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($title, $text, $location, $ms, $user_input);

		$text = "Book description";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($description, $text, $location, $ms, $user_input);

		$text = "Book author";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($author, $text, $location, $ms, $user_input);

		$text = "Book category";
        $location = "../add-book.php";
        $ms = "error";
		is_empty($category, $text, $location, $ms, $user_input);
        
 */
                # Insert the data into database
                $sql  = "INSERT INTO `admin` (
                    `full_name`,
                     `email`,
                     `fb網址`,
                     `password`,
                     `購買方式`, 
                     `寄送方式`) 
                     VALUES (?,?,?,?,?,?)";
        
            $stmt = $conn->prepare($sql);
            $res  = $stmt->execute([$name, $email, $fb_link, $password, $purchase_means, $delivery_method]);
                
			/**
		      If there is no error while 
		      inserting the data
		    **/
		     if ($res) {
		     	# success message
		     	$sm = "Account successfully created!";
				header("Location: ../register.php?success=$sm");
	            exit;
		     }else{
		     	# Error message
		     	$em = "Unknown Error Occurred!";
				header("Location: ../register.php?error=$em");
	            exit;
		     }

		    
	    

		
	}else {
      header("Location: ../admin.php");
      exit;
	}

} else{
  header("Location: ../login.php");
  exit;
}
