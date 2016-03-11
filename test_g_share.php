<html itemscope itemtype="http://schema.org/Article">
<head>
<!-- Add the following three tags inside head. -->
<meta itemprop="name" content="Title For Example.com">
<meta itemprop="description" content="Sample Description For The Article..">
<meta itemprop="image" content="http://www.example.com/1.jpg">
    
 </head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="like_table">
                              <tr><td>
					<div style="margin: 4px;float:left;padding: 5px;">
					
					<?php $url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
					echo "url= ".$url;
					?>
					<?php if($language=='en')
					 {
						 $lang="en_US";
					 }
					else 
					 {
						$lang="es_ES";
						
					 }
					 
					 ?>
					
					
                                        <div class="g-plusone" data-size="tall"  lang="<?=$lang?>"></div>
                                        <script type="text/javascript">
                                          (function() {
                                           var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                                           po.src = 'https://apis.google.com/js/client:plusone.js';
                                           var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                                         })();
                                        </script>			 
					 
					 
					
					</div>
					</td>
                              </tr>
                          </table>
</body>
</html>