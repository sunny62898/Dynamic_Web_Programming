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
		
		
        #button{
			text-decoration:none;
            width:150px;
            height:100px;
			font-size:40px;
            font-family:"Audiowide", sans-serif;
            background-color:white;
            transition-duration: 0.4s;
            cursor: pointer;
			color:black;
        }
        #button:hover{
            background-color:LightSkyBlue;
            color:white;
        }
    </style>
	
</head>
<body>
	<?php
		//border:2px solid CornflowerBlue;
		$control = $_GET['s'];
		//echo $control;
		
		//輸入資料前
		if($control == 1){  //登錄成功
			echo '
			<center>
				<h1 style="font-size:60px;">Account created successfully!</h1>

				<a href="main.html" id="button">back to login</a>
			</center>';
			
		}
		
		
		
	?>

	
</body>
</html>
