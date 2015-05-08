<?php
/* @var $this ImplementoController */
/* @var $model Implemento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'implemento-form',
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

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Dependencia'); ?>
		<?php echo $form->dropDownList($model,'id_dependencia',CHtml::listData($lista,'id_dependencia','nombre'),array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'id_dependencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo',CHtml::listData($disciplinas,'nombre','nombre'),array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'ano'); ?>
		<?php echo $form->textField($model,'ano',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'ano'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grupo_muscular'); ?>
		<?php echo $form->dropDownList($model,'grupo_muscular',CHtml::listData($grupoMuscular,'grupo_muscular','grupo_muscular'), array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'grupo_muscular'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado_funcional'); ?>
		<?php echo $form->textField($model,'estado_funcional',array('size'=>12,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'estado_funcional'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Ingresar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->