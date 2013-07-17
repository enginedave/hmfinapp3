<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'transaction-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->labelEx($model,'date'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
					'model'=>$model,
					'attribute'=>'date',
					// additional javascript options for the date picker plugin
					'options' => array(
						'showAnim' => 'clip',
						'dateFormat'=>'dd-mm-yy',
						'changeMonth'=>'true',
						'changeYear'=>'true',
						'defaultDate'=>null,
					),
					'htmlOptions' => array(
						//'style' => 'width: 130px;',
						'class'=>'span5'
					),
				));   ?>
	
	<?php echo $form->dropDownListRow($model, 'acc_id', CHtml::listData($this->userAccounts, 'id', 'name'), array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model, 'cat_id', CHtml::listData($this->userCategorys, 'id', 'name'), array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model, 'pay_id', CHtml::listData($this->userPayees, 'id', 'name'), array('class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'amount',array('class'=>'span5','maxlength'=>10)); ?>
	
	<?php echo $form->checkBoxRow($model, 'reconciled'); ?>
	
	<?php echo $form->textFieldRow($model,'notes',array('class'=>'span5','maxlength'=>256)); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>
