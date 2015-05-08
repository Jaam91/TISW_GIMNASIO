<?php

$this->breadcrumbs=array(
	'Opciones',
);
?>

<h2>Opciones</h2>
<ul class="nav nav-list">

  <li class="">
    <td> <?php echo CHtml::link('Ingresar Asignación',array('asignacionInstructor/lista'));?></td> 
  </li>
  <li>
    <td> <?php echo CHtml::link('Gestión de Asignaciones',array('asignacionInstructor/admin'));?></td> <br><br>
  </li>
</ul>