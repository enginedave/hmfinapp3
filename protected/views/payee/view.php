<?php
$this->breadcrumbs=array(
	'Payees'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Payee','url'=>array('index')),
	array('label'=>'Create Payee','url'=>array('create')),
	array('label'=>'Update Payee','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Payee','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Payee','url'=>array('admin')),
);
?>

<h1>View Payee #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>
