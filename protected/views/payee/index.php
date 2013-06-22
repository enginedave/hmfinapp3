<?php
$this->breadcrumbs=array(
	'Payees',
);

$this->menu=array(
	array('label'=>'Create Payee','url'=>array('create')),
	array('label'=>'Manage Payee','url'=>array('admin')),
);
?>

<h1>Payees</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
