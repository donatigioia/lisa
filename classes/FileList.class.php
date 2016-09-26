<?php
class OpenFile
{    
	public function fileList()
	{	
	   	$user=$_GET["user"];
		$password=$_GET["pw"];

		$string="";

		foreach (glob("UsersProjects/".$user."/*.docx.sdlxliff") as $filename)
		{
			$size 	   = filesize($filename)/1024;
			$size 	   = substr($size, 0,-7)." kb";
			$filename_out  = substr($filename, 14);
			$string   .= "<tr role=\"row\" class=\"odd\">
							 <td class=\"v-align-middle semi-bold sorting_1 sorting_2\" id=\"filename\">	$filename_out 					 </td>
					         <td class=\"v-align-middle semi-bold sorting_1 sorting_2\">					$size               			 </td> 
					         <td><button type=\"button\" onclick=\"chooseFile('$filename','$user');\" class=\"btn btn-primary\" >  <i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i>  </button>   
					        <button type=\"button\" onclick=\"downloadFile('$filename','$user');\" class=\"btn btn-primary\"> <i class=\"fa fa-cloud-download\" aria-hidden=\"true\"></i>  </button> 
					        <button type=\"button\" onclick=\"deleteFile('$filename','$user');\" class=\"btn btn-danger btn-cons\"> <i class=\"fa fa-times\" aria-hidden=\"true\"></i>  </button> </td>
				          </tr>";
		}
		return $string;       
	}
}
?>
