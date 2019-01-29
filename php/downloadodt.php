<?php 
	if(isset($_GET['file'])) {
		$archivo = $_GET['file'];
		$nombreArchivo = $_GET['name'];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $nombreArchivo);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($archivo));

		ob_clean();
		flush();
		readfile($archivo);
	} else {
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
        exit;
	}

?>