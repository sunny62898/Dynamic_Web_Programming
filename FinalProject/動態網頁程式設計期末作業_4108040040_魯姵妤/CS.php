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
			$name = $_GET["name"];
			$newID = $_GET["newID"];
			$cellphone = $_GET["cellphone"];
			$address = $_GET["address"];
			$email = $_GET["email"];
			$class = $_GET["class"];
			
			/*檢查email*/
			// Remove all illegal characters from email
			$email = filter_var($email, FILTER_SANITIZE_EMAIL);

			// Validate e-mail
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				echo("$email is a valid email address");
			} else {
				echo("$email is not a valid email address");
				header("location:createStudent.html");
			}
			
			
			//連線資料庫
			$host = '127.0.0.1';
			//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
			$connect = new mysqli($host, "student", "qhLq4K93qqm52THe", "final");
			 
			if ($connect->connect_error) {
				die("連線失敗: " . $connect->connect_error);
			}
			echo "連線成功";
			
			//檢查有無重複
			$check = "SELECT name FROM student WHERE ID='$newID'";
			$result = $connect->query($check);

			if ($result->num_rows > 0) {
				echo "again";
				echo "<script>alert('Has been registered!')</script>";
				header("location:createStudent.html");
			}
			else {
				echo "0 results";
				//新增資料
				$sql = "INSERT INTO student(name,ID,cellphone,address,email,class)
				VALUES ('$name', $newID,$cellphone,'$address','$email',$class)";

				if ($connect->query($sql) === TRUE) {
				  echo "New record created successfully";
				} 
				else {
				  echo "Error: " . $sql . "<br>" . $connect->error;
				}

			}
			
			/*
			//新增資料
			$sql = "INSERT INTO student(name,ID,cellphone,address,email,class)
			VALUES ('$name', $newID,$cellphone,'$address','$email',$class)";

			if ($connect->query($sql) === TRUE) {
			  echo "New record created successfully";
			} 
			else {
			  echo "Error: " . $sql . "<br>" . $connect->error;
			}
			*/	
				
			$connect->close();
		
		?>
	 
	 
	</body>
</html>