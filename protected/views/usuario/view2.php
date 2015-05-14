<?php 
if($tipo == 2):   // Cliente
		$this->breadcrumbs=array(
			'Gestionar'=>array('admin', 'id'=>2),
			"Registro",
		);
		$this->menu=array(
			array('label'=>'Ingresar Cliente', 'url'=>array('crearCliente')),
			array('label'=>'Gestión de Clientes', 'url'=>array('admin', 'id'=>2)),
			array('label'=>'Habilitar Cliente', 'url'=>array('lista', 'id'=>2)),
			); ?>
		<h1>¡Cliente modificado con éxito!</h1> <?php 

		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'rut_usuario',
				'primer_nombre',
				'segundo_nombre',
				'primer_apellido',
				'segundo_apellido',
				'rol',
				array('name'=>'peso','value'=>$model->cliente->peso),
				array('name'=>'altura','value'=>$model->cliente->altura),
				array('name'=>'telefono_emergencia','value'=>$model->cliente->telefono_emergencia),
				array('name'=>'enfermedades_previas','value'=>$model->cliente->enfermedades_previas),
			),
			)); ?>

		    <br><br>
				<ul class="nav nav-list">
		  			<li class="">
		  	  			<td> <?php echo CHtml::link('Volver',array('admin', 'id'=>2));?></td>
		  			</li>
				</ul>
	<?php endif; ?>

<?php

if($tipo == 3):   // Administrador - Personal
		$this->breadcrumbs=array(
			'Gestionar'=>array('admin', 'id'=>1),
			"Registro",
		);
		$this->menu=array(
			array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
			array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
			array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
			); ?>
		<h1>¡Usuario modificado con éxito!</h1> <?php

		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'rut_usuario',
				'primer_nombre',
				'segundo_nombre',
				'primer_apellido',
				'segundo_apellido',
				'rol',
				array('name'=>'profesion','value'=>$model->administrador->profesion),
				array('name'=>'fecha_ingreso','value'=>$model->administrador->fecha_ingreso),
				array('name'=>'curriculum_vitae','value'=>$model->administrador->curriculum_vitae),
			),
		)); ?>
			<br><br>
				<ul class="nav nav-list">
		  			<li class="">
		  	  			<td> <?php echo CHtml::link('Volver',array('admin', 'id'=>1));?></td>
		  			</li>
			</ul>
	<?php endif; 

if($tipo == 4):   // Instructor - Personal
		$this->breadcrumbs=array(
			'Gestionar'=>array('admin', 'id'=>1),
			"Registro",
		);
		$this->menu=array(
			array('label'=>'Ingresar Personal', 'url'=>array('crearPersonal')),
			array('label'=>'Gestión del Personal', 'url'=>array('admin', 'id'=>1)),
			array('label'=>'Habilitar Personal', 'url'=>array('lista', 'id'=>1)),
			); ?>
		<h1>¡Usuario modificado con éxito!</h1> <?php

		$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'rut_usuario',
				'primer_nombre',
				'segundo_nombre',
				'primer_apellido',
				'segundo_apellido',
				array('name'=>'profesion','value'=>$model->instructor->profesion),
				array('name'=>'fecha_ingreso','value'=>$model->instructor->fecha_ingreso),
				array('name'=>'curriculum_vitae','value'=>$model->instructor->curriculum_vitae),
				'rol',
				array('name'=>'tipo','value'=>$model->instructor->tipo),
				array('name'=>'horario','value'=>$model->instructor->horario),
			),
		)); ?>
			<br><br>
				<ul class="nav nav-list">
		  			<li class="">
		  	  			<td> <?php echo CHtml::link('Volver',array('admin', 'id'=>1));?></td>
		  			</li>
			</ul>
	<?php endif; 