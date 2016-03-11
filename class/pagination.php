<?php
 class pagination1 extends DB_Sql {

		      
		function paginate1($querystr,$file_name,$search,$page,$limit)
		{
         
		 
			$this->query($querystr);
			
			$numrows =$this->num_rows();
			$pages = intval($numrows/$limit); 
			if($numrows % $limit)  
				{ 
					$pages++; 
				}
		   if ($page != 0) { // Don't show back link if current page is first page. 
                $back_page = $page - $limit; 
                $str .="<a class=menuitem1 href=$file_name?page=$back_page&limit=$limit&$search>Previous</a>\n"; 
                } 
                for ($i=1; $i <= $pages; $i++) // loop through each page and give link to it. 
                { 
                 $ppage = $limit*($i - 1); 
				 //echo $ppage;
                 if ($ppage == $page ){ 
                 $str .="<font class=paging>$i</font>\n"; 
                 } // If current page don't give link, just text. 
                 else{ 
                 $str .="<a class=menuitem1 href=$file_name?page=$ppage&limit=$limit&$search>$i</a> \n"; 
                 } 
                } 
                if (!((($page+$limit) / $limit) >= $pages) && $pages != 1) { // If last page don't give next link. 
                $next_page = $page + $limit; 
                $str .="<a class=menuitem1 href=$file_name?page=$next_page&limit=$limit&$search>Next</a>"; 
                } 

			echo $str;
		}
		
		
		
	};
?>