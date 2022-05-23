<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {	  
		$category = $_POST["categoryForm"];
		$comment = $_POST["commentForm"];
	  
		include '../resources/config/database.php';
	  
		$sql = "INSERT INTO `shop`.`category` (`name`, `comment`) VALUES ('".$category."', '".$comment."');";

			if ($conn->query($sql) === TRUE) {

			$conn->close();
  
   			//header( "refresh: 2; url=/shop/category" );
			//exit(0);    
			} else {
		  	echo "Error: " . $sql . "<br>" . $conn->error;
			}

	$conn->close();
	  
	}else{	
	   	header( "refresh: 2; url=/shop/category" );
		exit(0);
	}
?>