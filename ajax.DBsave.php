<?php
    include_once "./db.php";

    $game = $_REQUEST['game'];
    $userID = $_REQUEST['userid'];
    $score = intval($_REQUEST['score']);
    $mode = $_REQUEST['mode'];
    $time = $_REQUEST['time'];

    if($game == "tetris"){
        $SQL = "INSERT INTO {$game} (userID, score, regDate) VALUES ('{$userID}', $score, now())";
    }else{
        $SQL = "INSERT INTO {$game} (userID, mode, timelapse ,regDate) VALUES ('{$userID}', '{$mode}', $time, now())";
    }
    $res = mysqli_query($conn, $SQL);

    $arrayData = array('SQL'=>$res ,'game'=>trim($game), 'userID'=> trim($userID), 'score'=>trim($score), 'mode'=>trim($mode), 'time'=> $time);
    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
?>