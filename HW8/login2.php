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
			$account = $_GET["account"];
			$password = $_GET["password"];
			
			echo $account;
			echo $password;
			
			$host = '127.0.0.1';
			
			//實例化mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
			$connect = new mysqli($host, $account, $password, "blackjack");
			 
			if ($connect->connect_error) {
				die("連線失敗: " . $connect->connect_error);
				header("location:loginnew.php");
			}
			echo "連線成功";
		
		?>
	 
	 
	</body>
</html>