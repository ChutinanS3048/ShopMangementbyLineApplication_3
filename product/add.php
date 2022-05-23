<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {	
		$productId = $_POST["productIdForm"];  
		$categoryId = $_POST["categoryIdForm"];
		$product = $_POST["productForm"];
		$cost = $_POST["costForm"];		
		$price = $_POST["priceForm"];	
		$inventory = $_POST["inventoryForm"];			
	  
		include '../resources/config/database.php';
	  
		$sql = "INSERT INTO product (product_id, category_id, `name`, cost, price, inventory) \n
				VALUES (".$productId.", ".$categoryId.", '".$product."', ".$cost.", ".$price.", ".$inventory.");";
				 
			if ($conn->query($sql) === TRUE) {

			$conn->close();
   
			} else {
		  	echo "Error: " . $sql . "<br>" . $conn->error;
			}

	$conn->close();
	  
	}else{	
	   	header( "refresh: 2; url=/shop/product" );
		exit(0);
	}
?>