<?php
    include_once "../head.php";
?>
<script>

    document.cookie = "safeCookie1=foo; SameSite=Lax"; 
    document.cookie = "safeCookie2=foo"; 
    document.cookie = "crossCookie=bar; SameSite=None; Secure"; 

    var easyFile = ["./cardImg/cloverA.jpg",
            "./cardImg/diaA.jpg","./cardImg/diaJ.jpg", "./cardImg/diaQ.jpg",
            "./cardImg/heartA.jpg",
            "./cardImg/spadeA.jpg","./cardImg/spadeJ.jpg", "./cardImg/spadeQ.jpg"];

    var easyAlt = ["cloverA",
                "diaA", "diaJ", "diaQ",
                "heartA",
                "spadeA", "spadeJ", "spadeQ"];

    var hardFile = ["./cardImg/cloverA.jpg","./cardImg/cloverJ.jpg","./cardImg/cloverK.jpg","./cardImg/cloverQ.jpg",
            "./cardImg/diaA.jpg","./cardImg/diaJ.jpg","./cardImg/diaK.jpg","./cardImg/diaQ.jpg",
            "./cardImg/heartA.jpg","./cardImg/heartJ.jpg","./cardImg/heartK.jpg","./cardImg/heartQ.jpg",
            "./cardImg/spadeA.jpg","./cardImg/spadeJ.jpg","./cardImg/spadeK.jpg","./cardImg/spadeQ.jpg"];

    var hardAlt = ["cloverA", "cloverJ", "cloverK", "cloverQ",
                "diaA", "diaJ", "diaK", "diaQ",
                "heartA", "heartJ", "heartK", "heartQ", 
                "spadeA", "spadeJ", "spadeK", "spadeQ"];

    var clickCount = 0;
    let interval;
    let cardCount;
    let startTime;
    let timeLapse;
    let endTime;
    let mode = "easy";
    
    $(document).prop('title', 'Memory');
    
    $(document).ready(function(){

        $("#startBtn").on("click", function(){
            $("#gamestart").hide();
            $("#cardDeck").show();

            easyStart();

        });
        
        $("#resetBtn").on("click", function(){
            $("#wrapper > li").remove();
            $(".time").show();
            clearInterval(interval);

            if(mode == "easy"){
                easyStart();
            }else{
                hardStart();
            }

        });

        $("#easyMode").on("click", function(){
            mode = "easy";
            $(".easyMode").addClass("hidden");
            $(".hardMode").removeClass("hidden");
            $(".deckHead").css("width", "550px");
            $("#wrapper > li").remove();
            $(".time").show();
            clearInterval(interval);
            easyStart();
        });

        $("#hardMode").on("click", function(){
            mode = "hard";
            $(".hardMode").addClass("hidden");
            $(".easyMode").removeClass("hidden");
            $(".deckHead").css("width", "1100px");
            $("#wrapper > li").remove();
            $(".time").show();
            clearInterval(interval);
            hardStart();
        });

        $(".RestartBtn").on("click", function(){
            $("#wrapper > li").remove();
            $(".totalscore").addClass("hidden");
            $(".totalscore").empty();
            $(".RestartBtn").css("display", "none");
            $(".cardDeck").css("display", "block");
            $(".record").addClass("hidden");

            if(mode == "easy"){
                easyStart();
            }else{
                hardStart();
            }
        });

        $(".record").on("click", function(){
            $(".modalBtn").click();
        });

        $("#modalSaveBtn").on("click", function(){
            var user = $("#inputUserId").val();
            if(user != ""){
                if(!regID.test(user) || user.length < 3){
                    $("#inputUserId").val("아이디는 3자 이상의 한글, 영문, 숫자로만 입력가능합니다.");
                    $("#inputUserId").css("color", "#FFA7A7");
                }else{
                    $.post("http://121.174.117.167/20191735/ajax.DBsave.php", {
                        game : page,
                        userid : user,
                        mode : mode,
                        time : timeLapse
                    }, function(data){
                        if(data.SQL){
                            $(".modalCloseBtn").click();
                        }else{
                            alert("저장하지 못하였습니다.")
                        }
                    }, "json");
                }
            }else{
                $("#inputUserId").val("아이디를 입력해주세요.");
                $("#inputUserId").css("color", "#FFA7A7");
            }
        });
        $("#inputUserId").on("click", function(){
            $("#inputUserId").val("");
            $("#inputUserId").css("color", "black");
        });

    });

    $(document).on("click", ".card", function(e){

        var cName = $(this).attr("class");
        var cardShape = cName.split(" ")[1];
        var isBack = cName.split(" ")[2];
        
        /* 뒷면일 경우 clickCount++  */
        if(isBack == "back"){
            clickCount++;
            var path = "./cardImg/"+cardShape+".jpg";
            $(this).attr("src", path);
            $(this).removeClass("back");
            $(this).addClass("open");
        }

        /* 카드가 두장 뒤집히면 같은 모양인지 확인 */
        if(clickCount == 2){
            if(cardCount == 2){
                endTime = new Date;
                timeLapse = (endTime - startTime)/1000;
                setTimeout(() => {
                    $(".cardDeck").css("display", "none");
                    $(".totalscore").removeClass("hidden");
                    $(".totalscore").html("Time : " + timeLapse);
                    $(".RestartBtn").css("display", "block");
                    $(".record").removeClass("hidden");
                }, 500);
            }
            var openClass = document.querySelectorAll(".open");
            var shape = [];
            var i=0;
            openClass.forEach(cardOp=>{
                shape[i++] = cardOp.getAttribute("alt");
                clickCount = 0;
            })
            
            /* 같은 모양이 아닐 경우 back class 추가 */
            if(shape[0] != shape[1]){
                openClass.forEach(cardOp=>{
                    cardOp.classList.remove("open");
                    cardOp.classList.add("back");
                    setTimeout(() => {
                        cardOp.setAttribute("src", "./cardImg/back.png");
                    }, 500);
                })
            }
            /* 같은 모양일 경우 display : none */
            else{
                cardCount -= 2;
                openClass.forEach(cardOp=>{
                    cardOp.classList.remove("open");
                    setTimeout(() => {
                        cardOp.style.display="none";
                    }, 500);
                })
            }
        }
    });

    function easyStart(){
        var deck1 = [];
        var deck2 = [];
        var timeCount = 10;
        var k=0;
        cardCount = 16;

        while(deck1.length < 8){
            var randomNum = Math.floor(Math.random()*8);
            if(deck1.indexOf(randomNum) === -1){
                deck1.push(randomNum);
            }
        }
        while(deck2.length < 8){
            var randomNum = Math.floor(Math.random()*8);
            if(deck2.indexOf(randomNum) === -1){
                deck2.push(randomNum);
            }
        }
        var arr = [...deck1,...deck2];
        console.log(arr);
        for(var i=0; i<4; i++){
            $("#wrapper").append("<li><ul id='ul"+i+"'></ul></li>");
            for(var j=0; j<4; j++){
                $("#ul"+i).append("<li><img src="+ easyFile[arr[k]] +" class='card "+ easyAlt[arr[k]]+ "' alt='" + easyAlt[arr[k++]] + "'></img></li>");
            }
        }


        interval = setInterval(() => {
            $(".time").text(timeCount--);
            if(timeCount == -1){
                console.log("timeOut");
                $(".card").attr("src", "./cardImg/back.png");
                $(".card").addClass("back");
                $(".deckHead").removeClass("justify-content-between");
                $(".deckHead").css("justify-content", "right");
                $(".time").hide();
                startTime = new Date();
                clearInterval(interval);
            }
        }, 1000);
    }

    function hardStart(){

        var deck1 = [];
        var deck2 = [];
        var timeCount = 10;
        var k=0; 
        cardCount = 32;

        while(deck1.length < 16){
            var randomNum = Math.floor(Math.random()*16);
            if(deck1.indexOf(randomNum) === -1){
                deck1.push(randomNum);
            }
        }
        while(deck2.length < 16){
            var randomNum = Math.floor(Math.random()*16);
            if(deck2.indexOf(randomNum) === -1){
                deck2.push(randomNum);
            }
        }
        var arr = [...deck1,...deck2];
        console.log(arr);
        for(var i=0; i<4; i++){
            $("#wrapper").append("<li><ul id='ul"+i+"'></ul></li>");
            for(var j=0; j<8; j++){
                $("#ul"+i).append("<li><img src="+ hardFile[arr[k]] +" class='card "+ hardAlt[arr[k]]+ "' alt ='" + hardAlt[arr[k++]] + "'></img></li>");
            }
        }


        interval = setInterval(() => {
            $(".time").text(timeCount--);
            if(timeCount == -1){
                console.log("timeOut");
                $(".card").attr("src", "./cardImg/back.png");
                $(".card").addClass("back");
                $(".deckHead").removeClass("justify-content-between");
                $(".deckHead").css("justify-content", "right");
                $(".time").hide();
                $(".score").show();
                startTime = new Date();
                clearInterval(interval);
            }
        }, 1000);
    }
    
</script>
<div class="gamestart" id="gamestart">
    <div class="title d-flex">
        <h1>Memory Game</h1>
    </div>
    <div class="btnDiv d-flex">
        <button type="button" id="startBtn" class="startBtn">Start</button>
    </div>
</div>
<div class="cardDeck" id="cardDeck">
    <div class="d-flex justify-content-between deckHead">
        <h2 class="time">10</h2>
        <div>
            <button type="button" id="easyMode" class="easyMode hidden">easyMode</button>
            <button type="button" id="hardMode" class="hardMode">hardMode</button>
            <button type="button" id="resetBtn" class="resetBtn">reset</button>
        </div>
    </div>
    <ul id="wrapper"></ul>
</div>
<div class="hidden totalscore d-flex">
</div>
<div class="btnDiv d-flex">
    <button type="button" class="RestartBtn">Restart</button>
</div>
<!-- <script src="./memory.js"></script> -->
<?php
    include_once "../footer.php";
?>