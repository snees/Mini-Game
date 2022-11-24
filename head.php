<?php
    include_once "./db.php";
    $URI= $_SERVER['REQUEST_URI'];
?>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="#">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Covered+By+Your+Grace&family=Homemade+Apple&family=Kalam&family=Gaegu&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/20191735/head.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var page = '<?php echo $URI?>';
    page = page.split("/")[2];

    let regID = /^[가-힣a-zA-Z1-9 ]+$/;

    $(document).ready(function(){
        if(page == ""){
            $(".main").css("color", "#FFA7A7");
            $("#recordBtn").hide();
        }else if(page == "hangman"){
            $(".hangman").css("color", "#FFA7A7");
            $("#recordBtn").hide();
        }else if(page == "tetris"){
            $(".tetris").css("color", "#FFA7A7");
            $(".modal-title").append("테트리스 점수 저장");
        }else if(page == "memory"){
            $(".memory").css("color", "#FFA7A7");
            $(".modal-title").append("같은 그림 찾기 점수 저장");
        }else if(page == "ranking.php"){
            $(".ranking").css("color", "#FFA7A7");
        }

        
    });


</script>

<body>
    <div>
        <div class="modal fade" id="myModal" role="dialog"> <!-- 사용자 지정 부분① : id명 -->
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close modalClose" data-dismiss="modal">×</button>
                        <h4 class="modal-title ko"></h4>
                    </div>
                    <div class="modal-body">
                        <span>ID : </span><input type="text" class="inputUserId" id="inputUserId" name="inputUserId" autocomplete="off"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn modalSaveBtn" id="modalSaveBtn">Save</button>
                        <button type="button" class="btn modalCloseBtn" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="header">
            <ul class="d-flex justify-content-between">
                <div class="d-flex">
                    <li><a href="/20191735" class="fleft main">Main Page</a></li>
                    <li><a href="/20191735/hangman" class="fleft hangman">HANG MAN</a></li>
                    <li><a href="/20191735/tetris" class="fleft tetris">TETRIS</a></li>
                    <li><a href="/20191735/memory" class="fleft memory">MEMORY GAME</a></li>
                    <li><a href="/20191735/ranking.php" class="fleft ranking">RANKING</a></li>
                </div>
                <li><button type="button" class="ko record hidden" id="recordBtn">점수 기록하기</button></li>
            </ul>
            <button type="button" class="hidden modalBtn" id="hiddenBtn" data-toggle="modal" data-target="#myModal">점수 기록하기</button>
        </div>
