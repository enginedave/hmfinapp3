<?php
$this->breadcrumbs=array(
	'Payees'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Payee','url'=>array('index')),
	array('label'=>'Manage Payee','url'=>array('admin')),
);
?>

<h1>Create Payee</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>