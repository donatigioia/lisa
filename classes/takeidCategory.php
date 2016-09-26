<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'PortalConnection.class.php';

class takeIdCategory
{
	public function __construct()
	{
		$this->pdo = PortalConnection::getConnection();
	}

	public function getId()
	{
		$category = explode("->", $_GET["category"]);
		$category[0]= trim($category[0]);
		$category[1]= trim($category[1]);
		$q = $this->pdo->prepare("SELECT code FROM QA_Review_Categories WHERE Parent = '$category[0]' and Name = '$category[1]'");
		$q->execute();
		return $q->fetchAll();
	}

	public function getNameCategory($idCategory)
	{
	
		$q = $this->pdo->prepare("SELECT Parent,Name FROM QA_Review_Categories WHERE code = '$idCategory'");
		$q->execute();
		return $q->fetchAll();
	}
}
