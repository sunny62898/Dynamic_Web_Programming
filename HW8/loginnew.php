<!DOCTYPE html>

<!-- Fig. 19.16: database.php -->
<!-- Querying a database and displaying the results. -->
<html>
	<head>
		<meta charset = "utf-8">
		<title>test</title>
   
	</head>
	<body>
		<form method = "get" action = "loginnew.php">
			<h2>Login</h2>

			<!-- create four text boxes for user input -->
			<label>account number:</label> 
            <input type = "text" name = "account">
			<label>password:</label>
            <input type = "text" name = "password"><br>
			<input type = "submit" value = "login" style="width:140px; height:50px;font-size:25px;font-weight:bolder">
		</form>
		
		<?php
			$account = $_GET["account"];
			$password = $_GET["password"];
			
			echo $account;
			echo $password;
			
			$host = 'localhost';
			
			$connect = new mysqli($host, "player", "password", "blackjack");
			 
			if ($connect->connect_error) {
				die("連線失敗: " . $connect->connect_error);
			}
			echo "連線成功";
			 
			//設定連線編碼，防止中文字亂碼
			$connect->query("SET NAMES 'utf8'");
			 
			$insertSql = "INSERT INTO statistics (name, secret) VALUES ('".$account."','".$password."')";
			//呼叫query方法(SQL語法)
			$status = $connect->query($insertSql);
			 
			if ($status) {
				echo '新增成功';
				header("location:blackjackphp.html");
			} 
			else {
				echo "錯誤" . $insertSql . "<br>" . $connect->error;
				header("location:blackjackphp.html");
			}
			$connect->close();
		?>
	 
	 <!--**************************
    4108040040 魯姵妤 第八次作業12/23
    4108040040 PeiYuLuThe Eighth Homework 12/23
    **************************-->
	</body>
</html>