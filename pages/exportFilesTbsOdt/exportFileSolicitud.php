<?php

// Include classes
@session_start();
include_once('tbs_class.php'); // Load the TinyButStrong template engine
include_once('tbs_plugin_opentbs.php'); // Load the TinyButStrong template engine
include_once('../../php/connection.php');
include_once('../../php/alumnosTemporal.class.php');


$objAl = new alumnosTemporal($handler);

$infoAlumno = $objAl->getInfoSolicitud();

$fecha = $objAl->obtenerFechaEnLetra();


//print_r($infoAlumno);


//exit();


// prevent from a PHP configuration problem when using mktime() and date()
if (version_compare(PHP_VERSION,'5.1.0')>=0) {
    if (ini_get('date.timezone')=='') {
        date_default_timezone_set('UTC');
    }
}

// Initialize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// ------------------------------
// Prepare some data for the demo
// ------------------------------

// Retrieve the user name to display
$yourname = (isset($_POST['yourname'])) ? $_POST['yourname'] : 'Miguel Angel Rodriguez Cornejo';
$yourname = trim(''.$yourname);
if ($yourname=='') $yourname = "(no name)";

// A recordset for merging tables
$data = array();
$data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
$data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
$data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );

// Other single data items
$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;
$x_delete = 1;

// -----------------
// Load the template
// -----------------

//$template = 'demo.odt';
$template = 'solicitudRes2018.odt';

$TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).


// ----------------------
// Debug mode of the demo
// ----------------------
if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.
$nombreAlumno           = $infoAlumno["nombreAlumno"];
$vNumeroControl                 = $infoAlumno["vNumeroControl"];
$domicilio                      = $infoAlumno["domicilio"];
$colonia                        = $infoAlumno["colonia"];
$ciudadEstado                   = $infoAlumno["ciudadEstado"];
$cp                             = $infoAlumno["cp"];
$telefono                       = $infoAlumno["telefono"];
$vCorreoInstitucional           = $infoAlumno["vCorreoInstitucional"];
$bSexo                          = $infoAlumno["bSexo"];
$numeroSeguro                   = $infoAlumno["numeroSeguro"];
$vNombreJefeCarrera             = $infoAlumno["vNombreJefeCarrera"];
$vNombreCarrera                 = $infoAlumno["vNombreCarrera"];
$vTituloAnteProyecto            = $infoAlumno["vTituloAnteProyecto"];
$idOpcion                       = $infoAlumno["idOpcion"];

$vNombreEmpresa                 = $infoAlumno["vNombreEmpresa"];
$vCorreoElectronicoEmpresa      = $infoAlumno["vCorreoElectronicoEmpresa"];
$vDireccionEmpresa              = $infoAlumno["vDireccionEmpresa"];
$vTitularEmpresa                = $infoAlumno["vTitularEmpresa"];
$vContactoEmpresa               = $infoAlumno["vContactoEmpresa"];
$vRfcEmpresa                    = $infoAlumno["vRfcEmpresa"];
$idGiroEmpresa                  = $infoAlumno["idGiroEmpresa"];
$idSectorEmpresa                = $infoAlumno["idSectorEmpresa"];
$vCiudadEstadoEmpresa           = $infoAlumno["vCiudadEstadoEmpresa"];
$cpEmpresa                      = $infoAlumno["cpEmpresa"];
$vTelefonoEmpresa               = $infoAlumno["vTelefonoEmpresa"];
$vColoniaEmpresa                = $infoAlumno["vColoniaEmpresa"];


$TBS->VarRef['nombreAlumno']                = "".$nombreAlumno;
$TBS->VarRef['vNumeroControl']              = "".$vNumeroControl;
$TBS->VarRef['domicilio']                   = "".$domicilio;
$TBS->VarRef['colonia']                     = "".$colonia;
$TBS->VarRef['ciudadEstado']                = "".$ciudadEstado;
$TBS->VarRef['cp']                          = "".$cp;
$TBS->VarRef['telefono']                    = "".$telefono;
$TBS->VarRef['vCorreoInstitucional']        = "".$vCorreoInstitucional;
$TBS->VarRef['bSexo']                       = "".$bSexo;
$TBS->VarRef['numeroSeguro']                = "".$numeroSeguro;
$TBS->VarRef['vNombreJefeCarrera']          = "".$vNombreJefeCarrera;
$TBS->VarRef['vNombreCarrera']              = "".$vNombreCarrera;
$TBS->VarRef['vTituloAnteProyecto']         = "".$vTituloAnteProyecto;
$TBS->VarRef['fecha']                       = "".$fecha;

$TBS->VarRef["vNombreEmpresa"]              = "".$vNombreEmpresa;
$TBS->VarRef["vCorreoElectronicoEmpresa"]   = "".$vCorreoElectronicoEmpresa;
$TBS->VarRef["vDireccionEmpresa"]           = "".$vDireccionEmpresa;
$TBS->VarRef["vTitularEmpresa"]             = "".$vTitularEmpresa;
$TBS->VarRef["vContactoEmpresa"]            = "".$vContactoEmpresa;
$TBS->VarRef["vRfcEmpresa"]                 = "".$vRfcEmpresa;


$TBS->VarRef["vCiudadEstadoEmpresa"]        = "".$vCiudadEstadoEmpresa;
$TBS->VarRef["cpEmpresa"]                   = "".$cpEmpresa;
$TBS->VarRef["vTelefonoEmpresa"]            = "".$vTelefonoEmpresa;
$TBS->VarRef["vColoniaEmpresa"]             = "".$vColoniaEmpresa;

if($idOpcion == 1){
    $TBS->VarRef['vB']         = "X";
}else{
    $TBS->VarRef['vB']         = "";
}
if($idOpcion == 2){
    $TBS->VarRef['vP']        = "X";
}else{
    $TBS->VarRef['vP']        = "";
}
if($idOpcion == 3){
    $TBS->VarRef['vT']             = "X";
}else{
    $TBS->VarRef['vT']             = "";
}

if($idGiroEmpresa == 1){
   $TBS->VarRef["vGI"] = "X";
}else{
    $TBS->VarRef["vGI"] = "";
}
if($idGiroEmpresa == 2){
   $TBS->VarRef["vGS"] = "X";
}else{
    $TBS->VarRef["vGS"] = "";
}
if($idGiroEmpresa == 3){
   $TBS->VarRef["vGE"] = "X";
}else{
    $TBS->VarRef["vGE"] = "";
}

if($idSectorEmpresa == 1){
    $TBS->VarRef["SP"]  = "X";
}else{
    $TBS->VarRef["SP"]  = "";
}


if($idSectorEmpresa == 2){
    $TBS->VarRef["SPU"]  = "X";
}else{
    $TBS->VarRef["SPU"]  = "";
}




//$tel = "123";

// --------------------------------------------
// Merging and other operations on the template
// --------------------------------------------

// Merge data in the body of the document
$TBS->MergeBlock('a,b', $data);

// Change chart series
//$ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart
//$SeriesNameOrNum = 'Series 2';
//$NewValues = array( array('Category A','Category B','Category C','Category D'), array(3, 1.1, 4.0, 3.3) );
//$NewLegend = "Updated series 2";
//$TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);

// Delete comments
$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);
// -----------------
// Output the result
// -----------------

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
if ($save_as==='') {
    // Output the result as a downloadable file (only streaming, no data saved in the server)
    $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
    // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
    exit();
} else {
    // Output the result as a file on the server.
    $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
    // The script can continue.
    exit("File [$output_file_name] has been created.");
}
