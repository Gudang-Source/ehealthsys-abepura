<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Berhutang</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Daftar Pasien'=>array('/billingKasir/daftarPasien'),
            'PasienKarcis',
    );?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'caripasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#BKPembayaranpelayananT_no_rekam_medik',
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    ));

    Yii::app()->clientScript->registerScript('cariPasien', "
    $('#caripasien-form').submit(function(){
            $.fn.yiiGridView.update('pencarianpasien-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Berhutang</b></h6>
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'pencarianpasien-grid',
                'dataProvider'=>$model->searchPasienBerhutang(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                    array(
                        'header'=>'Tanggal Bukti Bayar',
                        'name'=>'tglbuktibayar',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tandabuktibayar->tglbuktibayar)."<br>".$data->tandabuktibayar->nobuktibayar',
                    ),
                    array(
                        'name'=>'instalasi',
                        'type'=>'raw',
                        'value'=>'isset($data->pendaftaran->instalasi->instalasi_nama) ? $data->pendaftaran->instalasi->instalasi_nama : " - " ',
                    ),
                    array(
                        'header'=>'No. Pendaftaran',
                        'name'=>'no_pendaftaran',
                        'type'=>'raw',
                        'value'=>'isset($data->pendaftaran_id)?$data->pendaftaran->no_pendaftaran:" - "',
                    ),
                    array(
                        'header'=>'No. Rekam Medik',
                        'name'=>'no_rekam_medik',
                        'type'=>'raw',
                        'value'=>'$data->pasien->no_rekam_medik',
                    ),
                    array(
                        'header'=>'Nama Pasien / Alias',
                        'name'=>'nama_pasien',
                        'type'=>'raw',
                        'value'=>'$data->pasien->nama_pasien."".(isset($data->nama_bin) ? "/".$data->nama_bin : "")',
                    ),
                    array(
                        'header'=>'Cara Bayar | Penjamin',
                        'name'=>'carabayar_nama',
                        'type'=>'raw',
                        'value'=>'isset($data->pendaftaran_id)?$data->pendaftaran->carabayar->carabayar_nama."<br>".$data->pendaftaran->penjamin->penjamin_nama:" - "',
                    ),
                    array(
                        'name'=>'total_tagihan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totalbiayapelayanan)',
                    ),
                    array(
                        'header'=>'Subsidi Asuransi',
                        'name'=>'subsidi_asuransi',
                        'type'=>'raw',
                        'value'=>'$data->totalsubsidiasuransi',
                    ),
//                    array(
//                        'header'=>'Subsidi Pemerintah',
//                        'name'=>'subsidi_pemerintah',
//                        'type'=>'raw',
//                        'value'=>'$data->totalsubsidipemerintah',
//                    ),
                    array(
                        'header'=>'Subsidi Rumah Sakit',
                        'name'=>'subsidi_rs',
                        'type'=>'raw',
                        'value'=>'$data->totalsubsidirs',
                    ),
                    array(
                        'header'=>'Biaya',
                        'name'=>'iur_biaya',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totaliurbiaya)',
                    ),
                    array(
                        'header'=>'Discount',
                        'name'=>'discount',
                        'type'=>'raw',
                        'value'=>'$data->totaldiscount',
                    ),
                    array(
                        'header'=>'Pembebasan',
                        'name'=>'pembebasan',
                        'type'=>'raw',
                        'value'=>'$data->totalpembebasan',
                    ),
                    array(
                        'header'=>'Jumlah Pembayaran',
                        'name'=>'jumlah_pembayaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatUang($data->totalbayartindakan)',
                    ),
                    array(
                        'header'=>'Rincian Hutang',
                        'type'=>'raw',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:left;'),
                        'value'=>'CHtml::Link("<i class=\"icon-form-rincianhutang\"></i>",Yii::app()->controller->createUrl("RinciantagihanpasienV/rincianHutang",array("id"=>$data->pendaftaran_id, "idpembayaran"=>$data->pembayaranpelayanan_id, "frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframeRincianTagihan",
                                          "onclick"=>"$(\"#dialogRincianHutang\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk melihat Rincian Tagihan",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),            
                    array(
                        'header'=>'Bayar Angsuran',
                        'type'=>'raw',
                        'value'=>'($data->totalsisatagihan == 0)? "Lunas":
                        CHtml::Link("<i class=\"icon-form-bayar\"></i>",Yii::app()->controller->createUrl("bayarAngsuran/index",array("idPembayaran"=>$data->pembayaranpelayanan_id,"frame"=>true)),
                                    array("class"=>"", 
                                          "target"=>"iframePembayaran",
                                          "onclick"=>"$(\"#dialogRetur\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk membayar angsuran",
                                    ))',          'htmlOptions'=>array('style'=>'text-align: left; width:40px')
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <?php //echo $this->renderPartial('_formKriteriaPencarian', array('model'=>$model,'form'=>$form),true);  ?> 
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> <?php echo  Yii::t('mds','Search Patient') ?></legend>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <div class="control-group ">
                        <?php //$model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Tanggal Pendaftaran','tglPendaftaran', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
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
                    <div class="control-group ">
                        <?php //$model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd hh:mm:ss'),'medium','medium'); ?>
                        <?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
    //                                                    'minDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>

                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group">
                        <?php echo CHtml::label('No. Rekam Medik', 'no_rekam_medik', array('class'=>'control-label')); ?>
                        <div class="controls">
                         <?php echo $form->textField($model,'no_rekam_medik',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?> 
                        </div>
                    </div>
                   <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'no_pendaftaran',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>                
                    <div class="control-group">
                        <?php echo CHtml::label('Alias', 'nama_bin', array('class'=>'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

                        </div>

                    </div>
                    <!--  modified by @author Rahman Fad | Tidak ada Status Periksa (EHS-1254) | 22-05-2014  -->
                    <?php //$model->statusperiksa = (!empty($model->statusperiksa)) ? $model->statusperiksa : 'SEDANG PERIKSA';?>
                     <?php //echo $form->dropDownListRow($model,'statusperiksa', LookupM::getItems('statusperiksa'),array('empty'=>'-- Pilih --')); ?>
                </td>
            </tr>
        </table>
    </fieldset>


    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                        array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('DaftarPasien/PasienBerhutang'), array('class'=>'btn btn-danger','onKeypress'=>'return formSubmit(this,event)')); ?>
						<?php  
$content = $this->renderPartial('tips/informasi2',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
    </div>

<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRetur',
    'options'=>array(
        'title'=>'Pembayaran Angsuran',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>850,
        'minHeight'=>500,
        'width' => 900,
        'height' => 550,
        'resizable'=>true,
        'close'=> 'js:function(){$.fn.yiiGridView.update(\'pencarianpasien-grid\', {data: $("#caripasien-form").serialize()});}'
    ),
));
?>
<iframe src="" name="iframePembayaran" width="100%" height="500" ></iframe>
<?php
$this->endWidget();
?>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogRincianHutang',
    'options'=>array(
        'title'=>'Rincian Tagihan Pasien Berhutang',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1001,
        'minWidth'=>700,
        'minHeight'=>400,
        'resizable'=>true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" width="100%" height="550" ></iframe>
<?php
$this->endWidget();
?>
</div>