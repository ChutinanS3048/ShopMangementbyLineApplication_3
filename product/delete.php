<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {	
	  include '../resources/config/database.php';
	  $sql = "DELETE FROM product WHERE product_id=".$_POST["idForm"].";";

		if ($conn->query($sql) === TRUE) {
			$conn->close();
			//header( "refresh: 2; url=/shop/category" );
			//exit(0); 
		} else {
			echo "Error deleting record: " . $conn->error;
		}
	$conn->close();
	//header( "refresh: 2; url=/shop/category" );
	//exit(0);  
  	}
  	else{
		header( "refresh: 2; url=/shop/category" );
		exit(0);  
  }
?>