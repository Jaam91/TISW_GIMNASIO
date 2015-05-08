<?php
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actividad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos</p>

	<?php echo $form->errorSummary($model); ?>

	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/actividad-instructor.js', CClientScript::POS_END);?>

	<?php
    Yii::app()->getClientScript()->registerScript('nuevo_campo',CClientScript::POS_END);
 	?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div id="disciplina" class="row">
		<?php echo $form->labelEx($model,'id_disciplina'); ?>
		<?php echo $form->dropDownList($model,'id_disciplina', CHtml::listData($lista, 'id_disciplina', 'nombre'), array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'id_disciplina'); ?>
	</div>

	<div id="instructor" class="row">
		<?php echo $form->labelEx($model,'Instructor'); ?>
		<?php echo $form->dropDownList($model,'rut_instructor', CHtml::listData($lista_i, 'rut_usuario', 'primer_nombre'), array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'rut_instructor'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'Dependencia'); ?>
		<?php echo $form->dropDownList($model,'id_dependencia', CHtml::listData($lista_d, 'id_dependencia', 'nombre'), array('empty'=>'Seleccione')); ?>
		<?php echo $form->error($model,'id_dependencia'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Ingresar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->