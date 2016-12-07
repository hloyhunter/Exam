<?php include("lib/DBTool.php");

	  $job = isset($_POST["Job"]) ? $_POST["Job"] : "";
	  $QID = isset($_POST["QuestionID"]) ? $_POST["QuestionID"] : "";
	  $QT = isset($_POST["QuestionText"]) ? $_POST["QuestionText"] : "";
	  $QS = isset($_POST["QuestionScore"]) ? $_POST["QuestionScore"] : "";

	  $OTS = isset($_POST["Options"]) ? $_POST["Options"] : "";

	  switch ($job) {
		  case "Read":
			  echo ReadQuestions();
			  break;
		  case "Add":
			  echo AddQuestion($QT, $QS, $OTS);
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
                            <!--<input type="button" class="btn btn-sm btn-warning Modify" value="修改" />-->
                            <input type="button" class="btn btn-sm btn-danger Delete" value="刪除" />
                            <input type="hidden" class="QID" value="' . $item["QuestionID"] . '"
                        </td>
                        <td>' . $item["QuestionText"] . '</td>
                        <td>';
			  $options = $DB->Query("select * from Options o where o.QuestionID = :QID", Array(":QID" => $item["QuestionID"]));
			  foreach ($options as $opt) {
				  if ($opt["isCorrect"]) {
					  $html .= '<span style="color: green"><i class="fa fa-check"></i></span>';
				  }
				  $html .= $opt["OptionText"] . '<br />';
			  }
			  $html .= '
                        </td>
                                <td>' . $item["QuestionScore"] . '</td>
                            </tr>';
		  }

		  return $html;
	  }

	  function AddQuestion($QuestionText, $QuestionScore, $Options = null)
	  {
		  $DB = new Database();
		  $uuid = $DB->Query("select uuid() as UUID")[0]["UUID"];
		  $sql = "insert into Questions (`QuestionID`, `QuestionText`, `QuestionScore`) values (:UUID, :QT, :QS)";
		  $params = Array(":UUID" => $uuid, ":QT" => $QuestionText, ":QS" => $QuestionScore);

		  $result = $DB->ExecuteNonQuery($sql, $params);

		  if (count($Options) > 0) {
			  echo '';
			  $result = AddOptions($uuid, $Options);
		  }
		  return $result;
	  }

	  function AddOption($QuestionID, $OptionText, $isCorrect)
	  {
		  $DB = new Database();
		  $sql = "insert into Options (`OptionID`, `QuestionID`, `OptionText`, `isCorrect`) values (uuid(),:QID,:OT,:IC)";
		  $params = Array(":QID" => $QuestionID, ":OT" => $OptionText, ":IC" => $isCorrect);

		  $result = $DB->ExecuteNonQuery($sql, $params);
		  return $result;
	  }

	  function AddOptions($QuestionID, $OptionArr)
	  {
		  $result = 1;
		  foreach ($OptionArr as $key => $value) {
			  if (!AddOption($QuestionID, $key, $value)) {
				  $result = 0;
			  }
		  }
		  return $result;
	  }

	  function DeleteQuestion($QuestionID)
	  {
		  $DB = new Database();
		  $sql = "delete from Questions where QuestionID = :QID";
		  $params = Array(":QID" => $QuestionID);

		  return $DB->ExecuteNonQuery($sql, $params);
	  }