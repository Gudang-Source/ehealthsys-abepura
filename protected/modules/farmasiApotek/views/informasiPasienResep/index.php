<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Resep</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#FAResepturT_noresep',
            'method'=>'get',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    $this->widget('bootstrap.widgets.BootAlert');

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    $('#caripasien-form button[type=\'reset\']').click(function(){
            $('#caripasien-form')[0].reset();
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $('#caripasien-form').serialize()
            });
            return false;
    });
    ");?>
    <div class='block-tabel'>
        <h6>Tabel <b>Pasien Resep</b></h6>
        <?php
        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'pencarianpasien-grid',
            'dataProvider'=>$model->searchInformasiPasienResep(),
    //        'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'noreseptur',
                            array (
                            'name'=>'tglreseptur',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglreseptur)'
                            ),
                'no_pendaftaran',
                'no_rekam_medik',
                'nama_pasien',
                'nama_bin',
                'carabayar_nama',
                'penjamin_nama',
                'jeniskasuspenyakit_nama',
                'umur',
                'instalasi_nama',
                'ruangan_nama',
                array(
                    'header'=>'Reseptur',
                    'type'=>'raw', 
                    'value'=>'CHtml::Link("<i class=\"icon-form-reseptur\"></i>",Yii::app()->createUrl("farmasiApotek/InformasiPasienResep/printResepDokter",array("id"=>$data->reseptur_id,"frame"=>1)),
                            array("class"=>"", 
                                  "target"=>"iframeReseptur",
                                  "onclick"=>"$(\"#dialogReseptur\").dialog(\"open\");",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk print reseptur dokter",
                            ))',
                ),
                array(
                    'header'=>'Penjualan Resep',
                    'type'=>'raw', 
                    'value'=>'(isset($data->penjualanresep_id) ? $data->getNoPenjualanResep($data->reseptur_id). 
					
					CHtml::Link("<i class=\"icon-form-jualresep\"></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/Index",array("reseptur_id"=>$data->reseptur_id)),
                                array("class"=>"", 
                                      "target"=>"_BLANK",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk menjual resep",
                                ))
					
					: CHtml::Link("<i class=\"icon-form-jualresep\"></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/Index",array("reseptur_id"=>$data->reseptur_id)),
                                array("class"=>"", 
                                      "target"=>"_BLANK",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk menjual resep",
                                )))',
                    'htmlOptions'=>array('style'=>'text-align: left;'),
                ),
                            array(
                    'header'=>'Copy Resep',
                    'type'=>'raw', 
                    'value'=>'(!$data->penjualanresep_id) ? "<center>-</center>" :
                                                            CHtml::Link("<i class=\"icon-form-copy\"></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/CopyResep",array("penjualanresep_id"=>$data->penjualanresep_id,"pasien_id"=>$data->pasien_id)),
                                array("class"=>"", 
                                      "target"=>"iframeCopyResep",
                                      "onclick"=>"$(\"#dialogCopyResep\").dialog(\"open\");",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk Copy Resep ",
                                ))',
                    'htmlOptions'=>array('style'=>'text-align: left; width:40px'),
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));

        $this->widget('bootstrap.widgets.BootAlert');
        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#caripasien-form').submit(function(){
                $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        $('#caripasien-form button[type=\'reset\']').click(function(){
                $('#caripasien-form')[0].reset();
                $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                });
                return false;
        });
        ");?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-search icon-white"></i> <?php echo  Yii::t('mds','Search Patient') ?></legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'tglreseptur', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                        //
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::label(' Sampai dengan','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3 numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model,'noresep',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
            </tr>
        </table>
    </fieldset>
      
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
        <?php  
        $content = $this->renderPartial('../tips/informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    
</script>

<?php 
// Dialog buat nambah data propinsi =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogPenjualanResep',
    'options'=>array(
        'title'=>'Penjualan Resep',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframePenjualanResep" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end propinsi dialog =============================
?>

<?php 
// Dialog untuk menampilkan riwayat reseptur=========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogReseptur',
    'options'=>array(
        'title'=>'Resep Dokter',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>1100,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>"js:function(){ $.fn.yiiGridView.update('pencarianpasien-grid', {
                        data: $('#caripasien-form').serialize()
                    }); }",
    ),
));
?>
<iframe src="" name="iframeReseptur" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end dialog reseptur riwayat =============================
?>

<?php 
// Dialog buat Copy Resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogCopyResep',
    'options'=>array(
        'title'=>'Salinan Resep',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1250,
        'zIndex'=>1004,
        'maxHeight'=>610,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeCopyResep" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end Copy Resep dialog =============================
?>