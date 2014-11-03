<?php
$box = $_POST['csvdata'];
$filename = $_POST['EADfilename'] . ".xml";


		header("Cache-Control: ");
		header("Content-type: text/plain; charset=utf-8");
   		header("Content-Disposition: attachment; filename=" . $filename . "");
	
 echo $box;
?>