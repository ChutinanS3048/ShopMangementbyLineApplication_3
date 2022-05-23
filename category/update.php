<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = $_POST["idForm"];
    $category = $_POST["categoryForm"];
    $comment = $_POST["commentForm"];    

	  include '../resources/config/database.php';
	  $sql = "UPDATE category SET `name`='".$category."', comment='".$comment."' WHERE category_id ='".$id."';";

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