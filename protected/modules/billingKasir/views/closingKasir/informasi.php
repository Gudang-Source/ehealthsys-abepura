<div class="white-container">
    <legend class="rim2">Informasi <b>Closing Kasir</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Informasi Closing Kasir',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#informasiclosingkasir-t-search').submit(function(){
            $('#informasiclosingkasir-m-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                    'action'=>Yii::app()->createUrl($this->route),
                    'method'=>'get',
                    'id'=>'informasiclosingkasir-t-search',
                    'type'=>'horizontal',
                'focus'=>'#BKInformasiclosingkasirV_nama_pegawai'
    )); ?>
    <div id="divSearch-form">
        <div class="block-tabel">
            <h6>Tabel <b>Closing Kasir</b></h6>
            <?php $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
                'id'=>'informasiclosingkasir-m-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'mergeHeaders'=>array(
                    array(
                        'name'=>'<center>Penerimaan</center>',
                        'start'=>4, 
                        'end'=>5, 
                    ),
                ),
                'columns'=>array(
                            array(
                                'name'=>'tglclosingkasir',
                                'header'=>'Tanggal Closing Kasir',
                                'type'=>'raw',
        //                        'value'=>'$data->tglclosingkasir." <br>/".$data->getBuktibayar(\'tglbuktibayar\')',
                                'value'=>'$data->tglclosingkasir',
                            ),
                            'shift_nama',
                            array(
                                'name'=>'closingdari',
                                'header'=>'Periode Closing',
                                'type'=>'raw',
                                'value'=>'$data->closingdari." sd.<br/> ".$data->sampaidengan',
                            ),
                            array(
                                'name'=>'closingsaldoawal',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatUang($data->closingsaldoawal)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'name'=>'terimauangmuka',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatUang($data->terimauangmuka)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'name'=>'terimauangpelayanan',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatUang($data->terimauangpelayanan)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'name'=>'nilaiclosingtrans',
                                'type'=>'raw',
                                'value'=>'MyFormatter::formatUang($data->nilaiclosingtrans)',
                                'htmlOptions'=>array('style'=>'text-align: right'),
                            ),
                            array(
                                'header'=>'Setor Ke Bank',
                                'type'=>'raw',
                                'value'=>'empty($data->setorbank_id) ? "<center>-</center>" 
                                    : $data->tgldisetor." ".CHtml::Link("<i class=\"icon-list-alt\"></i>",Yii::app()->controller->createUrl("ClosingKasir/RincianSetoran",array("idSetor"=>$data->setorbank_id)),
                                                                array("class"=>"", 
                                                                      "target"=>"iframeRincianSetoran",
                                                                      "onclick"=>"$(\"#dialogRincianSetoran\").dialog(\"open\");",
                                                                      "rel"=>"tooltip",
                                                                      "title"=>"Klik untuk melihat Rincian Setoran",
                                                                ))',
                                'htmlOptions'=>array('style'=>'text-align: center;'),
                            ),
                            array(
                                'header'=>'Rincian Closing',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-rinciankasir\"></i>",Yii::app()->controller->createUrl("ClosingKasir/Rincian",array("idClosing"=>$data->closingkasir_id)),
                                                array("class"=>"", 
                                                      "target"=>"iframeRincianClosing",
                                                      "onclick"=>"$(\"#dialogRincianClosing\").dialog(\"open\");",
                                                      "rel"=>"tooltip",
                                                      "title"=>"Klik untuk melihat Rincian Closing",
                                                ))',          
                                'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),
                            array(
                                'header'=>'Batal Closing',
                                'type'=>'raw',
                                'value'=>'CHtml::Link("<i class=\"icon-form-silang\"></i>",Yii::app()->controller->createUrl("ClosingKasir/Batalclosing",array("idClosing"=>$data->closingkasir_id)),
                                                array("class"=>"", 
                                                      "target"=>"iframeBatalClosing",
                                                      "onclick"=>"$(\"#dialogBatalClosing\").dialog(\"open\"), refreshTable();",
        //                                              "onclick"=>"refreshTable()",
                                                      "rel"=>"tooltip",
                                                      "title"=>"Klik untuk membatalkan Closing Kasir",
                                                ))',          
                                'htmlOptions'=>array('style'=>'text-align: center; width:40px')
                            ),
                            'nama_pegawai',

                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
        </div>
        <fieldset class="box">
            <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
            <table width="100%">
                <tr>
                    <td>
                        <div class="control-group ">
                            <?php echo CHtml::label('Tanggal Pembebasan',  CHtml::activeId($model, 'tgl_awal'), array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                    //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium');
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_awal',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>'dd M yy',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>
                                </div>
                        </div>
                        <div class="control-group ">
                            <?php echo CHtml::label('Sampai Dengan',CHtml::activeId($model, 'tgl_akhir'), array('class'=>'control-label')) ?>
                                <div class="controls">
                                    <?php   
                                    //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); 
                                            $this->widget('MyDateTimePicker',array(
                                                            'model'=>$model,
                                                            'attribute'=>'tgl_akhir',
                                                            'mode'=>'date',
                                                            'options'=> array(
                                                                'dateFormat'=>'dd M yy',
                                                            ),
                                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                            ),
                                    )); ?>
                                </div>
                        </div> 

                    </td>
                    <td>
                        <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3')); ?>
                        <?php echo $form->dropDownlistRow($model,'shift_id',Chtml::listData($model->ShiftItems, 'shift_id', 'shift_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                    </td>
                </tr>
            </table>
            <div class="form-actions">
                 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                     <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset', 'onclick'=>'resetForm();')); ?>
                                            <?php  
            $content = $this->renderPartial('tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
            </div>
        </fieldset>
    <?php $this->endWidget(); ?>
    </div>
</div>
<script>
function resetForm(){
    window.open("<?php echo $this->createUrl("/".$this->route); ?>", "_self");
}

// Fungsi untuk merefresh table grid, setelah row dibatal kan table harus direfresh agar data terupdate
function refreshTable(){
    var delay=2000;//2 seconds
    setTimeout(function(){

    $('#informasiclosingkasir-m-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('informasiclosingkasir-m-grid', {
		data: $(this).serialize()
	});
	return false;
    
    },delay); 
    
}
</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianSetoran',
    'options'=>array(
        'title'=>'Rincian Setoran Ke Bank',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>480,
        'minHeight'=>360,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianSetoran" width="100%" height="320" >
</iframe>
<?php
$this->endWidget();
?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianClosing',
    'options'=>array(
        'title'=>'Rincian Closing Kasir',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>1000,
        'minHeight'=>500,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianClosing" width="100%" height="460" >
</iframe>
<?php
$this->endWidget();
?>
<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogBatalClosing',
    'options'=>array(
        'title'=>'Batal Closing',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>480,
        'minHeight'=>300,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeBatalClosing" width="100%" height="256" >
</iframe>
<?php
$this->endWidget();
?>
    