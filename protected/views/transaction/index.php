<?php
$this->breadcrumbs=array(
	'Transactions',
);

$this->menu=array(
	array('label'=>'Create Transaction','url'=>array('create')),
	array('label'=>'Manage Transaction','url'=>array('admin')),
);
?>

<h1>Transactions</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'transaction-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->dropDownListRow($model, 'acc_id', CHtml::listData($this->userAccounts, 'id', 'name'), array('class'=>'span5')); ?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'List Transactions',
		)); ?>
	</div>
	
<?php $this->endWidget(); ?>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
