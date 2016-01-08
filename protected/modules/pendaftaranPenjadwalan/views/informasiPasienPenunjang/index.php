<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php

Yii::app()->clientScript->registerScript('search', "
$('#formCari').submit(function(){
	$.fn.yiiGridView.update('PPInformasiPasienPenunjang-v', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Pasien Penunjang</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pasien Penunjang</b></h6>
        <div class="table-responsive">
            <?php
            $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'PPInformasiPasienPenunjang-v',
                    'dataProvider'=>$model->searchPasienPenunjang(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                        array(
                            'name'=>'pendaftaran.tgl_pendaftaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)',
                        ),
                        array(
                           'header'=>'No. Pendaftaran',
                           'name'=>'pendaftaran.no_pendaftaran',
                           'type'=>'raw',
                           'value'=>'$data->pendaftaran->no_pendaftaran',
                           'htmlOptions'=>array('style'=>'width:120px')
                        ),
                        array(
                            'header'=>'No. Rekam Medik',
                            'type'=>'raw',
                            'value'=>'
                                                    CHtml::link("<i class=\'icon-form-ubah\'></i> ".$data->pasien->no_rekam_medik, Yii::app()->createUrl("/pendaftaranPenjadwalan/InfoKunjunganRJ/ubahPasienAjax", array("pendaftaran_id"=>$data->pendaftaran_id)),
                                                    array("class"=>"",
                                                    "target"=>"frameEditPasien",
                                                    "rel"=>"tooltip",
                                                    "title"=>"Klik Untuk Mengubah Data Pasien",
                                                    "onclick"=>"$(\'#editPasien\').dialog(\'open\');return true;"))',
                                             'htmlOptions'=>array('style'=>'width:120px')
                        ),
                        array(
                            'header'=>'Nama Pasien',
                            'type'=>'raw',
                            'value'=>'$data->pasien->nama_pasien',
                        ),
                        array(
                            'header'=>'Ruangan Penunjang',
                            'type'=>'raw',
                            'value'=>'$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header'=>'Ruangan Asal',
                            'type'=>'raw',
                            'value'=>'$data->ruanganasal->ruangan_nama',
                        ),
                        array(
                            'header'=>'No. Masuk Penunjang',
                            'type'=>'raw',
                            'value'=>'$data->no_masukpenunjang',
                        ),
                        array(
                            'header'=>'Tanggal Masuk Penunjang',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglmasukpenunjang)',
                        ),
                        array(
                            'header'=>'Kelas Pelayanan',
                            'type'=>'raw',
                            'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                        ),
                        array(
                            'header'=>'Jenis Kasus Penyakit',
                            'type'=>'raw',
                            'value'=>'$data->jeniskasuspenyakit->jeniskasuspenyakit_nama',
                            'htmlOptions'=>array('style'=>'text-align: left; width: 75px;')
                        ),
                        array(
                            'header'=>'Keterangan Pendaftaran',
                            'name'=>'pendaftaran.keterangan_pendaftaran',
                            'type'=>'raw',
                            'value'=>'"<div style=\'width:100px;\'>" . CHtml::link("<i class=icon-form-ubah></i>". $data->pendaftaran->keterangan_pendaftaran," ",array("onclick"=>"ubahKeterangan(\'$data->pendaftaran_id\');$(\'#editKeterangan\').dialog(\'open\');return false;", "rel"=>"tooltip","rel"=>"tooltip","title"=>"Klik Untuk Mengubah Keterangan Pendaftaran")) . "</div>"',
                            'htmlOptions'=>array('style'=>'text-align: left; width: 75px;')
                        ),

                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
        </div>
    </div>
    <div class="search-form" style="">
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'id'=>'formCari',
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($model, 'no_rekam_medik'),
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
        <fieldset class="box">
             <legend class="rim"><i class="icon-search icon-white"></i> Pencarian</legend>
             <div class="row-fluid">
                <div class="span4">
                    <?php echo CHtml::label('Tanggal Pendaftaran','tgl_pendaftaran', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$model,
                                             'attribute'=>'tgl_awal',
                                             'mode'=>'date',
    //                                          'maxDate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'class'=>'dtPicker2',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>

                    </div><br /><br />
                    <?php echo CHtml::label(' Sampai Dengan',' Sampai Dengan', array('class'=>'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php $this->widget('MyDateTimePicker',array(
                                             'model'=>$model,
                                             'attribute'=>'tgl_akhir',
                                             'mode'=>'date',
    //                                         'maxdate'=>'d',
                                             'options'=> array(
                                             'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                             'htmlOptions'=>array('readonly'=>true,
                                             'class'=>'dtPicker2',
                                             'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>            
                </div>
                <div class="span4">
                    <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3 numberOnly','onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                </div>
                <div class="span4">
                    <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                    <?php //echo $form->dropDownListRow($model,'status_konfirmasi',CustomFunction::getStatusKonfirmasi(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
                </div>
            </div>
             <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                           array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan'));
                ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                            $this->createUrl($this->id.'/index'), 
                                            array('class'=>'btn btn-danger',
                                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
                <?php 
                    $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>    
            </div>
        </fieldset>
    </div>    
    <?php $this->endWidget();
         $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
         $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
         $urlPrintLembarPoli = Yii::app()->createUrl('print/lembarPoliRI',array('pendaftaran_id'=>''));
    ?>


    <?php
        //=============================== Ganti Data Pasien Dialog =======================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog',
            array(
                'id'=>'editPasien',
                'options'=>array(
                    'title'=>'Ganti Data Pasien' ,
                    'autoOpen'=>false,
                    'width' => 1280,
                                    'height' => 560,
                    'resizable' => true,
                ),
            )
        );

        echo CHtml::hiddenField('temp_norekammedik','',array('readonly'=>true));
        echo '<iframe name="frameEditPasien" width="100%" height="100%"></iframe>';
        $this->endWidget('zii.widgets.jui.CJuiDialog');
    ?>
	
	<?php
    //=============================== Ganti Data Keterangan pendaftaran =======================================
    $this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'editKeterangan',
            'options'=>array(
                'title'=>'Ubah keterangan Pendaftaran',
                'autoOpen'=>false,
                'minWidth'=>500,
                'modal'=>true,
            ),
        )
    );
    echo CHtml::hiddenField('temp_idPendaftaranKet','',array('readonly'=>true));
    echo '<div class="divForFormEditKeterangan"></div>';
    $this->endWidget('zii.widgets.jui.CJuiDialog');
?>
</div>

<script type="text/javascript">
	function ubahKeterangan(pendaftaran_id)
{
    $('#temp_idPendaftaranKet').val(pendaftaran_id);
    jQuery.ajax({'url':'<?php echo $this->createUrl('ubahKeteranganPendaftaran')?>',
        'data':$(this).serialize(),
        'type':'post',
        'dataType':'json',
        'success':function(data){
            if (data.status == 'create_form') {
                $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                $('#editKeterangan div.divForFormEditKeterangan form').submit(ubahKeterangan);
            }else{
                $('#editKeterangan div.divForFormEditKeterangan').html(data.div);
                $.fn.yiiGridView.update('PPInformasiPasienPenunjang-v', {
                        data: $(this).serialize()
                });
                setTimeout("$('#editKeterangan').dialog('close') ",500);
            }
        },
        'cache':false
    });
    return false; 
}
</script>