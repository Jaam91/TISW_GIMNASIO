<?php

if($tipo == 1):   // Personal
		$this->breadcrumbs=array(
			'Ingresar Personal'=>array('crearPersonal'),
			"Registro",
		);
		$this->menu=array(
			array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
			array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
			array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
			); ?>
		<h1>¡Usuario ingresado con éxito!</h1> <?php

		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'rut_usuario',
				'primer_nombre',
				'segundo_nombre',
				'primer_apellido',
				'segundo_apellido',
				'rol',
			),
		)); ?>
			<br><br>
				<ul class="nav nav-list">
		  			<li class="">
		  	  			<td> <?php echo CHtml::link('Volver',array('crearPersonal'));?></td>
		  			</li>
			</ul>
	<?php endif; 

if($tipo == 2):   // Cliente
		$this->breadcrumbs=array(
			'Ingresar Cliente'=>array('crearCliente'),
			"Registro",
		);
		$this->menu=array(
			array('label'=>'Ingresar Cliente', 'url'=>array('crearCliente')),
			array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
			array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
			); ?>
		<h1>¡Cliente ingresado con éxito!</h1> <?php 

		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'rut_usuario',
				'primer_nombre',
				'segundo_nombre',
				'primer_apellido',
				'segundo_apellido',
				'rol',
			),
			)); ?>

		    <br><br>
				<ul class="nav nav-list">
		  			<li class="">
		  	  			<td> <?php echo CHtml::link('Volver',array('crearCliente'));?></td>
		  			</li>
				</ul>
	<?php endif; ?>