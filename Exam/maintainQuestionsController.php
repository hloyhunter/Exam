<?php include("lib/DBTool.php");

$job = $_POST["Job"];
$QID = $_POST["QuestionID"];
$QT = $_POST["QuestionText"];
$QS = $_POST["QuestionScore"];

switch ($job) {
    case "Read":
        echo ReadQuestions();
        break;
    case "Add":
        echo AddQuestion($QT, $QS);
        break;
    case "Delete":
        echo DeleteQuestion($QID);
        break;
    default:
        break;
}

function ReadQuestions()
{
    $DB = new Database();
    $result = $DB->Query("select * from Questions");

    $i = 0;
    $html = "";
    foreach ($result as $item) {
        $html .= '
                            <tr row-num="' . $i . '">
                                <td>
                                    <input type="button" class="btn btn-sm btn-warning Modify" value="修改" />
                                    <input type="button" class="btn btn-sm btn-danger Delete" value="刪除" />
                                    <input type="hidden" class="QID" value="' . $item["QuestionID"] . '"
                                </td>
                                <td>' . $item["QuestionText"] . '</td>
                                <td>' . $item["QuestionScore"] . '</td>
                            </tr>
                        ';
    }

    return $html;
}

function AddQuestion($QuestionText, $QuestionScore)
{
    $DB = new Database();
    $sql = "insert into Questions (`QuestionID`, `QuestionText`, `QuestionScore`) values (uuid(), :QT, :QS)";
    $params = Array(":QT" => $QuestionText, ":QS" => $QuestionScore);

    return $DB->ExecuteNonQuery($sql, $params);
}

function DeleteQuestion($QuestionID)
{
    $DB = new Database();
    $sql = "delete from Questions where QuestionID = :QID";
    $params = Array(":QID" => $QuestionID);

    return $DB->ExecuteNonQuery($sql, $params);
}