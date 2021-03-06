<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'email',array('class'=>'span5','maxlength'=>100)); ?>

	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>150)); ?>
	
	<?php echo $form->passwordFieldRow($model,'password_repeat',array('class'=>'span5','maxlength'=>150)); ?>

	<?php 
		//dont display the role selection for a create new user only on update
		if (!$model->isNewRecord) 
		{
			echo $form->dropDownListRow($model, 'role', $model->getTypeOptions(), array('class'=>'span5','maxlength'=>100));
		}
	?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
