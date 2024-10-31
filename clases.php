<?php
session_start();
require_once("../../conexion.php");
require_once("../../libreria_menu.php");
require_once("../../paginacion.inc.php");
$db->debug=true;
$sql=$db->Prepare(" SELECT  * 
                    FROM    profesores
                    WHERE   estado='A'
                    ");
$rs=$db->GetAll($sql);
echo"<html> 
       <head>
         <link rel='stylesheet' href='../../css/estilos.css' type='text/css'>
         <script type='text/javascript' src='../../ajax.js'></script>
         <script type='text/javascript' src='js/buscar_clases.js'></script>
         <script type='text/javascript' src='js/buscar_clases1.js'></script>
         
       </head>
       <body>
       <p> &nbsp;</p>";


       echo"
<!-------INICIO BUSCADOR ------------>
    <center>
    <h1>LISTA DE CLASES</h1>
    <b><a href='clase_nuevo.php'>Nueva Clase>>></a></b>
        <form action='#'' method='post' name='formu'>
            <table border='1' class='listado'>
                <tr>
                    <th>
                        <b>Nombres</b><br />
                        <input type='text' name='nombres' value='' size='10' onKeyUp='buscar_clases()'>
                    </th>
                    <th>
                        <b>Paterno</b><br />
                        <input type='text' name='ap' value='' size='10' onKeyUp='buscar_clases()'>
                    </th>
                    <th>
                        <b>Materno</b><br />
                        <input type='text' name='am' value='' size='10' onKeyUp='buscar_clases()'>
                    </th>
                    <th>
                        <b>Celular</b><br />
                        <input type='text' name='telef_cel' value='' size='10' onKeyUp='buscar_clases()'>
                    </th>
                    <th>
                        <b>Materia</b><br />
                        <input type='text' name='nombre' value='' size='10' onKeyUp='buscar_clases()'>
                    </th>
                </tr>
            </table>
        </form>
    </center>
<!--FIN BUSCADOR --------------->";
/*echo"
<!-------INICIO BUSCADOR ------------>
    <center>
        <form action='#'' method='post' name='formu2'>
            <table border='1' class='listado'>
                <tr>
                    <th>
                        <b>Grupo</b><br />
                        <select onchange='buscar_opciones1()' name='grupo1'>
                        <option value=''>--Seleccione--</option>";
                        foreach($rs as $k=>$fila){
                          echo"<option value='".$fila['grupo']."'>".$fila['grupo']."</option>";
                        }
                        echo"</select>
                    </th>
                    <th>
                        <b>Opcion</b><br />
                        <input type='text' name='opcion1' value='' size='10' onKeyUp='buscar_clases1()'>
                    </th>
                </tr>
            </table>
        </form>
    </center>
<!--FIN BUSCADOR --------------->";*/
echo"<div id='clases1'>";
contarRegistros($db,"clases");

paginacion("clases.php?");   
           $sql3 = $db->Prepare(" SELECT     p.*,cl.*
                                  FROM       profesores p, clases cl
                                  WHERE      cl.id_profesor=p.id_profesor
                                  AND        p.estado <> 'X' 
                                  AND        cl.estado <> 'X'               
                                  ORDER BY   cl.id_clase ASC
                                  LIMIT      ? OFFSET ? 
                              ");
$rs = $db->GetAll($sql3,array($nElem,$regIni));
if ($rs) {
  echo"<center>
  
        <table class='listado'>
          <tr>                                   
            <th>N°</th><th>NOMBRES</th><th>PATERNO</th><th>MATERNO</th><th>CELULAR</th><th>MATERIA</th>
            <th><img src='../../imagenes/modificar.gif'></th><th><img src='../../imagenes/borrar.jpeg'></th>
          </tr>";
          $b=0;
          $total=$pag-1;
          $a=$nElem*$total;
          $b=$b+1+$a;
      foreach ($rs as $k => $fila) {                                       
          echo"<tr>
                  <td align='center'>".$b."</td>
                  <td>".$fila['nombres']."</td>                        
                  <td>".$fila['ap']."</td>
                  <td>".$fila['am']."</td>
                  <td>".$fila['telef_cel']."</td>
                  <td>".$fila['nombre']."</td>
                  <td align='center'>
                    <form name='formModif".$fila["id_clase"]."' method='post' action='clase_modificar.php'>
                      <input type='hidden' name='id_clase' value='".$fila['id_clase']."'>
                      <input type='hidden' name='id_profesor' value='".$fila['id_profesor']."'>

                      <a href='javascript:document.formModif".$fila['id_clase'].".submit();' title='Modificar Clase Sistema'>
                        Modificar>>
                      </a>
                    </form>
                  </td>
                  <td align='center'>  
                    <form name='formElimi".$fila["id_clase"]."' method='post' action='clase_eliminar.php'>
                      <input type='hidden' name='id_clase' value='".$fila["id_clase"]."'>
                      <a href='javascript:document.formElimi".$fila['id_clase'].".submit();' title='Eliminar Clase del Sistema' onclick='javascript:return(confirm(\"Desea realmente Eliminar la clase ".$fila["nombre"]." ?\"))'; location.href='clase_eliminar.php''> 
                        Eliminar>>
                      </a>
                    </form>                        
                  </td>
               </tr>";
               $b=$b+1;
      }
       echo"</table>
    </center>";
}
mostrar_paginacion();
echo"</div>";
echo "</body>
</html> ";

?>