<!DOCTYPE html>
    <html>
<head>
    <title>分數</title>
</head>
<body>
<?php
include("lib/DBTool.php");

$score = 0;

foreach($_POST as $key => $value) {
    if(substr($key, 0, 8) == "Question") {
        $i = (int)substr($key, -1);
        $QID = $value;
        $AID = $_POST["Answer".$i];
        $sql = "select o.isCorrect, (select QuestionScore from Questions where QuestionID = o.QuestionID) score from Options o where o.OptionID = '".$AID."'";
        //echo $sql;
        $qry = SqlSelect($sql);
        $row = $qry->fetch_assoc();

        if($row["isCorrect"] == 1) {
            echo "<p>第".$i."題： <span style='color: green'>正確。</span></p>";
            $score += $row["score"];
        } else {
            echo "<p>第".$i."題： <span style='color: red'>錯誤。</span></p>";
        }
    }
}
echo "<strong>您的總分：".$score."</strong><br />";

?>
</body>
</html>

