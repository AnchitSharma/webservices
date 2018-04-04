<?php
 class dbmodel
 {
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "a_database";
	public function __construct()
	{
 		try {
          $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
         // set the PDO error mode to exception
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $this->db = $conn;
		  //echo "Connected successfully<br />"; 
            }
          catch(PDOException $e)
            {
             //echo "Connection failed: " . $e->getMessage();
            }
	}
 }
 
 //$obj = new dbmodel();
 //print_r($obj->check);
?>