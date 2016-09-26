<?php
$user=$_GET["user"];
$target_dir = "../UsersProjects/".$user."/";

if (!file_exists($target_dir))
{ 
	if(!file_exists("../UsersProjects"))
	{
		mkdir("../UsersProjects/", 0700);
	}
	mkdir("../UsersProjects/".$_GET["user"], 0700);
}


$uploadOk = 1;
$target_dir = "../UsersProjects/".$_GET["user"]."/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
$msg="";

// Check if file already exists
if (file_exists($target_file)) {
    $msg.="&msg=Sorry, file already exists.&type=error";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000000) {
   $msg.="&msg=Sorry, your file is too large.&type=error";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "sdlxliff")
{
    $msg.="&msg=Sorry, only sdlxlifffiles are allowed.&type=error";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
   $msg.="&msg=Sorry, your file was not uploaded.&type=error";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $msg.="&msg=The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.&type=success";
    } else {
        $msg.="&msg=Sorry, there was an error uploading your file.&type=error";
    }
}
?>
<script>
 window.open("../FileList.php?user=" + "<?php print $user; ?>"+"<?php print $msg; ?>"+"&type=info"); 
</script>