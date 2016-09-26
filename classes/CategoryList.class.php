<?php

include 'PortalConnection.class.php';

class CategoryList
{
	public function __construct()
	{
		$this->pdo = PortalConnection::getConnection();
	}

	public function output()
	{
		$this->categoryList = $this->getCategories();
		return $this->categoryList;
	}

	protected function getCategories()
	{
		$q = $this->pdo->prepare("SELECT * FROM QA_Review_Categories");
		$q->execute();

		return $q->fetchAll();
	}
}
