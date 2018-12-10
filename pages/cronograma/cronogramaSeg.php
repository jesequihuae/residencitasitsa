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
<button id="agregar" class="btn btn-info top"> Agregar Actividad</button>
<button id="guardar" class="btn btn-primary top" onclick="return guardar()"> Guardar cronograma</button>
<button id="cancelar" class="btn btn-danger top" onclick="cancelar()"> Cancelar</button>
