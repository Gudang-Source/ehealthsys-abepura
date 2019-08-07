<div class = "white-container">
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



<legend class="rim2">Informasi Buku Anggota</legend>
<div class="col-md-12">					
            <div class="block-tabel">
                <h6>Informasi <b>Buku Anggota</b></h6>
		<?php
					 $this->widget('ext.bootstrap.widgets.BootGridView',array(
					'id'=>'anggota-m-grid',
					'dataProvider'=>$anggota->searchInformasi(),
					//'filter'=>$anggota,
                                       // 'template'=>"{summary}\n{items}\n{pager}",
					'itemsCssClass' => 'table table-striped table-condensed',
					'columns'=>array(
					array(
							'header'=>'Tgl Anggota',
							'type'=>'raw',
                                                        'name' => 'tglkeanggotaaan',
							'value'=>'MyFormatter::formatDateTimeForUser(date("d/m/Y H:i", strtotime($data->tglkeanggotaaan)))',
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						), 
						'nokeanggotaan',
						array(
							'header'=>'Nama Anggota',
							'type'=>'raw',
							'name'=>'nama_pegawai',
							'value'=>'$data->namaLengkap',
						),	
						/*array(
							'header'=>'Umur',
							'type'=>'raw',
                                                        'name' => 'tgl_lahirpegawai',
							'value'=>'',
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),*/
                                                array(
                                                    'header' => 'Golongan',
                                                    'name' => 'golonganpegawai_nama'
                                                ),
                                                array(
                                                    'header' => 'Jabatan',
                                                    'name' => 'jabatan_nama'
                                                ),
                                                
						array(
							'header'=>'Jenis Kelamin/ <br/> Umur',
							'name'=>'jeniskelamin',
                                                        'type' => 'raw',
							'value'=>'$data->jeniskelamin."/ <br/>".Params::getUmur($data->tgl_lahirpegawai)." Thn"',
							'filter'=>CHtml::activeDropDownList($anggota, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
						),
						/*array(
							'header'=>'Alamat',
							'name'=>'alamat_pegawai',
							'value'=>'$data->alamat_pegawai',
						),*/
					/*	array(
							'header'=>'Unit',
							'name'=>'unit_id',
							'value'=>'$data->namaunit',
							'filter'=>CHtml::activeDropDownList($anggota, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
						),*/
						array(
							'header'=>'Golongan',
							'name'=>'golonganpegawai_id',
							'type'=>'raw',
							'value'=>'$data->NamaGolongan',
							'filter'=>CHtml::activeDropDownList($anggota, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
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
                                                        'name' => 'tglberhentikeanggotaan',
							'value'=>'empty($data->tglberhentikeanggotaan)?"-":date("d/m/Y H:i", strtotime($data->tglberhentikeanggotaan))',
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						), 
						array(
							'header'=>'Ubah',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("update", array("id" => $data->keanggotaan_id)),array("rel"=>"tooltip","title"=>"Klik untuk Mengubah Data Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Print Anggota',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-print icon-white\'></i>", Yii::app()->controller->createUrl("printAnggota", array("id"=>$data->keanggotaan_id)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk Mencetak Data Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),						
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
						array(
							'header'=>'Berhenti',
							'type'=>'raw',
							'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i>", Yii::app()->createUrl("koperasi/pemberhentian/index", array("NoAnggota"=>$data->nokeanggotaan)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk Memberhentikan Anggota"))',
							'htmlOptions'=>array('style'=>'text-align:center'),						
							//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
						),
					),
				)); 
		?>
		</div>
		<div class="panel-footer" style="text-align:center">
			<?php  //echo Chtml::link('<i class="entypo-print"></i> Print',"#", array('onclick'=>'iPrint()','class' => 'btn btn-success')); ?>
		</div>	
</div>

  <fieldset class="box search-form">
      <legend class="rim"><i class="entypo-search"></i> Pencarian</legend> 
        <?php $this->renderPartial('subview/_search',array(
					'model'=>$anggota,
				)); ?>
  </fieldset>
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
</div>