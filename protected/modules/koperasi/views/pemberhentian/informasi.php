<?php
/* @var $this PemberhentianController */

$this->breadcrumbs=array(
	'Pemberhentian'=>array('/keanggotaan/pemberhentian'),
	'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('anggota-m-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Informasi Pemberhentian Anggota
			</div>
		</div>
		<div class="panel-body">
			<?php echo CHtml::link('Pencarian <i class="entypo-down-open"></i>','#',array('class'=>'search-button btn')); ?>
			<div class="search-form" style="display:none">
					<?php $this->renderPartial('subview/_search',array(
					'model'=>$anggota,
				)); ?>
			</div><!-- search-form -->
		</div>
		<div class="panel-body">
		<?php
					$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->search(),
					'filter'=>$anggota,
					'itemsCssClass' => 'table-bordered datatable dataTable',
					'columns'=>array(
					array(
							'header'=>'Tgl Berhenti',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					array(
							'name'=>'tglkeanggotaaan',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'filter'=>false,
						),
					array(
							'name'=>'lamamenjadi_anggota',
							'filter'=>false,
						),
					array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),
					array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'type'=>'raw',
							'value'=>'$data->NamaGolongan',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
						),
						'nokeanggotaan',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						),
						array(
							'header'=>'Jml Simpanan',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmlsimpanan_berhenti)',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Jml Tunggakan',
							'value'=>'MyFormatter::formatNumberForPrint($data->jmltunggakan_berhenti)',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Kas Masuk',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\"entypo-window\"></i>", Yii::app()->controller->createUrl("kasmasuk", array("id"=>$data->keanggotaan_id)), array("target"=>"_blank"))',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
						array(
							'header'=>'Kas Keluar',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\"entypo-window\"></i>", Yii::app()->controller->createUrl("kaskeluar", array("id"=>$data->keanggotaan_id)), array("target"=>"_blank"))',
							'htmlOptions'=>array('style'=>'text-align:right'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a'),
						),
					),
				));
		?>
		</div>
		<div class="panel-footer" style="text-align:center">
			<?php  echo Chtml::link('<i class="entypo-print"></i> Print',"#", array('onclick'=>'iPrint()','class' => 'btn btn-success')); ?>
		</div>
	</div>
</div>
<?php
	$urlPrint = $this->createUrl('printInformasi');
?>
<?php

$jsx = <<< JSCRIPT
function iPrint()
{
	 var url = ($(".search-form form , #anggota-m-grid :input").serialize()).split('&');
  	 url.shift();
	 url = url.join('&');
	 window.open('$urlPrint&' + url, "_blank");
	 //window.open('$urlPrint&' + url, "print", "width=800,height=600, scrollbars=yes");
    //window.open("${urlPrint}&"+$('.search-form form').serialize(),"",'location=_new, width=1100px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);
?>
