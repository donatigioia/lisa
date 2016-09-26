<?php
    $file= $_GET["document"];
    $user=$_GET["user"];
    echo $file;
	unlink("../".$file);
?>
<script >
	window.close();
	window.open("../FileList.php?user=" + "<?php print $user; ?>"+"&msg=document deleted!"+"&type=success"); 
</script>