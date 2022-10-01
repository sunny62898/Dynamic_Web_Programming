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
	
	
		//輸入資料後
		if($control == 2){
			/*檢查輸入資料*/
			$ID = $_POST["ID"];
			$password = $_POST["password"];
			$identity = $_POST["identity"];
			
			/*輸入為空白*/
			if($ID == "" || $password == ""){
				$cookie_name = "control";
				$cookie_value = 33;
				setcookie($cookie_name,$cookie_value,time()+(86400));
				header("location:LoginForm.php");
			}
			
			else{
				//連線資料庫
				$host = '127.0.0.1';
				
				if($identity == 'student'){
					//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
					$connect = new mysqli($host,"student", "password", "final");
					 
					if ($connect->connect_error) {
						die("連線失敗: " . $connect->connect_error);
					}
					echo "連線成功";
					
					//檢查密碼
					$check = "SELECT password FROM student WHERE ID='$ID'";
					$result = $connect->query($check);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row['password'] == $password){
							echo 'right';
							echo "
								<form method = 'get' action='homeT.html' id='formS'>
									<input type='hidden' name='ID' value='$ID'>
								</form>";
							echo "<script>subS();</script>";  //傳送學生資料
							header("location:homeS.html?$ID");  //到主畫面
						}
						else{   //密碼不符
							echo 'fault';
							$cookie_name = "control";
							$cookie_value = 66;
							setcookie($cookie_name,$cookie_value,time()+(86400));
							header("location:LoginForm.php");
						
						}
						
					}
					
					else {    //查無此帳號
						echo "no";
						$cookie_name = "control";
						$cookie_value = 44;
						setcookie($cookie_name,$cookie_value,time()+(86400));
						header("location:LoginForm.php");
					}
					
				}
				
				else if($identity == 'teacher'){
					//mysqli(資料庫路徑, 登入帳號, 登入密碼, 資料庫)
					$connect = new mysqli($host,"teacher", "password", "final");
					 
					if ($connect->connect_error) {
						die("連線失敗: " . $connect->connect_error);
					}
					echo "連線成功";
					
					//檢查密碼
					$check = "SELECT password FROM teacher WHERE ID='$ID'";
					$result = $connect->query($check);
					if ($result->num_rows > 0) {
						$row = $result->fetch_assoc();
						if($row['password'] == $password){
							echo 'right';
							echo "
								<form method = 'get' action='homeT.html' id='formT'>
									<input type='hidden' name='ID' value='$ID'>
								</form>";
							echo "<script>subT();</script>";  //傳送老師資料
							header("location:homeT.html?$ID");  //到主畫面
						}
						else{  //密碼不符
							echo 'fault';
							$cookie_name = "control";
							$cookie_value = 66;
							setcookie($cookie_name,$cookie_value,time()+(86400));
							header("location:LoginForm.php");
							
						}
						
					}
					
					else {    //查無此帳號
						echo "no";
						$cookie_name = "control";
						$cookie_value = 44;
						setcookie($cookie_name,$cookie_value,time()+(86400));
						header("location:LoginForm.php");
						
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
					<h1>LOGIN</h1>
					<form method = "post" action="LoginForm.php">
						<label>Identity</label>
						<select name="identity">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select><br>
						<label>ID number:</label>
						<input type="text" id="ID" name="ID"><br>
						<label>password:</label>
						<input type="password" id="password" name="password"><br><br>
						<input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

					</form>
					<br />
					<h3>Unregistered? <a href="createTeacher.html">Teacher</a> or <a href="createStudent.html">Student</a></h3>
				</center>';
		}
		
		//再輸入一次
		if($control == 66){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
				<center>
					<h1>LOGIN</h1>
					<h2 class="error">Password is incorrect!</h2>
					<form method = "post" action="LoginForm.php">
						<label>Identity</label>
						<select name="identity">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select><br>
						<label>ID number:</label>
						<input type="text" id="ID" name="ID"><br>
						<label>password:</label>
						<input type="password" id="password" name="password"><br><br>
						<input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

					</form>
					<br />
					<h3>Unregistered? <a href="createTeacher.html">Teacher</a> or <a href="createStudent.html">Student</a></h3>
				</center>';
		}
		
		if($control == 44){
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
				<center>
					<h1>LOGIN</h1>
					<h2 class="error">No account!</h2>
					<form method = "post" action="LoginForm.php">
						<label>Identity</label>
						<select name="identity">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select><br>
						<label>ID number:</label>
						<input type="text" id="ID" name="ID"><br>
						<label>password:</label>
						<input type="password" id="password" name="password"><br><br>
						<input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

					</form>
					<br />
					<h3>Unregistered? <a href="createTeacher.html">Teacher</a> or <a href="createStudent.html">Student</a></h3>
				</center>';
		}
		
		if($control == 33){  //輸入有空白
			//先設control為2
			$cookie_name = "control";
			$cookie_value = 2;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			echo '
				<center>
					<h1>LOGIN</h1>
					<h2 class="error">Cannot be null!</h2>
					<form method = "post" action="LoginForm.php">
						<label>Identity</label>
						<select name="identity">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select><br>
						<label>ID number:</label>
						<input type="text" id="ID" name="ID"><br>
						<label>password:</label>
						<input type="password" id="password" name="password"><br><br>
						<input type="submit" value="Submit" style="height:30px;width:80px;font-size:20px;background-color:FloralWhite;">

					</form>
					<br />
					<h3>Unregistered? <a href="createTeacher.html">Teacher</a> or <a href="createStudent.html">Student</a></h3>
				</center>';
		}
		//mysqli_close($connect);
	?>
	
	<script type="text/javascript">
		function subS(){
			formS.submit();
			
		}
		function subT(){
			formT.submit();
		}
		
		
	</script>

</body>
</html>
