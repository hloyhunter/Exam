<?php

class Database
{
	private $Server;
	private $User;
	private $Password;
	private $Database;

	function __construct()
	{
		$config = parse_ini_file($_SERVER["DOCUMENT_ROOT"] . "/Exam/Config.ini", true);
		$this->Server = $config["Database"]["Server"];
		$this->User = $config["Database"]["User"];
		$this->Password = $config["Database"]["Password"];
		$this->Database = $config["Database"]["Database"];
	}

	//參數化查詢，回傳查詢結果Array
	public function Query($sql, $params = null)
	{
		$result = null;
		try {
			//Create connection
			$conn = new PDO("mysql:host=$this->Server;dbname=$this->Database", $this->User, $this->Password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			//Bind SQL and Parameters
			$stmt = $conn->prepare($sql);
			if ($params != null) {
				$assign = Array();
				foreach ($params as $key => $value) {
					$stmt->bindParam($key, $assign[$key]);
				}
				foreach ($params as $key => $value) {
					$assign[$key] = $value;
				}
			}

			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result = $stmt->fetchAll();

		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		finally {
			$conn = null;
		}
		return $result;
	}

	//非查詢，成功回傳true，否則false
	public function ExecuteNonQuery($sql, $params = null)
	{
		$result = null;
		try {
			//Create connection
			$conn = new PDO("mysql:host=$this->Server;dbname=$this->Database", $this->User, $this->Password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			//Bind SQL and Parameters
			$stmt = $conn->prepare($sql);
			if ($params != null) {
				$assign = Array();
				foreach ($params as $key => $value) {
					$stmt->bindParam($key, $assign[$key]);
				}
				foreach ($params as $key => $value) {
					$assign[$key] = $value;
				}
			}

			$result = $stmt->execute();

		}
		catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
		finally {
		    $conn = null;
		}
		return $result;
	}
}