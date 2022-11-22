<?php
    include_once "../head.php";
?>
<script>
   $(document).prop('title', 'Tetris');
   $(document).ready(function(){
        $("#recordBtn").on("click", function(){
            console.log($(document).prop('title'));
        });
   });
</script>
<div class="gamestart" id="gamestart">
    <div class="title d-flex">
        <h1>Tetris</h1>
    </div>
    <div class="btnDiv d-flex">
        <button type="button" id="startBtn" class="startBtn">Start</button>
    </div>
</div>
<div class="score">0</div>
<div class="map">
    <ul></ul>
</div>
<div class="gameover" id="gameover">
    <div class="title d-flex">
        <h1>GAME OVER</h1>
    </div>
    <div class="lastScore">
    </div>
    <div class="btnDiv d-flex">
        <button type="button" class="RestartBtn">Restart</button>
    </div>
</div>
<script src = "./tetris.js"></script>
<?php
    include_once "./footer.php";
?>