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
