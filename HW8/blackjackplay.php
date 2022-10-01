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
			$poke = array();  //建立儲存撲克牌的陣列  
			$pokeimage = array();  //儲存撲克牌圖片
			$countpoint = array();  //紀錄點數
			$playersum = 0;  //玩家總點數
			$bankersum = 0;  //莊家總點數
			$chipvalue = 0;  //下注的籌碼
			$pone = 5;  //處理玩家A = 1 or 11
			$bone = 5;  //處理莊家A = 1 or 11
			//$frequency = [, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];  //計算出牌頻率
			$frequency = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);  //計算出牌頻率
			//$tablepoke = [];  //儲存要放入table的撲克牌
			$tablepoke = array();  //儲存要放入table的撲克牌
			$wintimes = 0;
			$losetimes = 0;
			$tietimes = 0;
			$stop = 0;
			
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
					$poke[$k] = $i + "-" + $j + ".png";  //儲存圖片
					$k++;
				}
			}
			
			settable();  //設定表格
			setwin();  //設定輸贏表格
			
			function start(){

				$chips = document.getElementById("chip");
				$chipvalue = $_GET["chip"];
				if ($chipvalue == '') {
					alert("請輸入賭注");
					window.location.reload();
				}
				else if ($chipvalue > Number(sessionStorage.remain) || $chipvalue < 1 || $chipvalue.indexOf('.') != -1) {
					alert("請輸可輸入的賭注");
					window.location.reload();
					$chipvalue = 0;
				}
				
				bargain($chipvalue);
				//document.getElementById("pix").innerHTML = sessionStorage.remain;
				$chips.remove();  //輸入格移除   //???
				
				$money = document.getElementById("money");  //移除label  
				$money.remove();   //???

				$played = document.getElementById("play");
				$played.remove();  //???
				
				
				for ($i = 0 ; $i < 12 ; $i++) {   //存取撲克牌位置
					$pokeimage[$i] = document.getElementById("poke" + ($i + 1));  //儲存ID

					$pokeimage[$i].setAttribute("src", "blank.jpg");  //變成空白格子
				}

				for ($t = 0; $t < 2; $t++) {  //一開始1張底牌與1張明牌
					playerhintpoke();
					bankerhintpoke();
				}
				
				
				//一開始就Black Jack
				if ($playersum == 21 && $bankersum != 21) {  //玩家Black Jack但莊家沒有
					$wintimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU WIN！" + "(+" + $chipvalue + "*2)";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					
					caculate(1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
				}
				else if ($playersum != 21 && $bankersum == 21) {  //莊家Black Jack但玩家沒有
					$losetimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU LOSE！" + "(-" + $chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					
					caculate(-1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
					if (sessionStorage.remain < 1) {   //輸光
						lose();
					}
				}
				else if ($playersum == 21 && $bankersum == 21) {  //兩個都Black Jack
					$tietimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "TIE" + "(+" + $chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					
					caculate(0);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
				}
				else if ($chipvalue <= Number(sessionStorage.remain)) {
					//建立加注
					document.getElementById("question").innerHTML = "請問要加注嗎？";
					document.getElementById("question").setAttribute("style", "font-size:30px;front-weight:bolder;");
					
					$yes = document.getElementById("yes");
					$yes = document.createElement("button");
					
					/*???????*/
					$yes.innerHTML = "YES";
					$yes.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
					$yes.setAttribute("onclick", "yes()");
					document.getElementById("yes").appendChild(yes);

					$no = document.getElementById("no");
					$no = document.createElement("button");
					$no.innerHTML = "NO";
					$no.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
					$no.setAttribute("onclick", "no()");
					document.getElementById("no").appendChild(no);
				}
				else {
					//建立發牌按鈕
					$hint = document.getElementById("hint");
					$hint = document.createElement("button");
					
					/*????*/
					$hint.innerHTML = "HINT";
					$hint.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
					//hint.addEventListener("click", playerhintpoke, false);
					$hint.setAttribute("onclick", "playerhintpoke()");
					document.getElementById("hint").appendChild(hint);

					//建立停牌牌按鈕
					$stand = document.getElementById("stand");
					$stand = document.createElement("button");
					
					/*?????*/
					$stand.innerHTML = "STAND";
					$stand.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
					$stand.setAttribute("onclick", "playerstandpoke()");
					document.getElementById("stand").appendChild(stand);
				}
			}
			
			function yes() {
				sessionStorage.remain = Number(sessionStorage.remain) - $chipvalue;
				$chipvalue = Number(chipvalue) + Number(chipvalue);
				document.getElementById("pix").innerHTML = sessionStorage.remain;

				$question = document.getElementById("question");  //移除question
				question.remove();

				$plus = document.getElementById("yes");  //移除yes
				plus.remove();

				$no = document.getElementById("no");  //移除no
				no.remove();

				//建立發牌按鈕
				$hint = document.getElementById("hint");
				$hint = document.createElement("button");
				$hint.innerHTML = "HINT";
				$hint.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
				$hint.setAttribute("onclick", "pplayerhintpoke()");
				document.getElementById("hint").appendChild($hint);
				
				//建立停牌牌按鈕
				$stand = document.getElementById("stand");
				$stand = document.createElement("button");
				$stand.innerHTML = "STAND";
				$stand.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
				$stand.setAttribute("onclick", "playerstandpoke()");
				document.getElementById("stand").appendChild($stand);
	 
			}
			
			function no() {
				$question = document.getElementById("question");  //移除question
				question.remove();

				$plus = document.getElementById("yes");  //移除yes
				plus.remove();

				$no = document.getElementById("no");  //移除no
				no.remove();
				
				//建立發牌按鈕
				$hint = document.getElementById("hint");
				$hint = document.createElement("button");
				$hint.innerHTML = "HINT";
				$hint.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
				//hint.addEventListener("click", playerhintpoke, false);
				$hint.setAttribute("onclick", "playerhintpoke()");
				document.getElementById("hint").appendChild($hint);

				//建立停牌牌按鈕
				$stand = document.getElementById("stand");
				$stand = document.createElement("button");
				$stand.innerHTML = "STAND";
				$stand.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
				$stand.setAttribute("onclick", "playerstandpoke()");
				document.getElementById("stand").appendChild($stand);
			}
			
			function pplayerhintpoke() {  //加注玩家發牌方程式

				$card = rad();
				//sessionStorage.table(countpoint[card]) = Number(sessionStorage.table(countpoint[card])) + 1;  //增加頻率
				psum($countpoint[$card]);  //計算點數
				/*?????*/
				$pokeimage[6 + $v].setAttribute("src", $poke[$card]);  //顯示撲克牌
				$frequency[$tablepoke[$card]]++;
				if ($playersum > 21) {  //BUST
					//losetimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$losetimes++;
					/*??????*/
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU BUST！" + "(-" + chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					
					caculate(-1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
					if (sessionStorage.remain < 1) {   //輸光
						lose();
					}

				}
				else {
					again(card);  //防止抽到重複的牌
					//document.getElementById("showplayerpoint").innerHTML = playersum;
					//document.getElementById("showplayerpoint").setAttribute("style", "font-size:50px;front-weight:bold;float:right;");
					playerstandpoke();
				}
				
			}
			
			$v = 0;
			function playerhintpoke() {  //玩家發牌方程式
			  
				$card = rad();
				//sessionStorage.table(countpoint[card]) = Number(sessionStorage.table(countpoint[card])) + 1;  //增加頻率
				psum($countpoint[$card]);  //計算點數
				pokeimage[6 + v].setAttribute("src", $poke[$card]);  //顯示撲克牌
				$frequency[$tablepoke[$card]]++;
	 
				again(card);  //防止抽到重複的牌
				//document.getElementById("showplayerpoint").innerHTML = playersum;
				//document.getElementById("showplayerpoint").setAttribute("style", "font-size:50px;front-weight:bold;float:right;");
				
				if ($v == 4 && $playersum < 22) {  //過五關
					$wintimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU WIN！" + "(+" + chipvalue + "*2)";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					
					caculate(1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
				}
				$v++;
			}
			
			function playerstandpoke() {  //停牌方程式
				
				while ($bankersum < 17 && $stop < 5) {
					bankerhintpoke();  //玩家停牌換莊家發牌
				}
				if ($bankersum < 22 && $stop == 4) {
					$losetimes++;
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU LOSE！" + "(-" + $chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					caculate(-1);  //計算籌碼
					delset();  //刪除hint、stand  建立again
					if (sessionStorage.remain < 1) {   //輸光
						lose();
					}
				}
				else if ($bankersum > 21) {  //BUST
					$wintimes++;
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU WIN！" + "(+" + $chipvalue + "*2)";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					$wintimes++;
					caculate(1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
				}
				else {
					winlose();  //抽完牌雙方都沒BUST
				}    
			}
			
			function psum($points) {  //玩家總和
				//frequency[points]++;
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
				
				if ($playersum > 21) {  //BUST
					if ($pone == 3) {  //轉換A
						$playersum = $playersum - 10;
						$pone++;
					}
					else {
						$losetimes++;
						storage();  //儲存出牌頻率
						showtable();  //顯示頻率表
						
						/*??????*/
						pokeimage[0].setAttribute("src", hole);  //顯示底牌
						document.getElementById("result").innerHTML = "YOU BUST！" + "(-" + $chipvalue + ")";
						document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
						
						caculate(-1);  //計算籌碼
						delset();  //刪除hint、stsnd  建立again
						if (sessionStorage.remain < 1) {   //輸光
							lose();
						}
					}   
				}
			}
			function bsum($points) {  //莊家總和
			 
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
				
			}

			$change = 0;
			function rad() {  //產生亂數(抽牌)
				$choose = Math.floor(Math.random() * (52 - $change) + 1);
				return choose;
			}
			
			function again($card) {  //每抽一次把排放到最後
				$temp = $poke[$card];  //牌
				$poke[$card] = $poke[52 - $change];
				$poke[52 - $change] = $temp;

				$tempp = $countpoint[$card];  //點數
				$countpoint[$card] = $countpoint[52 - $change];
				$countpoint[52 - $change] = $tempp;

				$tabletemp = $tablepoke[$card];  //table
				$tablepoke[$card] = $tablepoke[52 - $change];
				$tablepoke[52 - $change] = $tabletemp;

				$change++;
			}
			
			$hole = 0;
			$b = 0;
			function bankerhintpoke() {  //莊家發牌
				$card = rad();
				//sessionStorage.table(countpoint[card]) = Number(sessionStorage.table(countpoint[card])) + 1;  //增加頻率
				bsum(countpoint[card]);  //計算點數
				$frequency[$tablepoke[$card]]++;
				if ($b == 0) {  //莊家底牌
					pokeimage[b].setAttribute("src", "BackCard.jpg");  //顯示撲克牌
					$hole = $poke[$card];  //儲存底牌之後翻開
				}
				else {
					pokeimage[b].setAttribute("src", $poke[$card]);  //顯示撲克牌
				}
				//pokeimage[b].setAttribute("src", poke[card]);  //顯示撲克牌

				again($card);  //防止抽到重複的牌
			   // document.getElementById("showbankerpoint").innerHTML = bankersum;
			   // document.getElementById("showbankerpoint").setAttribute("style", "font-size:50px;front-weight:bold;float:right;");
				$b++;
				$stop++;
			}
			
			function winlose() {   //判定輸贏
				//storage();  //儲存出牌頻率
				//showtable();  //顯示頻率表
				if ($playersum > $bankersum) {  //win
					$wintimes++;
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU WIN！" + "(+" + $chipvalue + "*2)";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					caculate(1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
				}
				else if ($bankersum > $playersum) {  //lose
					$losetimes++;
					$pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "YOU LOSE！" + "(-" + $chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					caculate(-1);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
					if (sessionStorage.remain < 1 ) {   //輸光
						lose();
					}
				}
				else {  //tie
					$tietimes++;
					pokeimage[0].setAttribute("src", $hole);  //顯示底牌
					document.getElementById("result").innerHTML = "TIE" + "(+" + $chipvalue + ")";
					document.getElementById("result").setAttribute("style", "font-size:50px;front-weight:bold;");
					storage();  //儲存出牌頻率
					showtable();  //顯示頻率表
					caculate(0);  //計算籌碼
					delset();  //刪除hint、stsnd  建立again
					
				}
			}
			
			function bargain($cost) {  //計算籌碼現在數量

				//存放籌碼數量
				if (typeof (Storage) != "undefine") {
					if (sessionStorage.remain) {
						sessionStorage.remain = Number(sessionStorage.remain) - $cost;
					}
					else {
						sessionStorage.remain = 1000;
						sessionStorage.remain = Number(sessionStorage.remain) - $cost;
					}
				}

			}

			function delset() {
				$hinted = document.getElementById("hint");  //移除hint
				$hinted.remove();

				$standed = document.getElementById("stand");  //移除stand
				$standed.remove();

				//建立再一次按鈕
				$again = document.getElementById("again");
				$again = document.createElement("button");
				$again.innerHTML = "AGAIN";
				$again.setAttribute("style", "width:140px; height:50px;font-size:25px;font-weight:bolder");
				$again.setAttribute("onclick", "javascript:window.location.reload()");
				document.getElementById("again").appendChild(again);
			}
			function caculate($bool) {
				if ($bool == 1) {  //win
					sessionStorage.remain = Number(sessionStorage.remain) + ($chipvalue * 2);
				}
				else if ($bool == 0) {  //tie
					sessionStorage.remain = Number(sessionStorage.remain) + Number($chipvalue);
				}
				else if ($bool == -1) {  //lose
					sessionStorage.remain = Number(sessionStorage.remain) - $chipvalue;
				}
				document.getElementById("pix").innerHTML = sessionStorage.remain;

			}
			
			function lose() {
				$again = document.getElementById("again");  //移除again
				$again.remove();

				$aplay = document.getElementById("aplay");
				$aplay = document.createElement("button");
				$aplay.innerHTML = "PLAY AGAIN";
				$aplay.setAttribute("style", "width:200px; height:50px;font-size:25px;font-weight:bolder");
				sessionStorage.remain = 1000;
				$aplay.setAttribute("onclick", "javascript:window.location.reload()");
				document.getElementById("aplay").appendChild(aplay);
				
				/*????????*/
				//table重設
				sessionStorage.A = 0;
				sessionStorage.B = 0;
				sessionStorage.C = 0;
				sessionStorage.D = 0;
				sessionStorage.E = 0;
				sessionStorage.F = 0;
				sessionStorage.G = 0;
				sessionStorage.H = 0;
				sessionStorage.I = 0;
				sessionStorage.J = 0;
				sessionStorage.K = 0;
				sessionStorage.L = 0;
				sessionStorage.M = 0;
				sessionStorage.win = 0;
				sessionStorage.lose = 0;
				sessionStorage.tie = 0;
			}
			
			function setwin() {  //建立輸贏次數的table
				//贏了幾次
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.win) {  //如果有了就取值
						wintimes = sessionStorage.win;

					}
					else {  //建立儲存空間
						sessionStorage.win = 0;  //初始次數設為0

					}
				}
				//輸了幾次
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.lose) {  //如果有了就取值
						losetimes = sessionStorage.lose;

					}
					else {  //建立儲存空間
						sessionStorage.lose = 0;  //初始次數設為0

					}
				}
				//平手
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.tie) {  //如果有了就取值
						tietimes = sessionStorage.tie;

					}
					else {  //建立儲存空間
						sessionStorage.tie = 0;  //初始次數設為0

					}
				}
			}
			
			function settable() {    //設定表格
				//1
				if (typeof (Storage != "undefine")) {
						
					if (sessionStorage.A) {  //如果有了就取值
						frequency[1] = sessionStorage.A;
							
					}
					else {  //建立儲存空間
						sessionStorage.A = 0;  //初始次數設為0
						   
					}
				}
				//2
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.B) {  //如果有了就取值
						frequency[2] = sessionStorage.B;

					}
					else {  //建立儲存空間
						sessionStorage.B = 0;  //初始次數設為0

					}
				}
				//3
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.C) {  //如果有了就取值
						frequency[3] = sessionStorage.C;

					}
					else {  //建立儲存空間
						sessionStorage.C = 0;  //初始次數設為0

					}
				}
				//4
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.D) {  //如果有了就取值
						frequency[4] = sessionStorage.D;

					}
					else {  //建立儲存空間
						sessionStorage.D = 0;  //初始次數設為0

					}
				}
				//5
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.E) {  //如果有了就取值
						frequency[5] = sessionStorage.E;

					}
					else {  //建立儲存空間
						sessionStorage.E = 0;  //初始次數設為0

					}
				}
				//6
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.F) {  //如果有了就取值
						frequency[6] = sessionStorage.F;

					}
					else {  //建立儲存空間
						sessionStorage.F = 0;  //初始次數設為0

					}
				}
				//7
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.G) {  //如果有了就取值
						frequency[7] = sessionStorage.G;

					}
					else {  //建立儲存空間
						sessionStorage.G = 0;  //初始次數設為0

					}
				}
				//8
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.H) {  //如果有了就取值
						frequency[8] = sessionStorage.H;

					}
					else {  //建立儲存空間
						sessionStorage.H = 0;  //初始次數設為0

					}
				}
				//9
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.I) {  //如果有了就取值
						frequency[9] = sessionStorage.I;

					}
					else {  //建立儲存空間
						sessionStorage.I = 0;  //初始次數設為0

					}
				}
				//10
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.J) {  //如果有了就取值
						frequency[10] = sessionStorage.J;

					}
					else {  //建立儲存空間
						sessionStorage.J = 0;  //初始次數設為0

					}
				}
				//11
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.K) {  //如果有了就取值
						frequency[11] = sessionStorage.K;

					}
					else {  //建立儲存空間
						sessionStorage.K = 0;  //初始次數設為0

					}
				}
				//12
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.L) {  //如果有了就取值
						frequency[12] = sessionStorage.L;

					}
					else {  //建立儲存空間
						sessionStorage.L = 0;  //初始次數設為0

					}
				}
				//13
				if (typeof (Storage != "undefine")) {

					if (sessionStorage.M) {  //如果有了就取值
						frequency[13] = sessionStorage.M;

					}
					else {  //建立儲存空間
						sessionStorage.M = 0;  //初始次數設為0

					}
				}
			}
			
			function storage() {  //將值存到sessionStorage裡
				sessionStorage.A = frequency[1];
				sessionStorage.B = frequency[2];
				sessionStorage.C = frequency[3];
				sessionStorage.D = frequency[4];
				sessionStorage.E = frequency[5];
				sessionStorage.F = frequency[6];
				sessionStorage.G = frequency[7];
				sessionStorage.H = frequency[8];
				sessionStorage.I = frequency[9];
				sessionStorage.J = frequency[10];
				sessionStorage.K = frequency[11];
				sessionStorage.L = frequency[12];
				sessionStorage.M = frequency[13];
				sessionStorage.win = $wintimes;
				sessionStorage.lose = $losetimes;
				sessionStorage.tie = $tietimes;
			}
			
			function showtable() {  //顯示結果表格

				$results = "<table><caption>Poke Frequencies</caption>" +
							   "<thead><tr class='odd'><th>Points</th><th>Frequency</th></tr>" +
							   "</thead><tbody>";
				//var length = frequency.length;

				for ($i = 1; $i < 14; ++$i) {
					if ($i == 11) {
						$results += "<tr><td>" + "J" + "</td><td>" + $frequency[$i] + "</td></tr>";
					}
					else if ($i == 12) {
						$results += "<tr><td>" + "Q" + "</td><td>" + $frequency[$i] + "</td></tr>";
					}
					else if ($i == 13) {
						$results += "<tr><td>" + "K" + "</td><td>" + $frequency[$i] + "</td></tr>";
					}
					else {
						$results += "<tr><td>" + $i + "</td><td>" + $frequency[$i] + "</td></tr>";
					}
				   
				}
				$results += "<tr><td>" + "Win" + "</td><td>" + $wintimes + "</td></tr>";
				$results += "<tr><td>" + "Lose" + "</td><td>" + $losetimes + "</td></tr>";
				$results += "<tr><td>" + "Tie" + "</td><td>" + $tietimes + "</td></tr>";

				$results += "</tbody></table>";
				document.getElementById("table").innerHTML = $results;
			}
			
			
		?>
	
	<!--html開始-->
	<div id="showbankerpoint"></div>
    <p style="text-align:center;margin-top:10px">
        <img id="poke1" src="BackCard.jpg" alt="poke image">
        <img id="poke2" src="BackCard.jpg" alt="poke image">
        <img id="poke3" src="BackCard.jpg" alt="poke image">
        <img id="poke4" src="BackCard.jpg" alt="poke image">
        <img id="poke5" src="BackCard.jpg" alt="poke image">
        <img id="poke6" src="BackCard.jpg" alt="poke image">
    </p>

        
    <div id="question"></div>  <!--加注-->
    <div id="yes"></div>
    <div id="no"></div>
    <div id="hint"></div>  <!--發牌-->
    <div id="stand"></div>  <!--停牌-->
    <div id="result"></div>  <!--結果-->
    <div id="again"></div>  <!--再玩一次-->
    <div id="aplay"></div>  <!--全輸再玩一次-->    
   
    <p style="text-align:center;margin-top:50px">
        <img id="poke7" src="BackCard.jpg" alt="poke image">
        <img id="poke8" src="BackCard.jpg" alt="poke image">
        <img id="poke9" src="BackCard.jpg" alt="poke image">
        <img id="poke10" src="BackCard.jpg" alt="poke image">
        <img id="poke11" src="BackCard.jpg" alt="poke image">
        <img id="poke12" src="BackCard.jpg" alt="poke image">

    </p>
    <div id="showplayerpoint"></div>

    <span style="margin-left:50px;vertical-align:middle;">
        <img id="pixastock"  src="pixastock1.jpg" alt="pixastock image">
    </span>
    
    <span id="pix" style="font-size:40px;margin-top:0px;vertical-align:middle;font-weight:bold;"></span>


    <span id="table" style="float:right;"></span>   <!--顯示出牌統計-->
	
	
	
	</body>
</html>
