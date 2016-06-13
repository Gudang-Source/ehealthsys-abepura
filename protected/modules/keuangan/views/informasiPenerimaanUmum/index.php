<?php
$this->breadcrumbs=array(
	'Daftar Penerimaan Kas',
);

Yii::app()->clientScript->registerScript('search', "
$('#penerimaan-t-search').submit(function()
{
    $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
        data: $(this).serialize()
    });
    return false;
});
$('#btn_resset').click(function()
{
    setTimeout(function(){
        $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
            data: $('#penerimaan-t-search').serialize()
        });    
    }, 1000);
});
");

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
    array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'penerimaan-t-search',
        'type'=>'horizontal',
    )
);
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Penerimaan Umum</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Penerimaan Umum</b></h6>
    
    <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'daftarpenerimaan-m-grid',
	'dataProvider'=>$modPenerimaan->searchInformasi(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
            array(
                'header'=>'No',
                'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                'header'=>'Tgl. Penerimaan',
                'type'=>'raw',
                'value'=>'$data->tglpenerimaan',
            ),
            array(
                'header'=>'No. Penerimaan',
                'type'=>'raw',
                'value'=>'$data->nopenerimaan',
            ),
            array(
                'header'=>'Kelompok <br/> Transaksi',
                'type'=>'raw',
                'value'=>'$data->kelompoktransaksi',
            ),
            array(
                'header'=>'Jenis Penerimaan',
                'type'=>'raw',
                'value'=>'$data->jenispenerimaan->jenispenerimaan_nama',
                'footerHtmlOptions'=>array('colspan'=>6,'style'=>'text-align:right;font-style:italic;'),
                'footer'=>'Jumlah Total',
            ),
            'volume',
//            'satuanvol',
            array(
                'header'=>'Harga',
                'name'=>'hargasatuan',
                'value'=>'MyFormatter::formatNumberForPrint($data->hargasatuan)',
                'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(hargasatuan)',
            ),
            array(
                'header'=>'Total Harga',
                'name'=>'totalharga',
                'value'=>'MyFormatter::formatNumberForPrint($data->totalharga)',
                'htmlOptions'=>array('style'=>'width:100px;text-align:right'),
                'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                'footer'=>'sum(totalharga)',
            ),
            array(
                'header'=>'Keterangan',
                'type'=>'raw',
                'value'=>'$data->keterangan_penerimaan',
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                'footer'=>'-',
            ),
            array(
                        'header'=>'<center>Lihat Detail</center>',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("DetailPenerimaanUmum",array("penerimaanumum_id"=>$data->penerimaanumum_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeDetPenerimaan",
                                          "onclick"=>"$(\"#dialogDetPenerimaan\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk detail Penerimaan",
                                    ))',
                                    'htmlOptions'=>array(
                                        'style'=>'text-align: center;'
                                    ),
                        'htmlOptions' => array(
                                                    'style' => 'width: 100px; text-align: center;',
                                            ),
                                            'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                        'footer'=>'',
            ),
            array( 
                'header'=>'Retur / Batal',
                'type'=>'raw',
                'htmlOptions' => array(
                    'style' => 'width: 100px; text-align: center;',
                ),
                'footerHtmlOptions'=>array('style'=>'text-align:right;color:white'),
                'footer'=>'-',
                'value'=>'CHtml::link("<i class=\'icon-form-retur\'></i> ",Yii::app()->createUrl("keuangan/returPenerimaanKas/index",array("frame"=>1,"idPenerimaan"=>$data->penerimaanumum_id)) ,array("title"=>"Klik Untuk Meretur Penerimaan Kas / Umum","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian Penerimaan Umum</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php // $modPenerimaan->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Tgl. Penerimaan Umum','tglPenerimaanKas', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPenerimaan,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                )); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php // $modPenerimaan->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPenerimaan,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'datetime',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'minDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                )); 
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($modPenerimaan,'nopenerimaan',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Jenis Penerimaan','jenisPenerimaan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                  echo  $form->dropDownList($modPenerimaan,'jenispenerimaan_id',CHtml::listData(JenispenerimaanM::model()->findAll("jenispenerimaan_aktif = TRUE ORDER BY jenispenerimaan_nama ASC"),
                                                    'jenispenerimaan_id','jenispenerimaan_nama'),array('class'=>'span2','style'=>"width:140px;",'empty'=>'--Pilih--'));
                            ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
                                        <?php  
        $content = $this->renderPartial('keuangan.views/tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
        </div>
    </fieldset>
</div>
<?php $this->endWidget(); ?>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRetur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Retur Penerimaan Umum',
                        'autoOpen'=>false,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                            'zIndex'=>1004,
                        'resizable'=>false,
                         ),
                    ));
?>
<iframe src="" name="iframeRetur" width="100%" height="550">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetPenerimaan',
    'options'=>array(
        'title'=>'Detail Penerimaan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeDetPenerimaan" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>