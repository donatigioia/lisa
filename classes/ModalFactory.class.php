<?php

include 'CategoryList.class.php';

class ModalFactory 
{
	public function printCategory()
	{	
		$categoryList  = new CategoryList();
		$categories    = $categoryList->output();
		$categoryValue = "";

		foreach($categories as $value)
		{
			$categoryValue.= "<option value=\"".$value["Parent"]." -> ".$value["Name"]."\">".$value["Parent"]." -> ".$value["Name"]."</option>";
		}
		return $categoryValue;
	}
}