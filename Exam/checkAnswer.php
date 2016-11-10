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
    if(stripos($key, "Q") != false) {
        $i = (int)substr($key, -1);
        $QID = $value;
        $AID = $_POST["Answer".$i];
        $qry = SqlSelect("select o.isCorrect, (select QuestionScore from Questions where QuestionID = o.QuestionID) score from Options o where o.OptionsID = '".$AID."'");
        $row = $qry->fetch_assoc();
        $score += $row["QuestionScore"];
        if($row["iCorrect"] == 1) {
            echo "<p>第".$i."題： <span style='color: green'>正確。</span></p>";
        } else {
            echo "<p>第".$i."題： <span style='color: red'>錯誤。</span></p>";
        }
    } else {
        echo "GG<br />";
        continue;
    }
}
echo "<strong>您的總分：".$score."</strong><br />";

?>
</body>
</html>


