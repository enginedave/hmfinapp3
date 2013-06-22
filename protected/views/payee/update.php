<?php
$this->breadcrumbs=array(
	'Payees'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Payee','url'=>array('index')),
	array('label'=>'Create Payee','url'=>array('create')),
	array('label'=>'View Payee','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Payee','url'=>array('admin')),
);
?>

<h1>Update Payee <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>