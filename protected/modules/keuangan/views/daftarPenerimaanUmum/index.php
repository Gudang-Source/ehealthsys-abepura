<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Daftar Penerimaan Umum',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('#penerimaan-t-search').submit(function(){
            $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Informasi <b>Penerimaan Umum</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'penerimaan-t-search',
            'type'=>'horizontal',
        'focus'=>'#BKPenerimaanUmumT_nopenerimaan'
    )); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Penerimaan Umum</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'daftarpenerimaan-m-grid',
            'dataProvider'=>$modPenerimaan->searchInformasi(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'tglpenerimaan',
                'nopenerimaan',
                array(
                    'header'=>'Nama Penerimaan',
                    'value'=>'$data->jenispenerimaan->jenispenerimaan_nama',
                ),
                'namapenandatangan',
                'kelompoktransaksi',
                'volume',
                'satuanvol',
                array(  'name'=>'hargasatuan',
                        'value'=>'"Rp".number_format($data->hargasatuan,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(  'name'=>'totalharga',
                        'value'=>'"Rp".number_format($data->totalharga,0,"",".")',
                        'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array( 
                    'header'=>'Retur Penerimaan Umum',
                    'type'=>'raw',
                    'htmlOptions' => array(
                        'style' => 'width: 100px; text-align:left;',
                    ),
                    'value'=>'CHtml::link("<i class=\'icon-form-retur\'></i> ",Yii::app()->createUrl("billingKasir/returPenerimaanUmum/index",array("frame"=>1,"idPenerimaan"=>$data->penerimaanumum_id)) ,array("title"=>"Klik Untuk Meretur Penerimaan Umum","target"=>"iframeRetur", "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");", "rel"=>"tooltip"))',
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php //$modPenerimaan->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Tgl. Penerimaan','tglPenerimaan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPenerimaan,
                                                'attribute'=>'tgl_awal',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                )); 
                            ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php //$modPenerimaan->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPenerimaan->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$modPenerimaan,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'minDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                                )); 
                            ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class = "control-group">
                            <?php echo Chtml::label("No Penerimaan",'nopenerimaan', array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php echo $form->textField($modPenerimaan,'nopenerimaan',array('class'=>'span3 angkahuruf-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                    <?php echo $form->textFieldRow($modPenerimaan,'namapenandatangan',array('class'=>'span3 hurufs-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <?php //echo $form->textFieldRow($modPenerimaan,'nippenandatangan',array('class'=>'span3 numbers-only','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    
                    <div class = "control-group">
                            <?php echo Chtml::label("Kelompok Transaksi",'kelompoktransaksi', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($modPenerimaan,'kelompoktransaksi', LookupM::getItems('kelompoktransaksi') ,array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php  
            $content = $this->renderPartial('../tips/informasi_penerimaanumum',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>
<?php
// ===========================Dialog Retur=========================================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                    'id'=>'dialogRetur',
                        // additional javascript options for the dialog plugin
                        'options'=>array(
                        'title'=>'Retur Penerimaan Umum',
                        'autoOpen'=>false,
                        'zIndex'=>1002,
                        'minWidth'=>1100,
                        'minHeight'=>100,
                        'resizable'=>false,
						'close'=>"js:function(){ $.fn.yiiGridView.update('daftarpenerimaan-m-grid', {
							data: $(this).serialize()
						}); }",
                         ),
                    ));
?>
<iframe src="" name="iframeRetur" width="100%" height="550">
</iframe>
<?php    
$this->endWidget('zii.widgets.jui.CJuiDialog');
//===============================Akhir Dialog Retur================================
