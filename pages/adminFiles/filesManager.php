	<?php
		$files = $ObjectITSAFiles->getAllFilesForAdmin();
		$idAlumno 		  = 0;
		$idAlumnoAnterior = 0;
		echo "<div class='col-md-12'>";
		foreach ($files as $file) {
			$idAlumno = $file["idAlumno"];
			if($idAlumno!=$idAlumnoAnterior){
				echo "<div class='row'></div>";
				echo "<center><h1>".$file["vNombre"]."</h1></center></br></br>";
			}
			$idAlumnoAnterior = $idAlumno;
			echo "<div class='col-md-2'>";
				echo "<div class='col-md-12'>";
					echo "<img src='../img/pdf.png' style='margin-left:40px;' />";
				echo "</div>";
				echo "<div class='col-md-12'>";
					echo "<center><p>".$file["nombreDocumento"]."</p></center>";
				echo "</div>";
			echo "</div>";
		}
		echo "</div>";

	?>