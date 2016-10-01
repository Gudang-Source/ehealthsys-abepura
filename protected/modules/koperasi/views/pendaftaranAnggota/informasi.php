<?php
/* @var $this PendaftaranAnggotaController */

$this->breadcrumbs=array(
	'Pendaftaran Anggota'=>array('/keanggotaan/pendaftaranAnggota'),
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
				Informasi Anggota
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
							'header'=>'Tgl Anggota',
							'type'=>'raw',
							'value'=>'date("d/m/Y H:i", strtotime($data->tglkeanggotaaan))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						), 
						'nokeanggotaan',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang',
						),	
						array(
							'header'=>'Umur',
							'type'=>'raw',
							'value'=>'Params::getUmur($data->tgl_lahirpegawai)." Thn"',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Jenis Kelamin',
							'name'=>'jeniskelamin',
							'value'=>'$data->jeniskelamin',
							'filter'=>CHtml::activeDropDownList($anggota, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->alamat_pegawai',
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
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						/*array(
							'header'=>'Jabatan',
							'name'=>'jabatan_id',
							'value'=>'$data->jabatan_nama',
							'filter'=>CHtml::activeDropDownList($anggota, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll(),'jabatan_id','jabatan_nama'), array('empty'=>'-- Pilih --')),
						),*/
						array(
							'header'=>'Tgl Berhenti Anggota',
							'type'=>'raw',
							'value'=>'empty($data->tglberhentikeanggotaan)?"-":date("d/m/Y H:i", strtotime($data->tglberhentikeanggotaan))',
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						), 
						array(
							'header'=>'Ubah',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'entypo-pencil\'></i>", Yii::app()->controller->createUrl("update", array("id" => $data->keanggotaan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Print Anggota',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'entypo-print\'></i>", Yii::app()->controller->createUrl("printAnggota", array("id"=>$data->keanggotaan_id)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk Mencetak Data Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),						
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Berhenti',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'entypo-cancel\'></i>", Yii::app()->createUrl("keanggotaan/pemberhentian/index", array("NoAnggota"=>$data->nokeanggotaan)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk Memberhentikan Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),						
							'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
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
	$urlPrint = $this->createUrl('print'); 
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