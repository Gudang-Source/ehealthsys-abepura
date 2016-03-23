<div class="white-container">
    <legend class="rim2">Informasi <b>Retur Penjualan</b></legend>
    <?php
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'search',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modInfoReturPenjualan,'noreturresep'),
                'method'=>'get',
                'htmlOptions'=>array(),
        ));
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Retur Penjualan</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                 $('#informasipenjualanresep-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('informasipenjualanresep-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('ext.bootstrap.widgets.BootGridView', array(
            'id'=>'informasipenjualanresep-grid',
            'dataProvider'=>$modInfoReturPenjualan->searchReturPenjualan(),
    //        'filter'=>$modInfo,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Tanggal Retur',
                    'type'=>'raw',
                    'value'=>'$data->tglretur',
                ),
                array(
                    'header'=>'No. Retur Resep',
                    'type'=>'raw',
                    'value'=>'$data->noreturresep',
                ),
                array(
                    'header'=>'Jenis Penjualan',
                    'type'=>'raw',
                    'value'=>'isset($data->penjualanresep->jenispenjualan)?$data->penjualanresep->jenispenjualan:""',
                ),
                array(
                    'header'=>'Mengetahui',
                    'type'=>'raw',
                    'value'=>'$data->pegawairetur->nama_pegawai',
                ),
                array(
                    'header'=>'Pegawai Retur',
                    'type'=>'raw',
                    'value'=>'$data->pegawairetur->nama_pegawai',
                ),

                array(
                    'header'=>'Detail Retur',
                    'type'=>'raw', 
                    'value'=>'	(
                                                            (!empty($data->penjualanresep_id)) ? 
                                                                    CHtml::Link("<i class=\"icon-form-rincianretur\"></i>",Yii::app()->controller->createUrl("informasiPenjualanResep/returPenjualan",array("id"=>$data->returresep_id)),
                                                                    array("class"=>"", 
                                                                              "target"=>"iframeDetailRetur",
                                                                              "onclick"=>"$(\"#dialogDetailRetur\").dialog(\"open\");",
                                                                              "rel"=>"tooltip",
                                                                              "title"=>"Klik untuk lihat Detail Retur Penjualan",
                                                                    ))
                                                                    : CHtml::Link("<i class=\"icon-form-rincianretur\"></i>",Yii::app()->controller->createUrl("ReturResepPasien/printRincian",array("returresep_id"=>$data->returresep_id,"frame"=>1)),
                                                                    array("class"=>"", 
                                                                              "target"=>"iframeDetailRetur",
                                                                              "onclick"=>"$(\"#dialogDetailRetur\").dialog(\"open\");",
                                                                              "rel"=>"tooltip",
                                                                              "title"=>"Klik untuk lihat Detail Retur Resep Pasien",
                                                                    ))
                                                            )',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),

            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Retur','tglawal',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php $modInfoReturPenjualan->tgl_awal = $format->formatDateTimeForUser($modInfoReturPenjualan->tgl_awal); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modInfoReturPenjualan,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                    'maxDate' => 'd',
                                                        //
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $modInfoReturPenjualan->tgl_awal = $format->formatDateTimeForDb($modInfoReturPenjualan->tgl_awal); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::label(' Sampai dengan','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $modInfoReturPenjualan->tgl_akhir = $format->formatDateTimeForUser($modInfoReturPenjualan->tgl_akhir); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$modInfoReturPenjualan,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                    'minDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $modInfoReturPenjualan->tgl_akhir = $format->formatDateTimeForDb($modInfoReturPenjualan->tgl_akhir); ?>
                        </div>
                    </div>
                    <?php //echo $form->textFieldRow($modInfoReturPenjualan,'no_rekam_medik',array('class'=>'span3 numbersOnly','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php //echo $form->textFieldRow($modInfoReturPenjualan,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Retur Resep','noreturresep',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->textField($modInfoReturPenjualan,'noreturresep',array('placeholder'=>'Ketik No. Retur Resep','class'=>'span3', 'autofocus'=>true)); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
                <?php  
                    $content = $this->renderPartial('../tips/informasiReturPenjualan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>

    <?php 
    // Dialog buat lihat penjualan resep =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
        'id'=>'dialogDetailRetur',
        'options'=>array(
            'title'=>'Detail Retur Penjualan Resep',
            'autoOpen'=>false,
            'modal'=>true,
            'zIndex'=>1002,
            'minWidth'=>980,
            'minHeight'=>610,
            'resizable'=>false,
        ),
    ));
    ?>
    <iframe src="" name="iframeDetailRetur" width="100%" height="550" >
    </iframe>
    <?php
    $this->endWidget();
    //========= end lihat penjualan resep dialog =============================
    ?>
</div>