<?php
/* @var $this PengajuanPemotonganController */

$this->breadcrumbs=array(
	'Pengajuan Pemotongan'=>array('/pinjaman/pengajuanPemotongan'),
	'Informasi',
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'informasi-pengajuanpemotongan-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'focus' => '#adcontact-form div.form-group:first-child div input',
	'htmlOptions'=>array('class'=>'form-groups-bordered','onKeyPress'=>'return disableKeyPress(event);', //, 'onsubmit'=>'return requiredCheck(this);', 
	'enctype' => 'multipart/form-data'),
)); ?>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Informasi Pengajuan Pemotongan
			</div>
		</div>
		<div class="panel-body" style="text-align: center">
			<?php echo $this->renderPartial('subview/_pencarianInformasi', array('form'=>$form, 'pengajuanPemotongan'=>$pengajuanPemotongan)); ?>
			<?php echo $this->renderPartial('subview/_tabelInformasi', array('form'=>$form, 'pengajuanPemotongan'=>$pengajuanPemotongan)); ?>
		</div>
		<div class="panel-footer" style="text-align:center">
			<?php  echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
		</div>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $urlPrint = $this->createUrl('printInformasi'); ?>
<script type="text/javascript">
	$("#btn-cari").click(function() {
		$.fn.yiiGridView.update('pengajuanpemotongan-m-grid', {data:$("#panel-pencarian :input").serialize()});
	});
	function iPrint() {
		var url = ($("#panel-pencarian :input").serialize()); //.split('&');
		//url.shift();
		//url = url.join('&');
		window.open('<?php echo $urlPrint; ?>&' + url, "_blank");
		//window.open('<?php echo $urlPrint; ?>&' + url, "print", "width=800,height=600");
	}
</script>