<!DOCTYPE html>
<html>
<head>
    <title>Roll Calling System</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
    <style>
        input[type=text], select, input[type=password] {
            width: 200px;
            padding: 12px 20px;
            margin: 8px;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        body {
            font-size: large;
            font-family: "Audiowide", sans-serif;
        }
    </style>

    <script>

    </script>
	<?php
		$LA = $_POST['LA'];
		$LO = $_POST['LO'];
		$time = $_POST['time'];
		$ID = $_POST['ID'];
		$classnumber = $_POST['classnumber'];
		$C = $_POST['C'];
		
		
		if($C == 1){  //teacher
			//連線資料庫
			$host = '127.0.0.1';
			//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
			$connect = new mysqli($host,"teacher", "password", "final");
			 
			if ($connect->connect_error) {
				die("連線失敗: " . $connect->connect_error);
			}
			echo "連線成功";
			
			
			//新增資料
			$sql = "INSERT INTO roll(class,ID,Longitude,Latitude,time)
			VALUES ('$classnumber', '$ID','$LO','$LA','$time')";

			if ($connect->query($sql) === TRUE) {
			  echo "New record created successfully";
			  header("location:homeT.html?$ID");
			} 
			else {
			  echo "Error: " . $sql . "<br>" . $connect->error;
			}
			
			$sql2 = "UPDATE class SET bool=1 WHERE class = $classnumber";

			if ($connect->query($sql2) === TRUE) {
			  echo "New record created successfully";
			  header("location:homeT.html?$ID");
			} 
			else {
			  echo "Error: " . $sql2 . "<br>" . $connect->error;
			}
			mysqli_close($con);
		}	
		//mysqli_close($con);
		
		/*
		else if($C == 2){  //student
		
		}
		*/
		
		//mysqli_close($connect);		
	?>
</head>
<body>

    <center>



    </center>
</body>
</html>
