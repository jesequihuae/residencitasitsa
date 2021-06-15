<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="utf-8"> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta name="tipo_contenido"  content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Solicitudes</title>

    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../css/metisMenu.min.css" rel="stylesheet">
    <!-- Timeline CSS -->
    <link href="../css/timeline.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../css/startmin.css" rel="stylesheet">
    <!-- Morris Charts CSS -->
    <link href="../css/morris.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../css/jquery.datetimepicker.css" type="text/css">
    <!-- DataTable CSS -->
    <link href="../css/datatable.min.css" rel="stylesheet" type="text/css">
    <!-- DataTable CSS -->
    <link href="../css/jquery.treeview.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div id="wrapper" style="margin-top:30px;"> 

    <!-- Navigation -->
    <?php include('../modules/navbar.php'); ?>
    <?php
        include '../php/connection.php';
        if($ObjectITSA->checkSession()){
            if(!$ObjectITSA->checkPermission("administracion_modulos")) {
                echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
                exit;
            }
        } else {
            echo '<script language = javascript> self.location = "javascript:history.back(-1);" </script>';
            exit;
        }
    ?>
    
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="col-md-4 col-md-offset-4">
            <div class="form-group">
                <label class="control-label col-lg-3">Tipo Usuario:</label>
                <div class="col-lg-9">
                <select class="form-control selectpicker" name="idTipoUsuario" id="idTipoUsuario">
                <?php foreach ($ObjectITSA->getTipoUsuario() as $r) { ?>
                    <option value="<?php echo $r["idTipoUsuario"]; ?>"><?php echo $r["vTipoUsuario"]; ?></option>
                <?php  } ?>
                </select>
                </div>
            </div>
        </div>
        <hr style="margin-top:10px;height:10px;width:100%;text-align:left;margin-left:0">
        <div id="treeView">
        </div>
        <button id="save" class="btn btn-primary" onClick="guardar()">Guardar</button>
     </div>   
</div>

<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>
<!-- Metis Menu Plugin JavaScript -->
<script src="../js/metisMenu.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="../js/startmin.js"></script>
<!--TREEVIEW-->
<script src="../js/jquery.treeview.js"></script>

<!-- DataTable CSS -->
<script src="../js/datatable.min.js"></script>
<!--JQUERY TREEVIEW-->
<script src="../js/datatable.min.js"></script>

<script>
    var idTipoUsuario = $("#idTipoUsuario").val();
    
    loadTreeView(idTipoUsuario);
    function loadTreeView(idTipoUsuario){
        var json = "[]";
        $.ajax({
        url:'../wssegres/getModuloSubModulo/'+idTipoUsuario,
        type:'GET',
        dataType:'JSON',
        beforeSend: function(e){

        },
        success: function(e){
            var previouesModulo = "";
            json = "[";
            for(var i = 0; i < e.length; i++){
                var modulo = e[i].vModulo;
                if(modulo != previouesModulo){
                    json += "{";
                    json += '"text":"'+e[i].vModulo+'",';
                    json += '"checked":"true",';
                        json += '"children":['
                            for(var j = 0; j < e.length; j++){
                                if(e[j].vModulo == modulo){
                                    json += '{"text":"'+e[j].vSubmodulo+'","id":"'+e[j].idSubmodulo+'","idmodulo":"'+e[j].idModulo+'"';
                                    if(e[j].idPermiso != 0){
                                        json += ',"checked":"true"';
                                    }
                                    json += "},";
                                }
                            }
                        json = json.substr(0,json.length-1);
                        json += ']';
                    json += "},";
                }
                previouesModulo = modulo;

            }
            json = json.substr(0,json.length-1);
            json += "]";
            var j = JSON.parse(json);
            var tw = new TreeView(
            j,
            {showAlwaysCheckBox:true,fold:false});
            $("#treeView").html(tw.root)
            
            ;
        },
        error: function(e){
            console.log(e);
        }
        });
    }
    function guardar(){
        var json = "[";
        $( ".item" ).each(function( index ) {
            if($( this ).attr("check-value") == 1 && $( this ).attr("data-id") != null){
                json += '{"idSubmodulo":"'+$( this ).attr("data-id")+'","idModulo":"'+$( this ).attr("data-idmodulo")+'","idTipoUsuario":"'+$("#idTipoUsuario").val()+'"},';
            }
        });
        json = json.substr(0,json.length-1);
        json += "]";
        
        console.log(json);

        $.ajax({
            url:'../wssegres/savePermissions',
            type:'POST',
            data:{"json":json},
            dataType:'JSON',
            beforeSend: function(e){

            },
            success: function(e){
                console.log(e);
            },
            error:function(e){
                console.log(e);   
            }
        });
    }
    $("#idTipoUsuario").change(function(e){
        loadTreeView($(this).val());
    });
// var treeObject = [
// 	{
// 		text:"Parent 1", // Required
// 		checked:true, // Optional
// 		id:15,otherDatas:"Other Datas", // Other Datas Optional
// 		children:[ // Required
// 			{ text:"Child 1" /* Required */, checked:true	},
// 			{ text:"Child 2" /* Required */	}
// 		]
// 	},
// 	{
// 		text:"Parent 2", // Required
// 		children:[
// 			{
// 				text:"Parent 3",
// 				children:[
// 					{text:"Child 3",checked:true},
// 					{text:"Child 4"}
// 				]
// 			}
// 		]
// 	}
// ]
// var treeObject = [{text:'Proceso Alumno',checked:true},{text:'Control',checked:true},{text:'Solicitud',checked:true},{text:'Administración',checked:true},{text:'TEST',checked:true}];
// var tw = new TreeView(treeObject,{showAlwaysCheckBox:true,fold:false});
// $("#treeView").html(tw.root);
</script>
</body>
</html>
