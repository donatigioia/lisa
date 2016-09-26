<?php 

include 'classes/ModifyCommentXMLFile.class.php';

$translation = new ModifyCommentXMLFile();
$translation->file = $_GET["inputFile"];
$file= $translation->file;
$typeComment = $_GET["typeComment"];

$translation->addComment($typeComment);
?>

