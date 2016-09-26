<?php 

include 'ModifyCommentXMLFile.class.php';

$translation = new ModifyCommentXMLFile();
$translation->file = "../".$_GET["inputFile"];
$translation->removeComment($typeComment);
