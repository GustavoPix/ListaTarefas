<?php
namespace Source\Sql;

class Sql{
    const HOSTNAME = SQL_HOSTNAME; 
    //const HOSTNAME = "debugilustranext.cgiahar3vemw.us-east-2.rds.amazonaws.com"; //dev
	const USERNAME = SQL_USERNAME;
	const PASSWORD = SQL_PASSWORD;
    const DBNAME = SQL_DBNAME;

    
    private $conn;
	public function __construct()
	{
		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD,
			array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
		);
	}
	private function setParams($statement, $parameters = array())
	{
		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);
		}
	}
	private function bindParam($statement, $key, $value)
	{
		$statement->bindParam($key, $value);
	}
	public function query($rawQuery, $params = array())
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
	}
	public function select($rawQuery, $params = array()):array
	{
		$stmt = $this->conn->prepare($rawQuery);
		$this->setParams($stmt, $params);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		//return "echoo";
	}
}

?>