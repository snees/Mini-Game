<?php
    include_once "../head.php";
?>
<script>
    $(document).prop('title', 'HANG MAN');
    var word = "";
    var len;
    var cnt;
    
    $(document).ready(function(){

        /* 시작 버튼 */
        $("#startBtn").on("click", function(){

            $.post("./word.php",function(data){
                word = data;
                cnt = word.length + 5;

                $("#startBtn").hide();
                $(".RestartBtn").show();
                $(".enBtn").show();
                $(".game").show();
                $(".game").css("display", "flex");

                $(".game").empty();
                $("#count").val(cnt);

                len = word.length;


                var wordDiv = [];
                

                for(var i=0; i<len; i++){
                    wordDiv[i] = "<input type='text' class='word' id='word"+[i]+"' disabled='true' value='*'>";
                    wordDiv[i] += "<input type='hidden' class='word' id='hidden"+[i]+"' disabled='true' value='"+word.charAt(i)+"' style='display:none;'>";
                    
                    $(".game").append(wordDiv[i]);
                } 

            });
        });

        /* 실패 후 재시작 */
        $(".RestartBtn").on("click",function(){
            $.post("./word.php",function(data){
                word = data;
                cnt = word.length + 5;

                $("#gamestart").show();
                $("#gameover").hide();

                $(".game").empty();
                $("#count").val(cnt);
                $(".enBtn").show();
                $(".game").show();
                $(".game").css("display", "flex");

                len = word.length;

                var wordDiv = [];

                for(var i=0; i<len; i++){
                    wordDiv[i] = "<input type='text' class='word' id='word"+[i]+"' disabled='true' value='*'>";
                    wordDiv[i] += "<input type='hidden' class='word' id='hidden"+[i]+"' disabled='true' value='"+word.charAt(i)+"' style='display:none;'>";
                    
                    $(".game").append(wordDiv[i]);
                    $(".alpha").attr("disabled", false);
                    $(".alpha").css("color", "white");
                    $(".alpha").css("cursor", "pointer");
                }

            });

        });

    });

    /* 알파벳 버튼 */
    function alpha(alphabet){

        if($("#count").val() == 1){
            $("#gamestart").hide();
            $("#gameover").css("display","flex");
            $(".RestartBtn").show();
            $("#showWord").empty();
            $("#showWord").append("<h1>! ANSWER !</h1>");
            $("#showWord").append("<h2>"+word+"</h2>");
        }else{
            $("#count").val(--cnt);
            $("."+alphabet).attr("disabled", true);
            $("."+alphabet).css("color", "black");
            $("."+alphabet).css("cursor", "auto");
            for(var i=0; i<word.length; i++){
                var hiddenEn = $("#hidden"+[i]).val();
                if(hiddenEn == alphabet){
                    $("#word"+[i]).val(hiddenEn);
                    $("#word"+[i]).css("color", "white");
                    if(len-- == 1){
                        $(".enBtn").hide();
                    }
                }
            }
        }
    }
    
</script>
    <div class="gamestart" id="gamestart">
        <div class="title d-flex">
            <h1>HANG MAN</h1>
            <input type="hidden" id="wordInput"/>
        </div>
        <div class="game d-flex"></div>
        <div class="answer d-flex"></div>
        <div class="enBtn">
            <div><input type="text" id="count" disabled></div>
            <div>
                <button type="button" class="A alpha" value="A" onclick="alpha(this.value)">A</button>
                <button type="button" class="B alpha" value="B" onclick="alpha(this.value)">B</button>
                <button type="button" class="C alpha" value="C" onclick="alpha(this.value)">C</button>
                <button type="button" class="D alpha" value="D" onclick="alpha(this.value)">D</button>
                <button type="button" class="E alpha" value="E" onclick="alpha(this.value)">E</button>
                <button type="button" class="F alpha" value="F" onclick="alpha(this.value)">F</button>
                <button type="button" class="G alpha" value="G" onclick="alpha(this.value)">G</button>
                <button type="button" class="H alpha" value="H" onclick="alpha(this.value)">H</button>
                <button type="button" class="I alpha" value="I" onclick="alpha(this.value)">I</button>
                <button type="button" class="J alpha" value="J" onclick="alpha(this.value)">J</button>
                <button type="button" class="K alpha" value="K" onclick="alpha(this.value)">K</button>
                <button type="button" class="L alpha" value="L" onclick="alpha(this.value)">L</button>
                <button type="button" class="M alpha" value="M" onclick="alpha(this.value)">M</button>
            </div>
            <div>
                <button type="button" class="N alpha" value="N" onclick="alpha(this.value)">N</button>
                <button type="button" class="O alpha" value="O" onclick="alpha(this.value)">O</button>
                <button type="button" class="P alpha" value="P" onclick="alpha(this.value)">P</button>
                <button type="button" class="Q alpha" value="Q" onclick="alpha(this.value)">Q</button>
                <button type="button" class="R alpha" value="R" onclick="alpha(this.value)">R</button>
                <button type="button" class="S alpha" value="S" onclick="alpha(this.value)">S</button>
                <button type="button" class="T alpha" value="T" onclick="alpha(this.value)">T</button>
                <button type="button" class="U alpha" value="U" onclick="alpha(this.value)">U</button>
                <button type="button" class="V alpha" value="V" onclick="alpha(this.value)">V</button>
                <button type="button" class="W alpha" value="W" onclick="alpha(this.value)">W</button>
                <button type="button" class="X alpha" value="X" onclick="alpha(this.value)">X</button>
                <button type="button" class="Y alpha" value="Y" onclick="alpha(this.value)">Y</button>
                <button type="button" class="Z alpha" value="Z" onclick="alpha(this.value)">Z</button>
            </div>
        </div>
        <div class="btnDiv d-flex">
            <button type="button" id="startBtn">Start</button>
            <button type="button" class="RestartBtn">Restart</button>
        </div>
    </div>
    <div class="gameover" id="gameover">
        <div class="title d-flex">
            <h1>GAME OVER</h1>
        </div>
        <div id="showWord">
        </div>
        <div class="btnDiv d-flex">
            <button type="button" class="RestartBtn">Restart</button>
        </div>
    </div>
<?php
    include_once "../footer.php";
?>