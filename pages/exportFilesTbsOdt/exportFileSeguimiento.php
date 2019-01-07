<?php

// Include classes
@session_start();
include_once('tbs_class.php'); // Load the TinyButStrong template engine
include_once('tbs_plugin_opentbs.php'); // Load the TinyButStrong template engine
include_once('../../php/connection.php');
include_once('../../php/alumnosTemporal.class.php');

// Initialize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin
$objAl = new alumnosTemporal($handler);

$infoAlumno = $objAl->getInfoParaSeguimiento();
$cron       = $objAl->obtenerCronograma($_GET["idSeg"]);



$i = 0;
$actual = "";
$anterior = "";
foreach ($cron as $r) {
  $actual = $r["iSemana"];
  switch ($i) {
    case 0: $TBS->VarRef['a1']    = $r["iSemana"]; break;
    case 1: $TBS->VarRef['a2']    = $r["iSemana"]; break;
    case 2: $TBS->VarRef['a3']    = $r["iSemana"]; break;
    case 3: $TBS->VarRef['a4']    = $r["iSemana"]; break;
    case 4: $TBS->VarRef['a5']    = $r["iSemana"]; break;
    case 5: $TBS->VarRef['a6']    = $r["iSemana"]; break;
  }
  $i++;
}



//print_r($cron);
//exit();
$data = array();
$actual = "";
$anterior = "";
$index = 0;

//print_r($cron);
//exit();

for($i = 0;$i < count($cron); $i++) {
  $actual = $cron[$i]["vNombre"];

  if($actual != $anterior){
    $array = array(
                   'rank'=> 'A',
                   'activity'=>$actual,
                   'type'=>'R',
                   's1'=>"",
                   's2'=>"",
                   's3'=>"",
                   's4'=>"",
                   's5'=>"",
                   "s6"=>"");
  }

  switch ($index) {
    case "0": $array['s1']            = "x"; break;
    case "1": $array['s2']            = "x"; break;
    case "2": $array['s3']            = "x"; break;
    case "3": $array['s4']            = "x"; break;
    case "4": $array['s5']            = "x"; break;
    case "5": $array['s6']            = "x"; break;
  }

  if($cron[$i]["vNombre"] != $cron[$i+1]["vNombre"]){
      $array["activity"] = $actual;
      $data[] = $array;
  }
  $anterior = $actual;

  if($cron[$i]["iSemana"] != $cron[$i+1]["iSemana"]){
      $index++;
  }

}






$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;
$x_delete = 1;

// -----------------
// Load the template
// -----------------

$template = 'filesOdt/seguimientoRes2018.odt';
$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).



if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

$vNombreAlumno                = $infoAlumno["nombreAlumno"];
$proyecto                     = $infoAlumno["vNombreProyecto"];
$ai                           = $infoAlumno["asesorInterno"];
$ae                           = $infoAlumno["asesorExterno"];
$p                            = $infoAlumno["vPeriodo"];
$nc                           = $infoAlumno["vNumeroControl"];
$e                            = $infoAlumno["vNombreEmpresa"];

$TBS->VarRef['nombre']              = "".$vNombreAlumno;
$TBS->VarRef['proyecto']            = "".$proyecto;
$TBS->VarRef['ai']                  = "".$ai;
$TBS->VarRef['ae']                  = "".$ae;
$TBS->VarRef['p']                   = "".$p;
$TBS->VarRef['nc']                  = "".$nc;
$TBS->VarRef['e']                   = "".$e;


$TBS->MergeBlock('a,b', $data);


// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
if ($save_as==='') {
    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
    exit();
} else {
    $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
    exit("File [$output_file_name] has been created.");
}

?>
