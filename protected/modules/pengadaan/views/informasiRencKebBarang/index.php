<?php
Yii::app()->clientScript->registerScript('search', "
$('#divSearch-form form').submit(function(){
	$.fn.yiiGridView.update('rencana-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Rencana Kebutuhan Barang Umum</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Rencana Kebutuhan Barang Umum</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rencana-m-grid',
            'dataProvider'=>$model->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'name'=>'renkebbarang_tgl',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->renkebbarang_tgl)',
                    ),
                    'renkebbarang_no',                    
                    
                    array(
                        'name' => 'ro_barang_bulan',
                        'value' => '$data->ro_barang_bulan',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                    array(
                            'header'=>'Pegawai Mengetahui',
                            'type'=>'raw',
                            'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmengetahui_id)',
                    ),
                    array(
                            'header'=>'Pegawai Menyetujui',
                            'type'=>'raw',
                            'value'=>'ADInformasirenkebbarangV::pegawaimengetahui($data->pegmenyetujui_id)',
                    ),
 
                    array(
                        'header'=>'Rincian',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Rincian", array("renkebbarang_id"=>$data->renkebbarang_id)),
                                     array("class"=>"", 
                                           "target"=>"rencana",
                                           "onclick"=>"$(\"#dialogRencana\").dialog(\"open\");",
                                           "rel"=>"tooltip",
                                           "title"=>"Klik untuk melihat details Rencana",
                                     ))',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
					array(
						'header'=>'Pembelian',
						'type'=>'raw',
						'value'=>function($data) {
							$p = PembelianbarangT::model()->findByAttributes(array(
								'renkebbarang_id'=>$data->renkebbarang_id
							));
							if (!empty($p)) return "SUDAH<br/>MELAKUKAN<br/>PEMBELIAN";
							return CHtml::link("<i class=\"icon-form-retur\"></i>", 
									$this->createUrl($this->controllerPembelian.'/index', array(
										'rencana_id'=>$data->renkebbarang_id,
									)));
						},
						'htmlOptions'=>array('style'=>'text-align:center;'),
					),
                    array(
                        'header'=>'Batal',
                        'type'=>'raw',
                        'value'=>'CHtml::link("<i class=\'icon-form-silang\'></i> ", "javascript:deleteRecord($data->renkebbarang_id)",array("id"=>"$data->renkebbarang_id","rel"=>"tooltip","title"=>"Batalkan Rencana Kebutuhan Barang Umum"));',
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <?php echo $this->renderPartial($this->path_view.'search',array('model'=>$model,'format'=>$format)); ?>
</div>

<script type="text/javascript">
     function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/delete"; ?>';
        myConfirm('Yakin Akan Membatalkan Rencana Kebutuhan barang ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rencana-m-grid');
                            }else{
                                myAlert('Rencana Kebutuhan Gagal di Dibatalkan')
                            }
                },"json");
            }
        }); 

    }
    
</script>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogRencana',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Detail Rencana Kebutuhan Barang Umum',
                'autoOpen'=>false,
                'width'=>800,
                'height'=>500,
                'resizable'=>false,
                'scroll'=>false    
                 ),
        ));
        ?>
        <iframe src="" name="rencana" width="100%" height="100%">
        </iframe>
        <?php    
        $this->endWidget('zii.widgets.jui.CJuiDialog');
?>