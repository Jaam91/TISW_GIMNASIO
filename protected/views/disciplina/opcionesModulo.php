<?php

$this->breadcrumbs=array(
	'Opciones',
);
?>

<h3>Opciones:</h3>
<ul class="nav nav-list">

  <li class="">
    <td> <?php echo CHtml::link('Ingresar Disciplina',array('disciplina/crearDisciplina'));?></td> 
  </li>
  <li>
    <td> <?php echo CHtml::link('Gestión de Disciplinas',array('disciplina/admin'));?></td> <br>
  </li>
    <li>
    <td> <?php echo CHtml::link('Habilitar Disciplina',array('disciplina/lista'));?></td> <br><br>
  </li>
</ul>