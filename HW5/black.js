//Blackjack

//建立儲存撲克牌的二維陣列
var poke = new Array(5)(14);
var pokeimage = new Array(12);
for(var i = 1 ; i <= 4 ; i++){  //1梅花 2方塊 3紅心 4黑桃
    for(var j = 1 ; j <= 13 ; j++){  //點數
       // poke[i][j] = i + "-" + j + ".png";
        poke[i][j] = i;
        document.writeln(poke[i][j);
    }
}

function atart(){
    var button = document.getElementById("start");
    button.addEventListener("click",play,false);
    var chips = document.getElementById("chip");

    for(i = 0 ; i < 12 ; i++){   //存取撲克牌位置
        //pokeimage[i] = document.getElementById("poke" +(i + 1));
        pokeimage[i] = i;
        document.writeln(pokeimage[i]);
    }
}

function clear(){

}
window.addEventListener('load',start,false);
