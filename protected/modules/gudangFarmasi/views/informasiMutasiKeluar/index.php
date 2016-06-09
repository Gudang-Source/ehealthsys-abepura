<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('infomutasikeluar-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Mutasi Keluar</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Mutasi Keluar</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'infomutasikeluar-grid',
            'dataProvider'=>$model->searchInformasiMutasiKeluar(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'tglmutasioa',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglmutasioa)',
                    ),
                    'nomutasioa',
                    'ruangantujuanmutasi_nama',
                    'statuspesan',
                    array(
                        'name'=>'pegawaimutasi_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaiMutasiLengkap',
                    ),
                    array(
                        'name'=>'pegawaimengetahuimutasi_id',
                        'type'=>'raw',
                        'value'=>'$data->PegawaiMengetahuiLengkap',
                    ),
                    'keteranganmutasi',
                    array(
                        'header'=>'Status Terima / Batal',
                        'type'=>'raw',
						'value'=>'(empty($data->terimamutasi_id) ? "BELUM DITERIMA ".
							CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0);",
							array("class"=>"", 
								  "onclick"=>"batalMutasi(".$data->mutasioaruangan_id.");return false;",
								  "rel"=>"tooltip",
								  "title"=>"Klik untuk membatalkan mutasi obat / alkes ini",
							))
						 : "SUDAH DITERIMA")',
                    ),
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("gudangFarmasi/MutasiObatAlkes/print",array("mutasioaruangan_id"=>$data->mutasioaruangan_id,"frame"=>true)),
                                     array("class"=>"", 
                                           "target"=>"mutasikeluar",
                                           "onclick"=>"$(\"#dialogMutasi\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat rincian mutasi",
                                     ))',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format,'instalasiTujuans'=>$instalasiTujuans,'ruanganTujuans'=>$ruanganTujuans)); ?>
</div>
<?php echo $this->renderPartial($this->path_view.'_jsFunctions'); ?>

<?php 
// ===========================Dialog Details=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogMutasi',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Rincian Mutasi',
                        'autoOpen'=>false,
                        'minWidth'=>900,
                        'minHeight'=>100,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="mutasikeluar" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Details================================