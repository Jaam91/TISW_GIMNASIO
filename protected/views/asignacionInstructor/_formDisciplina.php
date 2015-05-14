<?php
/* @var $this AdministradorController */
/* @var $model Administrador */

$this->breadcrumbs=array(
	'Opciones'=>array('asignacionInstructor/opcion'),
	'Clientes'=>array('asignacionInstructor/lista'),
	'Disciplina',
);

?>
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'disciplina-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	)
)); ?>
	
	<h2>Seleccione la Disciplina que desea Inscribir el cliente <?php echo $nombre ?></h2>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Nombre Disciplina'); ?>
		<?php echo $form->dropDownList($model,'nombre', CHtml::listData($lista, 'nombre', 'nombre'), array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Siguiente' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<br><br>
<br><h3>Lista de Actividadas inscritas por el cliente: <?php echo $nombre?></h3>

<?php if($p_trainer == 1):?>
	<h5>- Cliente con Personal Trainer</h5>
<?php endif;	

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'unidad-medica-grid',
	'dataProvider'=>$actividad,
	'columns'=>array(
		array(
			'header'=>'Nombre Actividad',
			'name'=>'id_actividad',
			'value'=>'$data->actividad0->nombre',
			'filter'=> false,
		),
		array(
			'header'=>'Dependencia',
			'name'=>'id_dependencia',
			'value'=>'$data->actividad0->idDependencia->nombre',
			'filter'=> false,
		),
	),
)); ?>
