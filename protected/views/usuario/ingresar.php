<?php
/* @var $this AdministradorController */
/* @var $model Administrador */

$this->breadcrumbs=array(
	'Opciones',
);
?>

<h2>Opciones</h2>
<ul class="nav nav-list">

  <li class="">
    <td> <?php echo CHtml::link('Ingresar Personal',array('usuario/crearPersonal'));?></td> 
  </li>
  <li>
    <td> <?php echo CHtml::link('Ingresar Cliente',array('usuario/crearCliente'));?></td> <br><br>
  </li>
   <li>
    <td> <?php echo CHtml::link('Gestión del Personal',array('usuario/admin', 'id'=>1));?></td> 
  </li>
  <li>
    <td> <?php echo CHtml::link('Gestión de Clientes',array('usuario/admin', 'id'=>2));?></td> <br><br>
  </li>

  <li>
    <td> <?php echo CHtml::link('Habilitar Personal',array('usuario/lista', 'id'=>1));?></td> 
  </li>
  <li>
    <td> <?php echo CHtml::link('Habilitar Cliente',array('usuario/lista', 'id'=>2));?></td> 
  </li>
</ul>