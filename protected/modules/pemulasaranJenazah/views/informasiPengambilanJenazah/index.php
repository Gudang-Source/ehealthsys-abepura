<div class="white-container">
    <legend class="rim2">Informasi <b>Pengambilan Jenazah</b></legend>
    <?php
        $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'id'=>'search',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#',
                'method'=>'get',
        ));
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pengambilan Jenazah</b></h6>
        <?php
        $this->widget('bootstrap.widgets.BootAlert');

        Yii::app()->clientScript->registerScript('cariPasien', "
        $('#search').submit(function(){
                $('#pengambilanjenazah-grid').addClass('animation-loading');
                $.fn.yiiGridView.update('pengambilanjenazah-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id'=>'pengambilanjenazah-grid',
                'dataProvider'=>$model->searchInformasi(),
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(
                                array(
                        'header'=>'No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                    ),
                                array(
                        'header'=>'No. Rekam Medik',
                        'type'=>'raw',
                        'value'=>'$data->no_rekam_medik',
                    ),
                                array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->nama_pasien',
                    ),
                    array(
                        'header'=>'Tanggal Meninggal',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglmeninggal)',
                    ),
                    array(
                        'header'=>'Tanggal Pengambilan',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengambilan)',
                    ),
                    array(
                        'header'=>'Nama Pengambil Jenazah',
                        'type'=>'raw',
                        'value'=>'$data->nama_pengambiljenazah',
                    ),
                    array(
                        'header'=>'Hubungan',
                        'type'=>'raw',
                        'value'=>'$data->hubungan_pengjenazah',
                    ),
                    array(
                        'header'=>'No. Identitas Pengambil',
                        'type'=>'raw',
                        'value'=>'$data->noidentitas_pengjenazah',
                    ),
                    array(
                        'header'=>'Alamat Pengambil',
                        'type'=>'raw',
                        'value'=>'$data->alamat_pengjenazah',
                    ),
                    array(
                        'header'=>'No. Telp Pengambil',
                        'type'=>'raw',
                        'value'=>'$data->notelepon_pengjenazah',
                    ),
                    array(
                        'header'=>'Keterangan Pengambil',
                        'type'=>'raw',
                        'value'=>'$data->keterangan_pengambilan',
                    ),            
                    array(
                        'header'=>'Detail',
                        'type'=>'raw', 
                        'value'=>'CHtml::Link("<i class=\"icon-form-detail\"></i>",Yii::app()->controller->createUrl("informasiPengambilanJenazah/Print",array("id"=>$data->ambiljenazah_id,"frame"=>1)),
                                    array("class"=>"", 
                                          "target"=>"iframeAmbilJenazah",
                                          "onclick"=>"$(\"#dialogAmbilJenazah\").dialog(\"open\");",
                                          "rel"=>"tooltip",
                                          "title"=>"Klik untuk lihat detail pengambilan jenazah",
                                    ))',
                        'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                    ),
                ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            ));
        ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <div class="row-fluid">
            <div class="span4">
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Pengambilan','tglawal',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
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
                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            )); 
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label(' Sampai Dengan','tgl_akhir', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker2-5', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                ),
                        )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Pendaftaran','no_pendaftaran',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'no_pendaftaran',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>       
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pengambil','nama_pengambiljenazah',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'nama_pengambiljenazah',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Rekam Medik','no_rekam_medik',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'no_rekam_medik',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nama Pasien','nama_pasien',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'nama_pasien',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
            <div class="span4">
                <div class="control-group">
                    <?php echo CHtml::label('No. Identitas Pengambil','noidentitas_pengjenazah',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'noidentitas_pengjenazah',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('No. Telepon Pengambil','notelepon_pengjenazah',array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'notelepon_pengjenazah',array('autofocus'=>true, 'class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php
                echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
            ?>
            <?php  
                $content = $this->renderPartial('/tips/informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogAmbilJenazah',
    'options'=>array(
        'title'=>'Detail Pengambilan Jenazah',
        'autoOpen'=>false,
        'modal'=>true,
        'zIndex'=>1002,
        'minWidth'=>980,
        'minHeight'=>610,
        'resizable'=>false,
    ),
));
?>
<iframe src="" name="iframeAmbilJenazah" width="100%" height="550" >
</iframe>
<?php
$this->endWidget();
//========= end lihat penjualan resep dialog =============================
?>