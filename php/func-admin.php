<?php 

# Get  user by ID function
function get_admin($con, $id){
   $sql  = "SELECT * FROM admin WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $admin = $stmt->fetch();
   }else {
      $admin = 0;
   }

   return $admin;
}