<?php include ("lib/DBTool.php"); ?>
<!DOCTYPE html>
    <html>
<head>
    <title>考試!</title>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
</head>
<body>
<form method="POST" action="checkAnswer.php">
<?php
	$DB = new Database();
    $questions = $DB->Query("select * from Questions q");
    $i = 1;
    foreach ($questions as $row) {
        echo $i.". ".$row["QuestionText"]."(".$row["QuestionScore"]."%)<br />";
        echo "<input type='hidden' name='Question".$i."' id='Question".$i."' value='".$row["QuestionID"]."' />";

        $options = $DB->Query("select * from Options o where o.QuestionID = :QID", Array(":QID" => $row["QuestionID"]));
        foreach ($options as $oRow) {
            echo "<input type='radio' name='Answer".$i."' value='".$oRow["OptionID"]."' />".$oRow["OptionText"]."<br />";
        }
        echo "<br />";
        $i++;
    }
?>
    <br />
    <input type="submit" id="btnSubmit" value="送出答案" />
</form>
</body>
</html>
