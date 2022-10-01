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
            
        }
    </style>

    <script>

    </script>
	<?php
		$ID = $_GET['q'];

		$con = mysqli_connect('127.0.0.1','teacher','password','final');
		if (!$con) {
		  die('Could not connect: ' . mysqli_error($con));
		}

		$sql="SELECT * FROM class WHERE TeacherID = '".$ID."'";   //class中TeacherID相同的就印出來
		$result = mysqli_query($con,$sql);

		echo "<table><thead><tr><th>Class</th><th>Time</th></tr></thead><tbody>";
		while($row = mysqli_fetch_array($result)) {
			$classnum = $row['class'];
			echo "<tr><td>" . $row['class'] . "</td><td>" . $row['time'] . "</td><td>" ." <button type='button' onclick='getLocation($classnum)' id='button'>start to roll</button>" . "</td><td>" . "<button type='button' onclick='show($classnum)' id='button'>show</button>" . "</td></tr>";
		}
		echo "</tbody></table>";
		mysqli_close($con);
	?>
</head>
<body>

    <center>



    </center>
</body>
</html>
