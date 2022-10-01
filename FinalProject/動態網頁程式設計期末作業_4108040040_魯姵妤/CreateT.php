<!DOCTYPE html>
<html>
<head>
    <title></title>
	<meta charset="utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <style>
        input[type=text], select ,input[type=tel],input[type=email],input[type=password]{
            width: 200px;
            padding: 12px 20px;
            margin: 8px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            

        }
        body{
             font-family:"Audiowide", sans-serif;
        }
		
		.error{
			color:red;
		}
    </style>
	<?php
		/*設置control*/
		if(!isset($_COOKIE["control"])){
			$cookie_name = "control";
			$cookie_value = 0;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			$control = 0;   //檢查chip
		}
		else{
			$control = $_COOKIE["control"];
		}
	
	?>
	
	
</head>
<body>
	<?php
		/*設置control
		if(!isset($_COOKIE["control"])){
			$cookie_name = "control";
			$cookie_value = 0;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			$control = 0;   //檢查chip
		}
		else{
			$control = $_COOKIE["control"];
		}*/
		
		//輸入資料後
		if($control == 2){
			/*檢查輸入資料*/
			$name = $_POST["name"];
			$newID = $_POST["newID"];
			$password = $_POST["password"];
			$cellphone = $_POST["cellphone"];
			$address = $_POST["address"];
			$email = $_POST["email"];
			
			/*輸入為空白*/
			if($name == "" || $newID == "" || $password == "" || $cellphone == "" || $address == "" ||$email == ""){
				$cookie_name = "control";
				$cookie_value = 33;
				setcookie($cookie_name,$cookie_value,time()+(86400));
				header("location:CreateT.php");
			}
			
			else{
				/*檢查email*/
				// Remove all illegal characters from email
				$email = filter_var($email, FILTER_SANITIZE_EMAIL);

				// Validate e-mail
				if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo("$email is a valid email address");
				} else {
					echo("$email is not a valid email address");
				}
				
				//連線資料庫
				$host = '127.0.0.1';
				//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
				$connect = new mysqli($host,"teacher", "password", "final");
				 
				if ($connect->connect_error) {
					die("連線失敗: " . $connect->connect_error);
				}
				echo "連線成功";
				
				//檢查有無重複
				$check = "SELECT name FROM teacher WHERE ID='$newID'";
				$result = $connect->query($check);
				if ($result->num_rows > 0) {
					echo "again";
					//echo "<script>alert('Has been registered!')</script>";
					$cookie_name = "control";
					$cookie_value = 66;
					setcookie($cookie_name,$cookie_value,time()+(86400));
					header("location:CreateT.php");
				}
				else {
					echo "0 results";
					//新增資料
					$sql = "INSERT INTO teacher(name,ID,password,cellphone,address,email)
					VALUES ('$name', '$newID','$password','$cellphone','$address','$email')";

					if ($connect->query($sql) === TRUE) {
					  echo "New record created successfully";
					  header("location:sucess.php?s=1");
					} 
					else {
					  echo "Error: " . $sql . "<br>" . $connect->error;
					}
				}
			}
			
			
		}
		
		
		//輸入資料前
		if($control == 0){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
			<center>
				<h1>Create a new account</h1>

				<form method = "post" action="CreateT.php">

					<label style="font-size:20px">NAME:</label>
					<input type="text" id="name" name="name"><br>
					<label style="font-size:20px">ID number:</label>
					<input type="text" id="newID" name="newID"><br>
					<label style="font-size:20px">password:</label>
					<input type="password" id="password" name="password"><br>
					<label style="font-size:20px">cellphone number:</label>
					<input type="tel" id="cellphone" name="cellphone"><br>
					<label style="font-size:20px">Adress:</label>
					<input type="text" id="address" name="address"><br>
					<label style="font-size:20px">e-mail:</label>
					<input type="email" id="email" name="email"><br>
					<br><input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

				</form>
			</center>';
			/*$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			*/
		}
		
		//再輸入一次
		if($control == 66){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
			
			<center>
				<h1>Create a new account</h1>
				<h2 class="error">Has been registered!</h2>
				<form method = "post" action="CreateT.php">

					<label style="font-size:20px">NAME:</label>
					<input type="text" id="name" name="name"><br>
					<label style="font-size:20px">ID number:</label>
					<input type="text" id="newID" name="newID"><br>
					<label style="font-size:20px">password:</label>
					<input type="password" id="password" name="password"><br>
					<label style="font-size:20px">cellphone number:</label>
					<input type="tel" id="cellphone" name="cellphone"><br>
					<label style="font-size:20px">Adress:</label>
					<input type="text" id="address" name="address"><br>
					<label style="font-size:20px">e-mail:</label>
					<input type="email" id="email" name="email"><br>
					<br><input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

				</form>
			</center>';
		}
		
		//再輸入一次(空白)
		if($control == 33){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
			
			<center>
				<h1>Create a new account</h1>
				<h2 class="error">Cannot be null!</h2>
				<form method = "post" action="CreateT.php">

					<label style="font-size:20px">NAME:</label>
					<input type="text" id="name" name="name"><br>
					<label style="font-size:20px">ID number:</label>
					<input type="text" id="newID" name="newID"><br>
					<label style="font-size:20px">password:</label>
					<input type="password" id="password" name="password"><br>
					<label style="font-size:20px">cellphone number:</label>
					<input type="tel" id="cellphone" name="cellphone"><br>
					<label style="font-size:20px">Adress:</label>
					<input type="text" id="address" name="address"><br>
					<label style="font-size:20px">e-mail:</label>
					<input type="email" id="email" name="email"><br>
					<br><input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

				</form>
			</center>';
		}
		
		//mysqli_close($connect);
	?>

	<!--
    <center>
        <h1>Create a new account</h1>

        <form method = "get" action="CreateT.php">

            <label style="font-size:20px">NAME:</label>
            <input type="text" id="name" name="name"><br>
            <label style="font-size:20px">ID number:</label>
            <input type="text" id="newID" name="newID"><br>
            <label style="font-size:20px">cellphone number:</label>
            <input type="tel" id="cellphone" name="cellphone"><br>
            <label style="font-size:20px">Adress:</label>
            <input type="text" id="address" name="address"><br>
            <label style="font-size:20px">e-mail:</label>
            <input type="email" id="email" name="email"><br>
            <br><input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

        </form>
    </center>
	-->
</body>
</html>
