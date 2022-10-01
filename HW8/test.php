<?php
	//$cookie_name = "user";
	//$cookie_value = "Sunny";
	//setcookie($cookie_name,$cookie_value,time()+(86400));
?>


<!DOCTYPE html>

<!-- Fig. 19.16: database.php -->
<!-- Querying a database and displaying the results. -->
<html>
   <head>
      <meta charset = "utf-8">
      <title>test</title>
   
   </head>
   <body>
     <?php
		$text = file_get_contents("blackjackphp.html");  //取出html中的資料
		preg_match("/([<]img id='poke7'[>])/i",$text,$match);
		print("$match");
		
	 
	 
		echo $_COOKIE["user"];
		echo "Hello";
		echo ($_GET["chip"]);
	 
		
	 ?>
	 
	 
   </body>
</html>

