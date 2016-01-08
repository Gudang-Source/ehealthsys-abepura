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
  $template = "{summary}{pager}\n{items}";
}
?>

<?php if(isset($caraPrint)){ ?>
<?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
              'header'=>'Anamnesa',
              'type'=>'raw',
              'value'=>'"-"',
            ),
            array(
              'header'=>'Diagnosa<br/>dan ICD',
              'type'=>'raw',
              'value'=>'"-"',
            ),
            array(
              'header'=>'Therapy',
              'type'=>'raw',
              'value'=>'"-"',
            ),
            array(
              'header'=>'Tindakan',
              'type'=>'raw',
              'value'=>'"-"',
            ),
            array(
              'header'=>'Golongan<br/>Operasi',
              'type'=>'raw',
              'value'=>'"-"',
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
//            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php }else{ ?>
<div style='width:100%;overflow-x: scroll;'>
    <?php $this->widget($table,array(
	'id'=>'PPInfoKunjungan-v',
	'dataProvider'=>$data,
        'template'=>$template,
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
              'header'=>'Anamnesa',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\'icon-form-anamnesa\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailHasilAnamnesa",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeAnamnesa","onclick"=>"$(\'#dialogDetailAnamnesa\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Diagnosa<br/>dan ICD',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\'icon-form-diagicd\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailHasilDiagnosa",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeDiagnosa","onclick"=>"$(\'#dialogDetailDiagnosa\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Therapy',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-form-terapi\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailTerapi",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeTherapy","onclick"=>"$(\'#dialogDetailTherapy\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Tindakan',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-form-tindakan\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailTindakan",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframe","onclick"=>"$(\'#dialogDetailTindakan\').dialog(\'open\');"))',
            ),
            array(
              'header'=>'Golongan<br/>Operasi',
              'type'=>'raw',
              'value'=>' CHtml::link("<i class=\'icon-form-goloperasi\'></i> ", Yii::app()->controller->createUrl("/rawatJalan/daftarPasien/detailHasilOperasi",array("id"=>$data->pendaftaran_id)),array("id"=>"$data->no_pendaftaran","rel"=>"tooltip","title"=>"Klik untuk Melihat Riwayat Pemeriksaan Pasien","target"=>"iframeOperasi","onclick"=>"$(\'#dialogDetailOperasi\').dialog(\'open\');"))',
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
//            
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>
<?php } ?>
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
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframe" width="100%" id="iframe" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,'iframe');">
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
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeTherapy" width="100%" id="iframeTherapy" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,'iframeTherapy');">
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
        'resizable'=>false,
        'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeDiagnosa" width="100%" id="iframeDiagnosa" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,'iframeDiagnosa');">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>

<?php 
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailAnamnesa',
    'options'=>array(
        'title'=>'Detail Anamnesa Pemeriksaan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'resizable'=>false,
        'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeAnamnesa" width="100%" id="iframeAnamnesa" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,'iframeAnamnesa');">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>


<?php 
// Dialog untuk ubah status periksa =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailOperasi',
    'options'=>array(
        'title'=>'Detail Operasi Pemeriksaan Pasien',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'resizable'=>false,
        'scroll'=>false,
    ),
));
?>
<iframe src="" name="iframeOperasi" width="100%" id="iframeOperasi" marginheight="0" frameborder="0" onLoad="autoResizeIframe(this,'iframeOperasi');">
</iframe>
<?php
$this->endWidget();
//========= end ubah status periksa dialog =============================
?>
<script>
// untuk me-resize ukuran dalog box
    function resetIframe(obj) {
        obj.style.height = 10 + 'px';
    }
    function autoResizeIframe(obj,id){
            var frameObj = document.getElementById(id);
            resetIframe(frameObj);
            obj.style.height = (obj.contentWindow.document.body.scrollHeight) + 'px';
    }    
</script>