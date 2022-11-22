<?php
    include_once "./head.php";

    $rankArr = ["1st", "2nd", "3rd", "4th", "5th", "6th", "7th", "8th", "9th" , "10th"];
    $tIdx=0;
    $eIdx=0;
    $hIdx=0;
?>
<div class="tableDiv d-flex">
    <div class="TetrisDiv tblWid">
        <table>
            <tr><th colspan="3" class="tableTitle">TETRIS</th></tr>
            <?php
                $tetrisSQL = "SELECT * FROM tetris WHERE (1) ORDER BY score DESC Limit 10";
                $tetrisRes = mysqli_query($conn, $tetrisSQL);

                forEach($tetrisRes as $row){
            ?>
                <tr>
                    <th><?php echo $rankArr[$tIdx++]; ?></th>
                    <td><?php echo $row['userID']; ?></td>
                    <td><?php echo $row['score']; ?></td>
                </tr>
            <?php
                }
            ?>
            <?php
                for($i=$tIdx; $i<count($rankArr); $i++){
                    echo "<tr>";
                    echo "<td>".$rankArr[$i]."</td>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    <div class="MemoryEasy tblWid">
        <table>
            <tr><th colspan="3" class="tableTitle">Memory - Easy Mode</th></tr>
            <?php
                $easySQL = "SELECT * FROM memory WHERE mode='easy' ORDER BY timelapse DESC Limit 10";
                $easyRes = mysqli_query($conn, $easySQL);

                forEach($easyRes as $row){
            ?>
                <tr>
                    <th><?php echo $rankArr[$eIdx++]; ?></th>
                    <td><?php echo $row['userID']; ?></td>
                    <td><?php echo $row['timelapse']; ?></td>
                </tr>
            <?php
                }
            ?>
            <?php
                for($i=$eIdx; $i<count($rankArr); $i++){
                    echo "<tr>";
                    echo "<th>".$rankArr[$i]."</th>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
    <div class="MemoryHard tblWid">
        <table>
            <tr><th colspan="3" class="tableTitle">Memory - Hard Mode</th></tr>
            <?php
                $hardSQL = "SELECT * FROM memory WHERE mode='hard' ORDER BY timelapse DESC Limit 10";
                $hardRes = mysqli_query($conn, $hardSQL);

                forEach($hardRes as $row){
            ?>
                <tr>
                    <th><?php echo $rankArr[$hIdx++]; ?></th>
                    <td><?php echo $row['userID']; ?></td>
                    <td><?php echo $row['timelapse']; ?></td>
                </tr>
            <?php
                }
            ?>
            <?php
                for($i=$hIdx; $i<count($rankArr); $i++){
                    echo "<tr>";
                    echo "<th>".$rankArr[$i]."</th>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </div>
</div>
<?php
    include_once "./footer.php";
?>

