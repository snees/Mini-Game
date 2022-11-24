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
<div class="manual hidden">
    <ul>
        <li class="ko"> 기본 방향 키로 좌우, 아래로 움직일 수 있습니다.</li>
        <li class="ko"> 윗쪽 방향 키 또는 'Z'키로 블록의 모양을 변경할 수 있습니다.</li>
        <li class="ko"> 'C'키를 사용하여 현재 블록을 잠시 보류해둘 수 있습니다.</li>
        <li class="ko"> 'ESC'키를 사용하여 게임을 잠시 중단 가능합니다.</li>
    </ul>
</div>
<div class="tetrisHeader d-flex">
    <span class="hidden">hold</span>
    <div class="score">Score : 0</div>
    <div class="infoDiv hidden">
        <!-- <button type="button" class="infoBtn"><img src="./infoIcon.png" class="infoIcon"></img></button> -->
    </div>
</div>
<div class="tetrisBdoy d-flex">
    <div class="hold">
        <ul></ul>
    </div>
    <div class="map d-flex">
        <ul></ul>
    </div>
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