<?php
 $file= "../".$_GET["document"];
 $user = $_GET["user"];

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
}
?>

<script >
    window.close();
    window.open("../FileList.php?user=" + "<?php print $user; ?>"+"&msg=document deleted!"+"&type=success"); 
</script>