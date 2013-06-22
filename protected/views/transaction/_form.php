<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'transaction-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'acc_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'cat_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'pay_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5','maxlength'=>10)); ?>

	<?php echo $form->textFieldRow($model,'reconciled',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'notes',array('class'=>'span5','maxlength'=>256)); ?>

	<?php echo $form->textFieldRow($model,'create_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'create_user_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_time',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'update_user_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
