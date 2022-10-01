
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
			/*setcookie("control","",time()-(86400));
			setcookie("banker1","",time()-(86400));
			setcookie("banker2","",time()-(86400));
			setcookie("banker3","",time()-(86400));
			setcookie("banker4","",time()-(86400));
			setcookie("banker5","",time()-(86400));
			setcookie("player1","",time()-(86400));
			setcookie("player2","",time()-(86400));
			setcookie("player3","",time()-(86400));
			setcookie("player4","",time()-(86400));
			setcookie("player5","",time()-(86400));
			setcookie("psum","",time()-(86400));
			setcookie("bsum","",time()-(86400));*/
		/*
			用刷新頁面的方式來顯示牌
			每次抽完牌就把牌丟到最後面
			抽1~52的數字
			大於13就-13來計算
			大於26就-26來計算
			大於39就-39來計算
			抽完將變數存到cookie 再次刷新頁面
			完成發牌
		*/
		
		/*設置control*/
		if(!isset($_COOKIE["control"])){
			$cookie_name = "control";
			$cookie_value = 6;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			$control = 6;   //檢查chip
		}
		else{
			$control = $_COOKIE["control"];
		}
		
		
		$tablepoke = array();  //儲存要放入table的撲克牌
		/*儲存牌*/
		$k = 1;
		for($i = 1 ; $i <= 4 ; $i++){  //1梅花 2方塊 3紅心 4黑桃
			for ($j = 1 ; $j <= 13 ; $j++) {  //點數
				if ($j >= 10) { 
					$countpoint[$k] = 10;   //紀錄點數
				}
				else {
					$countpoint[$k] = $j;   //紀錄點數
				}
			   
				$tablepoke[$k] = $j;
				$poke[$k] = $i . "-" . $j . ".png";  //儲存圖片
				$k++;
			}
		}
		
		
		/*決定哪個button*/
		//HINT
		/*if(!isset($_COOKIE["hint"])){
			
		}
		*/
		
		
		/*開玩遊戲*/
		function startGame(){
			//for ($t = 0; $t < 2; $t++) {  //一開始1張底牌與1張明牌
					playerhintpoke();
					bankerhintpoke();
					playerhintpoke();
					bankerhintpoke();
				//}
			/*建立hint stand*/
			$cookie_name = "control";  //儲存control數值
			$cookie_value = 3;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			header("location:blackjacknew.php");  //重新載入
		}
		
		//防止抽到重複的牌
		if(!isset($_COOKIE["defense"])){
				$defense = 0;
		}
		else{
			$defense = $_COOKIE["defense"];
		}
		
		if(isset($_GET['hint'])){
			function playerhintpoke(){  //玩家發牌方程式
				$card = rand(1,52-$defense);
				psum($countpoint[$card]);
				if(!isset($_COOKIE["banker1"])){
					$cookie_name = "banker1";
					$cookie_value = $card;
					setcookie($cookie_name,$cookie_value,time()+(86400));
				}
				else if(!isset($_COOKIE["banker2"])){
					$cookie_name = "banker2";
					$cookie_value = $card;
					setcookie($cookie_name,$cookie_value,time()+(86400));
				}
				else if(!isset($_COOKIE["banker3"])){
					$cookie_name = "banker3";
					$cookie_value = $card;
					setcookie($cookie_name,$cookie_value,time()+(86400));
				}
				else if(!isset($_COOKIE["banker4"])){
					$cookie_name = "banker4";
					$cookie_value = $card;
					setcookie($cookie_name,$cookie_value,time()+(86400));
				}
				else if(!isset($_COOKIE["banker5"])){
					$cookie_name = "banker5";
					$cookie_value = $card;
					setcookie($cookie_name,$cookie_value,time()+(86400));
				}
				$defense++;
				$cookie_name = "defense";
				$cookie_value = $defense;
				setcookie($cookie_name,$cookie_value,time()+(86400));
				header("location:blackjacknew.php");
			}
		}
		function bankerhintpoke(){  //莊家發牌方程式
			$card = rand(1,52-$defense);
			bsum($countpoint[$card]);  //計算點數
			if(!isset($_COOKIE["player1"])){
				$cookie_name = "player1";
				$cookie_value = $card;
				setcookie($cookie_name,$cookie_value,time()+(86400));
			}
			else if(!isset($_COOKIE["player2"])){
				$cookie_name = "player2";
				$cookie_value = $card;
				setcookie($cookie_name,$cookie_value,time()+(86400));
			}
			else if(!isset($_COOKIE["player3"])){
				$cookie_name = "player3";
				$cookie_value = $card;
				setcookie($cookie_name,$cookie_value,time()+(86400));
			}
			else if(!isset($_COOKIE["player4"])){
				$cookie_name = "player4";
				$cookie_value = $card;
				setcookie($cookie_name,$cookie_value,time()+(86400));
			}
			else if(!isset($_COOKIE["player5"])){
				$cookie_name = "player5";
				$cookie_value = $card;
				setcookie($cookie_name,$cookie_value,time()+(86400));
			}
			$defense++;
			$cookie_name = "defense";
			$cookie_value = $defense;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			header("location:blackjacknew.php");
		}
		
		function bsum($points) {  //莊家總和
			if(!isset($_COOKIE["bsum"])){
				$bankersum = 0;
			}
			else{
				$bankersum = $_COOKIE["bsum"];
			}
		
			 
			if ($points == 1) {  //如果抽到Ace
				$bone = 3;
				$Ace = 11;  //假設是11
				$Acesum = $bankersum + $Ace;
				if ($Acesum <= 21) {  //相加小於21 
					$bankersum = $Acesum;
				}
				else {
					$bankersum = $bankersum + $points;
				}
			}
			else {
				$bankersum = $bankersum + $points;
			}
			if ($bankersum > 21) {  //轉換A
				if ($bone == 3) {
					$bankersum = $bankersum - 10;
					$bone++;
				}
			}
			//儲存莊家總點數
			$cookie_name = "bsum";
			$cookie_value = $bankersum;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			if($bankersum > 21){
				win();  //莊家爆掉玩家贏    
			}
					
		}
		
		function psum($points) {  //玩家總和
			if(!isset($_COOKIE["psum"])){
				$playersum = 0;
			}
			else{
				$playersum = $_COOKIE["psum"];
			}
			
			
			if ($points == 1) {  //如果抽到Ace
				$pone = 3;
				$Ace = 11;  //假設是11
				$Acesum = $playersum + $Ace;
				if ($Acesum <= 21) {  //相加小於21 
					$playersum = $Acesum;
				}
				else {
					$playersum = $playersum + $points;
				}
			}
			else {
				$playersum = $playersum + $points;
			}
			if ($playersum > 21) {  //轉換A
				if ($bone == 3) {
					$playersum = $playersum - 10;
					$bone++;
				}
			}
			//儲存玩家總和
			$cookie_name = "psum";
			$cookie_value = $playersum;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			if($playersum > 21){
				lose();  //玩家超過21爆掉
			}
			
		}
		function lose(){
			$cookie_name = "control";  //儲存control數值
			$cookie_value = 50;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			header("location:blackjacknew.php");  //重新載入
		}
		function win(){
			$cookie_name = "control";  //儲存control數值
			$cookie_value = 100;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			header("location:blackjacknew.php");  //重新載入
		}
		function tie(){
			$cookie_name = "control";  //儲存control數值
			$cookie_value = 25;
			setcookie($cookie_name,$cookie_value,time()+(86400));
			
			header("location:blackjacknew.php");  //重新載入
		}
		function resetcookie(){
			setcookie("control","",time()-(86400));
			setcookie("banker1","",time()-(86400));
			setcookie("banker2","",time()-(86400));
			setcookie("banker3","",time()-(86400));
			setcookie("banker4","",time()-(86400));
			setcookie("banker5","",time()-(86400));
			setcookie("player1","",time()-(86400));
			setcookie("player2","",time()-(86400));
			setcookie("player3","",time()-(86400));
			setcookie("player4","",time()-(86400));
			setcookie("player5","",time()-(86400));
			setcookie("psum","",time()-(86400));
			setcookie("bsum","",time()-(86400));
		}
		
	 ?>
	 
	 <!--莊家-->
	 <p style="text-align:center;margin-top:10px">
		<?php
			if(!isset($_COOKIE["banker1"])){
				$path1 = '/HW8/blank.jpg';
			}
			else{
				$path1 = '/HW8/'.$poke[$_COOKIE["banker1"]];
			}
		?>
		<img src=<?=$path1 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["banker2"])){
				$path2 = '/HW8/blank.jpg';
			}
			else{
				$path2 = '/HW8/'.$poke[$_COOKIE["banker2"]];
			}
		?>
		<img src=<?=$path2 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["banker3"])){
				$path3 = '/HW8/blank.jpg';
			}
			else{
				$path3 = '/HW8/'.$poke[$_COOKIE["banker3"]];
			}
		?>
		<img src=<?=$path3 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["banker4"])){
				$path4 = '/HW8/blank.jpg';
			}
			else{
				$path4 = '/HW8/'.$poke[$_COOKIE["banker4"]];
			}
		?>
		<img src=<?=$path4 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["banker5"])){
				$path5 = '/HW8/blank.jpg';
			}
			else{
				$path5 = '/HW8/'.$poke[$_COOKIE["banker5"]];
			}
		?>
		<img src=<?=$path5 ?>>   <!--用來顯示抽到的牌-->
	 </p>
	 
	 
	 <?php
		if($control == 6){   //最初始
			/*判別輸入的籌碼是否正確*/
			$chip = $_GET['chip'];
			echo $chip;
			if($chip <= 0){  //輸入錯誤
				echo "<h2 style='text-align:center'>輸入錯誤</h2><br>";
				echo "<form action='blackjackphp.html' method='get' style='text-align:center'><input type='submit' value='再輸入一次' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";
			}
			else{            //輸入正確
				echo "<h2 style='text-align:center'>correct</h2>";
				startGame();   //開始遊戲
				
			}
		}
		else if($control == 3){
			echo "<form action='blackjacknew.php' method='get' style='text-align:center'><input type='submit' name='hint' value='hint' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";
			echo "<form action='blackjacknew.php' method='get' style='text-align:center'><input type='submit' name='stand' value='stand' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";

		}
		else if($control == 100){   //贏
			echo "<h1>WIN</h1>";
			resetcookie();			
			echo "<form action='blackjackphp.html' method='get' style='text-align:center'><input type='button' onclick='bankerhintpoke()' value='again' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";
		}
		else if($control == 50){   //輸
			echo "<h1>LOSE</h1>"; 
			resetcookie();
			echo "<form action='blackjackphp.html' method='get' style='text-align:center'><input type='button' onclick='bankerhintpoke()' value='again' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";
		
		}
		else if($control == 25){   //平手
			echo "<h1>TIE</h1>"; 
			resetcookie();
			echo "<form action='blackjackphp.html' method='get' style='text-align:center'><input type='button' onclick='bankerhintpoke()' value='again' style='width:140px; height:50px;font-size:25px;font-weight:bolder'></form>";
		
		}
		
	 ?>
	 
	 <!--玩家-->
	 <p style="text-align:center;margin-top:50px">
		<?php
			if(!isset($_COOKIE["player1"])){
				$path6 = '/HW8/blank.jpg';
			}
			else{
				$path6 = '/HW8/'.$poke[$_COOKIE["player1"]];
			}
		?>
		<img src=<?=$path6 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["player2"])){
				$path7 = '/HW8/blank.jpg';
			}
			else{
				$path7 = '/HW8/'.$poke[$_COOKIE["player2"]];
			}
		?>
		<img src=<?=$path7 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["player3"])){
				$path8 = '/HW8/blank.jpg';
			}
			else{
				$path8 = '/HW8/'.$poke[$_COOKIE["player3"]];
			}
		?>
		<img src=<?=$path8 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["player4"])){
				$path9 = '/HW8/blank.jpg';
			}
			else{
				$path9 = '/HW8/'.$poke[$_COOKIE["player4"]];
			}
		?>
		<img src=<?=$path9 ?>>   <!--用來顯示抽到的牌-->
		<?php
			if(!isset($_COOKIE["player5"])){
				$path10 = '/HW8/blank.jpg';
			}
			else{
				$path10 = '/HW8/'.$poke[$_COOKIE["player5"]];
			}
		?>
		<img src=<?=$path10 ?>>   <!--用來顯示抽到的牌-->
	 </p>
	 <!--**************************
    4108040040 魯姵妤 第八次作業12/23
    4108040040 PeiYuLuThe Eighth Homework 12/23
    **************************-->
   </body>
</html>

