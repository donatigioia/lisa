<?php
include 'takeidCategory.php';


class Report
{
    public function createReport()
    {
    	$sources   = "";
    	$fileName  = $_GET["inputFile"];
    	$file 	   = file_get_contents($fileName);
        $file 	   = str_replace("sdl:cid", "sdl_cid", $file);
        $file 	   = str_replace('sdl:revid', 'sdl_revid', $file);
        $file 	   = str_replace('sdl:cmt', 'sdl_cmt', $file);
        $file 	   = simplexml_load_string($file);
        $category  = new takeIdCategory();

        foreach ($file->file->body->group as $group)
        {
        	$sources .= " ".$group->{"trans-unit"}->source;
        }
        $categorys = array();
        foreach ($file->{"doc-info"}->{"rev-defs"}->{"rev-def"} as $item)
        {
        	$id = $item["fbCategory"]."";
        	if(array_key_exists($id,$category))
        	{
        		$categorys[$id][0]=$category[$id][0]+1;
        	}
        	else
        	{
        		$categorys[$id] = array(1,$category -> getNameCategory($id)[0][0]." ".$category -> getNameCategory($id)[0][1]);
        	}
        }
        $countError = $this->countError($categorys);
        $countWord 	   = substr_count($sources," ");
        $countCaracter = strlen(str_replace(" ", "", $sources));
        $table = "  <tr role=\"row\">
                            <th>         Word:                     </th>
                            <th>         Caracter:                 </th>
                            <th>         Error Detected:           </th>
                        </tr>       
                        <tr> 
                            <td>         $countWord                </th> 
                            <td>         $countCaracter            </th>
                            <td>         ".$countError."      </th>
                        </tr>
                </table>";
        
        $table2="
        <table  class=\"table table-hover dataTable no-footer\" id=\"tableWithSearch\" role=\"grid\" aria-describedby=\"tableWithSearch_info\" style=\"width:40%;\" >
            <thead>
            <tr role=\"row\">
                <th style=\"width: 70%;\">        Category Name:                    </th>
                <th style=\"width: 30%;\">        Occurrences Error:                </th>
            </tr>";      
        
        foreach ($categorys as $cat)
        {
        	$table2.= "     
            <tr>
                <td>".$cat[1]."</td>
                <td>".($cat[0])."</td>
            </tr>
            ";
        }

        $table2.="</table>";
        $report="";
        if($countWord*0.05 <count($categorys))
        {
            $report="<span style=\"color:green; font-weight:bold;\"> Success</span>";
        }
        else
        {
            $report="<span style=\"color:red; font-weight:bold;\"> Fail</span>";
        }
    return $table.$table2.$report;
    }
    
    private function countError($categorys)
    {
        $countError = 0;
        foreach ($categorys as $category)
        {
            $countError += $category[0];
        }
        return $countError;
    }
}
?>
