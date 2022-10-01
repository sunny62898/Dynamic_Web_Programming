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

		$ID = $_GET["q"];

		$con = mysqli_connect('127.0.0.1','student','password','final');
		if (!$con) {
		  die('Could not connect: ' . mysqli_error($con));
		}

		$sql="SELECT * FROM class WHERE ID = '".$ID."'";  //class中ID相同的就印出來
		$result = mysqli_query($con,$sql);


		while($row = mysqli_fetch_array($result)) {
			echo "<h3>" . $row['class'] . $row['time'] ."</h3>";
		  
		}
		mysqli_close($con);
	
	?>
</head>
<body>

    <center>



    </center>
</body>
</html>
