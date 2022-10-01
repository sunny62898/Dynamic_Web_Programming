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
    </style>
	<script>
		
	
	</script>
	<?php
		/*設置control*/
		if(!isset($_COOKIE["control"])){
			$cookie_name = "control";
			$cookie_value = 0;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			$control = 0;  
		}
		else{
			$control = $_COOKIE["control"];
		}
		
		//設置IDnumber
		if(!isset($_COOKIE["IDnumber"])){
			$cookie_name = "IDnumber";
			$cookie_value = 0;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			$IDnumber = 0;
		}
		else{
			$IDnumber = $_COOKIE["IDnumber"];
		}
		
	?>
	
	
</head>
<body>
	<?php 
		
		//輸入資料後
		if($control == 2){
			$ST = $_POST["ST"];  //判斷是teacher還是student
			
			if($ST == 1){    //teacher
				/*檢查輸入資料*/
				$TeacherID = $_POST["TeacherID"];
				$ClassID = $_POST["ClassID"];
				$ClassPassword = $_POST["ClassPassword"];
				$time = $_POST["time"];
				
				if($TeacherID == ""){
					$TeacherID = $_COOKIE["IDnumber"];
				}
				
				
				//存ID
				$cookie_name = "IDnumber";
				$cookie_value = $TeacherID;   
				setcookie($cookie_name,$cookie_value,time()+(86400));
				
				/*輸入為空白*/
				if($ClassID == "" || $ClassPassword == "" || $time == ""){
					$cookie_name = "control";
					$cookie_value = 33;    //teacher有空白
					setcookie($cookie_name,$cookie_value,time()+(86400));
					header("location:homeT.html?$TeacherID");
				}
				
				else{
					
					//連線資料庫
					$host = '127.0.0.1';
					//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
					$connect = new mysqli($host,"teacher", "password", "final");
					 
					if ($connect->connect_error) {
						die("連線失敗: " . $connect->connect_error);
					}
					echo "連線成功";
					
					//檢查有無重複
					$check = "SELECT class FROM class WHERE class='$ClassID'";
					$result = $connect->query($check);
					if ($result->num_rows > 0) {
						echo "again";
						//echo "<script>alert('Has been registered!')</script>";
						$cookie_name = "control";
						$cookie_value = 2;
						setcookie($cookie_name,$cookie_value,time()+(86400));
						header("location:homeT.html?$TeacherID");
					}
					else {
						echo "0 results";
						//新增資料
						$sql = "INSERT INTO class(class,password,TeacherID,time,bool)
						VALUES ('$ClassID','$ClassPassword','$TeacherID','$time','0')";

						if ($connect->query($sql) === TRUE) {
							echo "New record created successfully";
							$cookie_name = "control";
							$cookie_value = 2;
							setcookie($cookie_name,$cookie_value,time()+(86400));
							echo $TeacherID;
							header("location:homeT.html?$TeacherID");
						} 
						else {
						  echo "Error: " . $sql . "<br>" . $connect->error;
						}
					}
				}
			}
			
			else if($ST == 2){   //student
				/*檢查輸入資料*/
				$LA = $_POST['LA'];
				$LO = $_POST['LO'];
				$time = $_POST['time'];
				$ID = $_POST['StudentID'];
				$ClassID = $_POST['ClassID'];
				$ClassPassword = $_POST['ClassPassword'];
				
				/*
				if($StudentID == ""){
					$StudentID = $_COOKIE["IDnumber"];
				}
				*/
				
				//存ID 
				$cookie_name = "IDnumber";
				$cookie_value = $ID;   
				setcookie($cookie_name,$cookie_value,time()+(86400));
				
				/*輸入為空白*/
				if($ClassID == "" || $ClassPassword == ""){
					$cookie_name = "control";
					$cookie_value = 22;    //student有空白
					setcookie($cookie_name,$cookie_value,time()+(86400));
					header("location:Class.php");
				}
				
				else{
					
					//連線資料庫
					$host = '127.0.0.1';
					//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
					$connect = new mysqli($host,"student", "password", "final");
					 
					if ($connect->connect_error) {
						die("連線失敗: " . $connect->connect_error);
					}
					echo "連線成功";
					
					//檢查有無重複
					$check = "SELECT password,bool FROM class WHERE class='$ClassID'";
					$result = $connect->query($check);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row['password'] == $ClassPassword && $row['bool'] == 1 ){
							//新增資料
							$sql = "INSERT INTO rolls(class,ID,Longitude,Latitude,time)
							VALUES ('$ClassID', '$ID','$LO','$LA','$time')";

							if ($connect->query($sql) === TRUE) {
								echo "New record created successfully";
								header("location:homeS.html?$StudentID");
							} 
							else {
							  echo "Error: " . $sql . "<br>" . $connect->error;
							}
						}
						else{   //密碼不符
							echo 'fault';
							$cookie_name = "control";
							$cookie_value = 2;
							setcookie($cookie_name,$cookie_value,time()+(86400));
							header("location:homeS.html?$StudentID");
						
						}
					}
					else {
						
						$cookie_name = "control";
						$cookie_value = 2;
						setcookie($cookie_name,$cookie_value,time()+(86400));
						header("location:homeS.html?$StudentID");
					}
				}

			}
			
		}
		//再輸入一次(有空白 teacher)
		if($control == 33){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			header("location:homeT.html?$TeacherID");
		}
		
		//再輸入一次(有空白 student)
		if($control == 22){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			header("location:homeS.html?$StudentID");
		}
		//mysqli_close($connect);
	?>
	
</body>
</html>