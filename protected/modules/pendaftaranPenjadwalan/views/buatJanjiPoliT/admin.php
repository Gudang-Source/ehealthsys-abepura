<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppbuat-janji-poli-t-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>
<div class="white-container">
    <legend class="rim2">Informasi Pasien <b>Janji Poliklinik</b></legend>
    <div class="block-tabel table-responsive">
        <h6>Tabel Pasien <b>Janji Poliklinik</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'ppbuat-janji-poli-t-grid',
            'dataProvider'=>$model->search(),
            'template'=>"{summary}\n{items}\n{pager}",  
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                       'name'=>'tglbuatjanji',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->tglbuatjanji)',
                    ),
                    array(
                       'header'=>'No. Antrian',
                       'name'=>'no_antrianjanji',
                       'type'=>'raw',
                       'value'=>'isset($data->no_antrianjanji) ? $data->no_antrianjanji : ""',
                    ),
                    array(
                                    'name'=>'pegawai_id',
                                    'value'=>'(isset($data->pegawai->nama_pegawai) ? $data->pegawai->nama_pegawai : "-")',
                    ),
                    array(
                                    'name'=>'ruangan_id',
                                    'value'=>'(isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-")',
                    ),

                     array(
                       'header'=>'No. Rekam <br/> Medik',
                       'name'=>'no_rekam_medik',
                       'type'=>'raw',
                       'value'=>'(isset($data->pasien_id) ? $data->pasien->no_rekam_medik : "-") ',
                       'htmlOptions'=>array('style'=>'text-align: left')
                    ),
                    array(
                            'name'=>'Nama Pasien',
                       'type'=>'raw',
                       'value'=>'$data->getNamaAlias($data->pasien->nama_pasien,$data->pasien->nama_bin)',
                    ),
                    array(
                       'name'=>'tgljadwal',
                       'type'=>'raw',
                       'value'=>'MyFormatter::formatDateTimeForUser($data->tgljadwal)',
                    ),
                    'harijadwal',
                    array(
                            'header'=>'Daftar Ke <br/> Poliklinik',
                            'type'=>'raw',
                            'value'=>'(isset($data->pasien_id) ? CHtml::link("<i class=icon-form-poliklinik></i>", "javascript:daftarKeRJ(\'$data->pasien_id\',\'$data->buatjanjipoli_id\');",array("id"=>"$data->pasien_id","rel"=>"tooltip","title"=>"Klik Untuk Mendaftarkan ke Rawat Jalan")): "-") ',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
                    ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'type'=>'raw', 
                            'value'=>'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("infoPasienJanjiPoli/view",array("id"=>$data->buatjanjipoli_id,"frame"=>1)),
                                                    array("class"=>"", 
                                                              "target"=>"iframeDetail",
                                                              "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                              "rel"=>"tooltip",
                                                              "title"=>"Klik untuk lihat detail ",
                                                    ))',
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
    //		array(
    //			'header'=>Yii::t('zii','View'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //			'template'=>'{view}',
    //			'buttons'=>array(
    //				'view' => array (
    //					'options'=>array('rel'=>'tooltip','title'=>'Lihat pasien janji poli')
    //				)
    //			)
    //		),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                    'update' => array (
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah pasien janji poli')
                                                              // 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    ),
                             ),
                    ),
                    array(
                'header'=>'Batal',
                'type'=>'raw',
                'value'=>'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->buatjanjipoli_id)",array("id"=>"$data->buatjanjipoli_id","rel"=>"tooltip","title"=>"Batalkan Janji Poliklinik Pasien"))',
                'htmlOptions'=>array('style'=>'text-align: left; width:40px; max-width:80px;'),
            ),
    //		array(
    //			'header'=>Yii::t('zii','Batal'),
    //			'class'=>'bootstrap.widgets.BootButtonColumn',
    //			'template'=>'{delete}',
    //			'buttons'=>array(
    //				'delete'=> array(
    //					'options'=>array('rel'=>'tooltip','title'=>'Hapus pasien janji poli')
    //									// 'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_DELETE))',
    //				),
    //			)
    //		),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="search-form box" style="display:block">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,'format'=>$format
        )); ?>
    </fieldset>
</div>
<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $urlPendaftaranRJ=Yii::app()->createAbsoluteUrl('pendaftaranPenjadwalan/PendaftaranRawatJalan');
	$urlDelete=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppbuat-janji-poli-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function daftarKeRJ(pasien_id,buatjanjipoli_id,ruangan_id,pegawai_id)
{
    $('#buatjanjipoli_id').val(buatjanjipoli_id);
    $('#pasien_id').val(pasien_id);
    $('#ruangan_id').val(ruangan_id);
    $('#pegawai_id').val(pegawai_id);
    $('#form_hidden').submit();
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'form_hidden',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'action'=>$urlPendaftaranRJ,
       // 'htmlOptions'=>array('target'=>'_new'), dicomment karena RND-7612
)); ?>
    <?php echo CHtml::hiddenField('buatjanjipoli_id','',array('readonly'=>true));?>
<?php $this->endWidget(); ?>
<?php 
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetail',
    'options'=>array(
        'title'=>'Detail Buat Janji Poliklinik',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeDetail" width="100%" height="300" >
</iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>
<script type="text/javascript">
//di comment karena RND-7612	
//setInterval(   // fungsi untuk menjalankan suatu fungsi berdasarkan waktu
//    function(){
//        $.fn.yiiGridView.update('ppbuat-janji-poli-t-grid', {   // fungsi untuk me-update data pada Cgridview yang memiliki id=category_grid
//            data: $('#ppbuat-janji-poli-t-search').serialize()
//        });
//        return false;
//    }, 
// 5000  // fungsi di eksekusi setiap 5 detik sekali
//);

function deleteRecord(id){
        var id = id;
        var url = '<?php echo $urlDelete."/delete"; ?>';
        myConfirm("Anda yakin akan membatalkan janji poliklinik ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
								myAlert(data.pesan);
                                $.fn.yiiGridView.update('ppbuat-janji-poli-t-grid');
                            }else{
                                myAlert('Data janji poli tidak bisa dibatalkan karena pasien sudah didaftarkan!')
                            }
                },"json");
           }
       });
    }
</script>
