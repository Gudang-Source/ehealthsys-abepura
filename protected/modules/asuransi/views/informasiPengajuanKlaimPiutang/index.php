<div class="white-container">
    <legend class="rim2">Informasi Pengajuan <b>Klaim Piutang</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('#divSearch-form form').submit(function(){
            $('#kupembklaimpiutang-t-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('kupembklaimpiutang-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel Pengajuan <b>Klaim Piutang</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'kupembklaimpiutang-t-grid',
            'dataProvider'=>$model->searchInformasiPengajuan(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header'=>'No.',
                        'value' => '(($this->grid->dataProvider->pagination) ? $this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize : 0) + $row+1',
                        ),
                    array(
                        'name'=>'tglpengajuanklaimanklaim',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengajuanklaimanklaim)',
                    ),
                    array(
                        'name'=>'nopengajuanklaimanklaim',
                        'value'=>'$data->nopengajuanklaimanklaim',
                    ),
                    array(
                        'header' => 'Cara Bayar / Penjamin',
                        'type' => 'raw',
                        'value'=>'$data->carabayar_nama." <br/> / ".$data->penjamin_nama',
                    ),
                    array(
                        'header'=>'Total Pengajuan',
                        'name'=>'totalpiutang',
                        'value'=>'number_format($data->totalpiutang,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ),
                                    array(
                                    'header'=>'Pembayaran Klaim Piutang',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:left;'),
                                    'value'=>function($data){
                                       $cek = PengajuanklaimpiutangT::model()->findByPk($data->pengajuanklaimpiutang_id);
                            
                                        if (empty($cek->pembayarklaim_id)){ 
                                        return CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("PembayaranKlaimPiutangAS/index",array("pengajuanklaim_id"=>$data->pengajuanklaimpiutang_id)),
                                                                            array("class"=>"", 
                                                                                      "rel"=>"tooltip",
                                                                                      "title"=>"Klik untuk melakukan pembayaran Klaim Piutang",
                                                                    ));
                                        }else{
                                            echo "SUDAH DIBAYAR";
                                        }
                                    },
                                                    ),
                                    array(
                                                            'header'=>'Rincian Pengajuan',
                                                            'type'=>'raw',
                                                            'htmlOptions'=>array('style'=>'text-align:left;'),
                                                            'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("InformasiPengajuanKlaimPiutang/detail",array("id"=>$data->pengajuanklaimpiutang_id,"frame"=>true)),
                                                                                                    array("class"=>"", 
                                                                                                              "target"=>"detailPembayaran",
                                                                                                              "onclick"=>"$(\"#dialogDetail\").dialog(\"open\");",
                                                                                                              "rel"=>"tooltip",
                                                                                                              "title"=>"Klik untuk melihat detail Pengajuan Klaim Piutang",
                                                                                            ))',
                                                    ),
                                    array(
                        'header'=>'Batal',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:left;'),
                        'value'=>function($data){
                            $cek = PengajuanklaimpiutangT::model()->findByPk($data->pengajuanklaimpiutang_id);
                            
                            if (empty($cek->pembayarklaim_id)){
                                return CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("InformasiPengajuanKlaimPiutang/batalPembayaran",array("id"=>$data->pengajuanklaimpiutang_id,"frame"=>true)),
                                                                array("class"=>"", 
                                                                          "target"=>"batalPembayaran",
                                                                          "onclick"=>"deleteRecord($data->pengajuanklaimpiutang_id);",
                                                                          "rel"=>"tooltip",
                                                                          "title"=>"Klik untuk membatalkan Pengajuan Klaim Piutang",
                                                        ));
                            }
                                    
                                    
                        },
                ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box" id="divSearch-form">
        <?php $this->renderPartial('_search',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
</div>
<?php 
// ===========================Dialog Detail=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogDetail',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Rincian Pengajuan Klaim Piutang',
                        'autoOpen'=>false,
                        'width'=>900,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="detailPembayaran" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Detail================================
?>
<?php 
// ===========================Dialog Pembatalan=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogPembatalan',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Pembatalan Pembayaran Gaji',
                        'autoOpen'=>false,
                        'width'=>550,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="batalPembayaran" width="100%" height="500">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Pembatalan================================
?>
<script>
	function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->controller->createUrl("InformasiPengajuanKlaimPiutang/batalPembayaran"); ?>';
        myConfirm("'Yakin Anda akan melakukan Pembatalan Pembayaran?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('kupembklaimpiutang-t-grid');
						}else{
							myAlert('Data Gagal di Hapus')
						}
                },"json");
           }
        });
    }
</script>
