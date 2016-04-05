<?php
  $table = 'ext.bootstrap.widgets.BootGridView';
if (isset($caraPrint)){
  $data = $model->searchPrint();
  $template = '{items}';
  if ($caraPrint=='EXCEL') {
      $table = 'ext.bootstrap.widgets.BootExcelGridView';
  }
} else{
  $data = $model->searchTableLaporan();
  $template = "{summary}{items}{pager}";
}
?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
<div style='width:100%;overflow-x: scroll;'>
<?php } ?>
<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
              'header'=>'Anamnesa',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien"))',
            ),
            array(
              'header'=>'Diagnosa<br/>dan ICD',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailHasilDiagnosa",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeDiagnosa","onclick"=>"$(\'#dialogDetailDiagnosa\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Therapy',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailTerapi",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeTherapy","onclick"=>"$(\'#dialogDetailTherapy\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Tindakan',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailTindakan",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframe","onclick"=>"$(\'#dialogDetailTindakan\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Golongan<br/>Operasi',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-list-alt\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/anamnesa",array("pendaftaran_id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien"))',
            ),
            array(
              'header'=>'Nama Pasien / Alias',
              'type'=>'raw',
              'value'=>'$data->NamaNamaBIN',
            ),
            
            array(
              'header'=>'No. Rekam Medik',
              'type'=>'raw',
              'value'=>'$data->no_rekam_medik',
            ),
            
            array(
              'header'=>'No. Pendaftaran',
              'type'=>'raw',
              'value'=>'$data->no_pendaftaran',
            ),
            array(
              'header'=>'Tanggal Masuk',
              'type'=>'raw',
              'value'=>'$data->tgladmisi',
            ),
            array(
              'header'=>'Tanggal Keluar',
              'type'=>'raw',
              'value'=>'$data->tglpulang',
            ),
//            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php if(isset($caraPrint)){ ?>

<?php }else{ ?>
</div>
<?php } ?>
<br/>

<?php 
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailTindakan',
    'options'=>array(
        'title'=>'Detail Tindakan Pemeriksaan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>600,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframe" width="100%" height="100%">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>

<?php 
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailTherapy',
    'options'=>array(
        'title'=>'Detail Therapy Pemeriksaan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>600,
        'minHeight'=>500,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeTherapy" width="100%" height="100%">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>

<?php 
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailDiagnosa',
    'options'=>array(
        'title'=>'Detail Diagnosa Pemeriksaan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>500,
        'resizable'=>false,
        'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDiagnosa" width="100%" height="500px">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>