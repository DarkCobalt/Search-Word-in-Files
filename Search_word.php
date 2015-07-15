<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="iso-8859-2" />
</head>
<body>
<?php

	function opend_dir($sciezka, $search){
		$tab = array();		
		if (is_dir($sciezka)) {
	        if ($folder = opendir($sciezka)) {
	            while (false !== ($report = readdir($folder))){
	                if (($report == ".") || ($report == "..")){
	                }else{
	                    if(is_dir($sciezka.$report)){
	                    	//echo 'To katalog: '.$report.'<br />';
	                    	array_push($tab, $report);
	                    }else{
	                    	//echo 'Plik: '.$report.'<br />';
	                    	search_word($sciezka.$report, $search);
	                    }
	                }
	            }
	            closedir($folder);
	        }
	    }else{
	        echo 'errror';
	    }	
		return $tab;	
	}
	
	function search_word($file, $word){
		$string = file_get_contents($file);	
		$lines = explode($string, "\n");			
		$matches = preg_grep("/^.*{$word}.*$/", file($file));
				
		
		echo '<table border="1">';
		echo '<tr><th></th><th>'.$file.'</th></tr>';
			foreach($matches as $key=>$m){
				echo '<tr><td>'.(intval($key)+1).'</td><td>'.strip_tags($m).'</td></tr>';	
			}
		echo '</table><br /><br />';
					
	}
	
	
    $sciezka = "include/";
	$searchWord = "vw|Vw|VW";
	$katalogi = array();
    $katalogi = opend_dir($sciezka, $searchWord);
	
	foreach($katalogi as $kat){
		$takietam = opend_dir($sciezka.$kat.'/', $searchWord);
		foreach($takietam as $tak){
			 opend_dir($sciezka.$kat.'/'.$tak.'/', $searchWord);
		}
	}
	
?>
</body>
</html>