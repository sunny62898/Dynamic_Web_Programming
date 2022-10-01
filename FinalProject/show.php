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
		$class = $_GET['q'];

		$con = mysqli_connect('127.0.0.1','teacher','password','final');
		if (!$con) {
		  die('Could not connect: ' . mysqli_error($con));
		}

		$sql="SELECT * FROM rolls WHERE class = '".$class."'";   //class中TeacherID相同的就印出來
		$result = mysqli_query($con,$sql);
		
		if($result == false){
			echo "";
		}
		
		else{
			echo "<table><thead><tr><th>Student ID</th><th>latitude</th><th>longitude</th><th>time</th></tr></thead><tbody>";
			while($row = mysqli_fetch_array($result)) {
				$classnum = $row['class'];
				echo "<tr><td>" . $row['ID'] . "</td><td>" . $row['latitude'] . "</td><td>" . $row['longitude'] . "</td><td>" . $row['time'] . "</td></tr>";
			  
			}
			echo "</tbody></table><br>";
			echo " <button type='button' onclick='OK()' id='button1'>OK</button>";
				
		}
		/*
		echo "<table><thead><tr><th>Student ID</th><th>latitude</th><th>longitude</th><th>time</th></tr></thead><tbody>";
		while($row = mysqli_fetch_array($result)) {
			$classnum = $row['class'];
			echo "<tr><td>" . $row['ID'] . "</td><td>" . $row['latitude'] . "</td><td>" . $row['longitude'] . "</td><td>" . $row['time'] . "</td></tr>";
		  
		}
		echo "</tbody></table><br>";
		echo " <button type='button' onclick='OK($classnum)' id='button1'>OK</button>";
		*/
		mysqli_close($con);
	?>
</head>
<body>

    <center>



    </center>
</body>
</html>
