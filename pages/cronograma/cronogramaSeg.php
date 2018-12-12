<table id="Cronograma">
  <tr class="color-head">
    <th rowspan="2">Actividades</th>
    <th colspan="4">1</th>
    <th colspan="4">2</th>
    <th colspan="4">3</th>
    <th colspan="4">4</th>
    <th colspan="4">5</th>
    <th colspan="4">6</th>
  </tr>
  <tr class="color-head">
    <?php
      for($i = 0;$i<24;$i++){
        echo "<td id=\"semana$i\">".($i+1)."</td>";
      }
    ?>
  </tr>


</table>

<button id="agregar" onclick="return agregarActividad()" class="btn btn-info top"> Agregar Actividad</button>
<?php if($_SESSION["idTipoDocumento"] != 3){ ?>
  <button id="guardar" class="btn btn-primary top" onclick="return guardar()"> Guardar cronograma</button>
<?php } ?>
<button id="cancelar" onclick="return cancelarActividades()" class="btn btn-danger top"> Cancelar</button>
</br></br>

