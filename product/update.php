<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["idForm"];
    $product = $_POST["productForm"];    
    $cost = $_POST["costForm"];
    $price = $_POST["priceForm"];        
    $inventory = $_POST["inventoryForm"];    

	  include '../resources/config/database.php';
      $sql = "UPDATE product SET `name`='".$product."', cost = ".$cost.", price = ".$price.", inventory = ".$inventory.
      " WHERE product_id ='".$id."';";

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