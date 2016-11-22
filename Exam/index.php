<?php include("lib/DBTool.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>考試!</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-fluid">
    <br/>
    <div class="row">
        <div class="col-lg-8">
            <a href="maintainQuestions.php" class="btn btn-link pull-right">維護題目</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="checkAnswer.php">
                <?php
                $DB = new Database();
                $questions = $DB->Query("select * from Questions q");
                $i = 1;
                foreach ($questions as $row) {
                    echo $i . ". " . $row["QuestionText"] . "(" . $row["QuestionScore"] . "分)<br />";
                    echo "<input type='hidden' name='Question" . $i . "' id='Question" . $i . "' value='" . $row["QuestionID"] . "' />";

                    $options = $DB->Query("select * from Options o where o.QuestionID = :QID", Array(":QID" => $row["QuestionID"]));
                    foreach ($options as $oRow) {
                        echo "<div class='radio'><label><input type='radio' name='Answer" . $i . "' value='" . $oRow["OptionID"] . "'>" . $oRow["OptionText"] . "</label></div>";
                    }
                    echo "<br />";
                    $i++;
                }
                ?>
                <br/>
                <input type="submit" class="btn btn-primary" id="btnSubmit" value="送出答案"/>&nbsp;
                <input type="button" class="btn btn-warning" id="btnClear" value="清除答案" />
            </form>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#btnClear').click(function () {
            $('input[type=radio]').prop('checked', false);
        });
    });
</script>
</body>
</html>
