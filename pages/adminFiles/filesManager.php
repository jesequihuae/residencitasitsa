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
					echo "<center>";
						echo "<img data-id='".$file["UUIDDoc"]."' class='open-AddBookDialog' src='../img/pdf.png' with='100' height='100' style='margin:10px;' />";
					echo "</center>";
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

	<style>
		.pdfobject-container { height: 1000px;}
		.pdfobject { border: 1px solid #666; }
	</style>
	

		<!-- Large modal -->
	<button type="button" style="display: none;" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</button>

	<div class="modal fade bs-example-modal-lg" id='myModal' tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	     <div id="example1" styles="1200px;700px;"></div>
	    </div>
	  </div>
	</div>

