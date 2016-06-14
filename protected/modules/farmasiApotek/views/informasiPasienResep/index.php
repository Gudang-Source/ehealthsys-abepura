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
                 array (
                    'header'=>'Tgl. Resep/<br>No. Resep',
                            'name'=>'tglreseptur."/<br/>".$data->noreseptur',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglreseptur)."<br/>".$data->noreseptur'
                            ),
                array(
                    'header'=>'Tgl. Pendaftaran/<br/>No. Pendaftaran',
                    'type'=>'raw',
                    'name'=>'tgl_pendaftaran',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/<br/>".$data->no_pendaftaran',
                ),
                //'no_pendaftaran',
                'no_rekam_medik',
                array(
                    'name'=>'nama_pasien',
                    'value'=>'$data->namadepan.$data->nama_pasien',
                ),
                array(
                    'header'=>'Jenis Kelamin/<br/>Umur',
                    'type'=>'raw',
                    'value'=>'$data->jeniskelamin."/<br/>".$data->umur',
                ),
                'jeniskasuspenyakit_nama',
                //'nama_bin',
                array(
                    'header'=>'Cara Bayar/<br/>Penjamin',
                    'type'=>'raw',
                    'value'=>'$data->carabayar_nama."/<br/>".$data->penjamin_nama',
                ),
                array(
                    'header'=>'Dokter/<br/>Ruangan',
                    'name'=>'pegawai_nama',
                    'type'=>'raw',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai.", ".$data->gelarbelakang_nama."/<br/>".$data->ruanganreseptur_nama',
                ),
                array(
                    'header'=>'Status Periksa',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $pd = PendaftaranT::model()->findByPk($data->pendaftaran_id);
                        return $pd->statusperiksa;
                    },
                ),
                //'car,abayar_nama',
                //'penjamin_nama',
                //'umur',
                //'instalasi_nama',
                //'ruangan_nama',
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
                    'value'=>function($data) {
                        if ($data->ruangan_id == Params::RUANGAN_ID_APOTEK_RJ && $data->penjamin_id == Params::PENJAMIN_ID_UMUM) return "-";
                        
                        return (isset($data->penjualanresep_id) ? CHtml::link("<i class='icon-form-rincianjual'></i>", Yii::app()->createUrl('farmasiApotek/informasiPenjualanResep/detailPenjualan', array(
                            'id'=>$data->penjualanresep_id, 'pasien_id'=>$data->pasien_id
                        )), array(
                            'target'=>'iframeDetailPenjualan',
                            'rel'=>'tooltip',
                            'title'=>'Klik untuk melihat detail penjualan resep',
                            'onclick'=>'$("#dialogDetailPenjualan").dialog("open")'
                        )).$data->getNoPenjualanResep($data->reseptur_id)
					
					: CHtml::Link("<i class='icon-form-jualresep'></i>",Yii::app()->controller->createUrl("PenjualanDariReseptur/Index",array("reseptur_id"=>$data->reseptur_id)),
                                array("class"=>"", 
                                      "target"=>"_BLANK",
                                      "rel"=>"tooltip",
                                      "title"=>"Klik untuk menjual resep",
                                )));
                    },
                    'htmlOptions'=>array('style'=>'text-align: center;'),
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
                    <?php echo $form->textFieldRow($model,'noreseptur',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model,'no_rekam_medik',array('class'=>'span3 numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php echo $form->textFieldRow($model,'nama_pasien',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <?php 
                    $carabayar = CarabayarM::model()->findAll(array(
                        'condition'=>'carabayar_aktif = true',
                        'order'=>'carabayar_nama ASC',
                    ));
                    foreach ($carabayar as $idx=>$item) {
                        $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                            'carabayar_id'=>$item->carabayar_id,
                            'penjamin_aktif'=>true,
                       ));
                       if (empty($penjamins)) unset($carabayar[$idx]);
                    }
                    $penjamin = PenjaminpasienM::model()->findAll(array(
                        'condition'=>'penjamin_aktif = true',
                        'order'=>'penjamin_nama',
                    ));
                    echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                        'empty'=>'-- Pilih --',
                        'class'=>'span3', 
                        'ajax' => array('type'=>'POST',
                            'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                            'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                        ),
                     ));
                    echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3'));
                    ?>
                </td>
                <td>
                    <?php
                    $pegawai = CHtml::listData(DokterV::model()->findAllByAttributes(array(
                        'instalasi_id'=>array(2, 3, 4),
                    ), array(
                        'order'=>'nama_pegawai asc',
                    )), 'pegawai_id', 'namaLengkap');
                    
                    echo $form->dropDownListRow($model, 'pegawai_id', $pegawai, array(
                        'empty'=>'-- Pilih --',
                    ));
                    
                    ?>
                    <?php
                        if (Yii::app()->user->getState('ruangan_nama') == "Apotek Rawat Jalan"):
                            $instalasi_id = array(2);
                        else:
                            $instalasi_id = array(3,4);
                        endif;
                        // var_dump($instalasi_id); die;
                    ?>
                    
                    <?php echo $form->dropDownListRow($model, 'ruanganreseptur_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array(
                            'instalasi_id'=>$instalasi_id,
                            'ruangan_aktif'=>true,
                        ), array(
                            'order'=>'ruangan_nama asc'
                        )), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --')); ?>
                    <?php echo $form->dropDownListRow($model,'statusperiksa', Params::statusPeriksa(), array('empty'=>'-- Pilih --')); ?>
                    <?php //echo $form->textFieldRow($model,'nama_bin',array('class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'statusJual', array('class'=>'control-label inline')) ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model, 'statusJual', array(1=>'Sudah Dijual', 2=>'Belum Dijual'), array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
      
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
        <?php  
        $content = $this->renderPartial('../tips/informasiPasienResep',array(),true);
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
// Dialog buat Detail Penjualan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogDetailPenjualan',
    'options'=>array(
        'title'=>'Penjualan Resep',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeDetailPenjualan" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end Detail Penjualan dialog =============================
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