<html>
<head>
<style>
 body {font-family: sans-serif;
 font-size: 10pt;
 }
 p { margin: 0pt;
 }
 td { vertical-align: top; }
 .items td {
 border-left: 0.1mm solid #000000;
 border-right: 0.1mm solid #000000;
 }
 table thead td { background-color: #EEEEEE;
 text-align: center;
 border: 0.1mm solid #000000;
 }
 .items td.blanktotal {
 background-color: #FFFFFF;
 border: 0mm none #000000;
 border-top: 0.1mm solid #000000;
 }
 .items td.totals {
 text-align: right;
 border: 0.1mm solid #000000;
 }
</style>
</head>
<body>
 

 <htmlpageheader name="myheader">
 <table width="100%"><tr>
 <td width="50%" style="color:#0000BB;"><span style="font-weight: bold; font-size: 25pt;">Sistema Gimnasio Hipertrofia</span><br
                              />Informe de Demanda Mensual<br/></td>
                              

 </tr></table>
 </htmlpageheader>
 
<htmlpagefooter name="myfooter">
 <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
 Página {PAGENO} de {nb}
 </div>
 </htmlpagefooter>
 
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
 <sethtmlpagefooter name="myfooter" value="on" />
 

<div style="text-align: right"><b>Fecha: </b><?php echo date("d/m/Y"); ?> </div>
<br><br>
<div style="text-align: left; color:#0000BB;"><b>Informe correspondiente a la demanda de las actividades del gimnasio durante el mes de x.



                        

<br>
 
  <div style="text-align: left; color:#0000BB;"></div>
  
 
  <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="5">

  <thead>
    <tr>
       <td width="20%">Nombre Actividad</td>
       <td width="20%">Tipo Disciplina</td>
       <td width="20%">Dependencia</td>
       <td width="20%">Nombre Instructor</td>
       <td width="20%">Cantidad Clientes</td>
    </tr>

  </thead>
  <tbody>-->
     <!-- ITEMS -->
     
   <?php foreach($model as $row): ?>
   <tr>
     <td align="center">
     <?php echo $row->nombre; ?>
     </td>
      <td align="center">
     <?php echo $row->id_disciplina; ?>
     </td>
     <td align="center">
     <?php echo $row->id_dependencia; ?>
     </td> 
     <td align="center">
     <?php echo $row->rut_instructor; ?>
     </td> 
     <td align="center">
     <?php echo $row->cantidad_clientes; ?>
     </td> 
   </tr>
   <?php endforeach; ?>-->
    <!-- FIN ITEMS -->
    
     <tr>
     <td class="blanktotal" colspan="8" rowspan="8"></td>
     </tr>
   </tbody>
 </table>
<!--
       <br><br><br>
    <div style="text-align: left; color:#0000BB;"><b>4) Cantidad de Camas Disponibles en la sala: <?php //echo "$camas" ?></b></div><br>
    <div style="text-align: left; color:#0000BB;"><b>5) Cantidad de Camas Ocupadas en la sala: <?php //echo "$nocamas" ?></b></div><br>-->
</body>
</html>