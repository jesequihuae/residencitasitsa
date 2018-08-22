	<?php
		$files = $ObjectITSAFiles->getAllFilesForAdmin();
		$idAlumno 		  = 0;
		$idAlumnoAnterior = 0;
		echo "<div class='col-md-12'>";
		foreach ($files as $file) {
			$idAlumno = $file["idAlumno"];
			if($idAlumno!=$idAlumnoAnterior){
				echo "<div class='row'></div>";
				echo "<center><h1><i class='glyphicon glyphicon-user'></i> ".$file["vNombre"]." ".$file["vApellidoPaterno"]." ".$file["vApellidoMaterno"]."</h1></center></br></br>";
			}
			$idAlumnoAnterior = $idAlumno;
			echo "<div class='col-md-2 borderFile'>";
				echo "<div class='col-md-12'>";
					echo "<img src='../img/pdf.png' style='margin-left:40px;' />";
				echo "</div>";
				echo "<div class='col-md-12'>";
					echo "<center><p class='titleFile'>".$file["nombreDocumento"]."</p></center>";
				echo "</div>";
				echo "<div class='col-md-12'>";
				echo "<div class='col-md-6'>";
				    echo "<div class='col-md-12'>AI</div>";
					 if($file["bAceptadoAI"] == 1){
					     	echo "<img src='../img/check.png' />";
					 }else{
					     	echo "<img src='../img/uncheck.png' />";
					 }
				echo "</div>";
				echo "<div class='col-md-6'>";
				    echo "<div class='col-md-12'>AE</div>";
					 if($file["bAceptadoAE"] == 1){
					     	echo "<img src='../img/check.png' />";
					 }else{
					     	echo "<img src='../img/uncheck.png' />";
					 }
				echo "</div>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";

	?>