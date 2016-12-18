<?php $js = <<<'EOF'

$(".sidebar-collapse > a").click();

EOF;

Yii::app()->clientScript->registerScript('collapser', $js, CClientScript::POS_READY);

?>
<?php
/* @var $this PengajuanPemotonganController */

$this->breadcrumbs=array(
	'Penerimaan Pemotongan'=>array('/pinjaman/penerimaanPengajuan'),
	'Informasi',
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'informasi-penerimaanpemotongan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<style type="text/css">
	.input-group-addon{
		cursor: pointer;	
	}
</style>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Informasi Penerimaan Pemotongan
			</div>
		</div>
		<div class="panel-body" style="text-align: center">
			<?php echo $this->renderPartial('subview/_pencarianInformasi', array('form'=>$form, 'penerimaanPemotongan'=>$penerimaanPemotongan)); ?>
			<?php echo $this->renderPartial('subview/_tabelInformasi', array('form'=>$form, 'penerimaanPemotongan'=>$penerimaanPemotongan)); ?>
		</div>
		<!--div class="panel-footer" style="text-align:center">
			<?php  //echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
		</div-->
	</div>
</div>
<?php $this->endWidget(); ?>

<?php $urlPrint = $this->createUrl('printInformasi'); ?>
<script type="text/javascript">
	$("#btn-cari").click(function() {
		$.fn.yiiGridView.update('penerimaanpemotongan-m-grid', {data:$("#panel-pencarian :input").serialize()});
	});
	function iPrint() {
		var url = ($("#panel-pencarian :input").serialize()); //.split('&');
		//url.shift();
		//url = url.join('&');
		//window.open('<?php echo $urlPrint; ?>&' + url, "print", "width=800,height=600");
		window.open('<?php echo $urlPrint; ?>&' + url, '_blank');
	}
</script>