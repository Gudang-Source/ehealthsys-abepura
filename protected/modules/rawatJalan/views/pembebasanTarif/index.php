<div class="white-container">
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'pembebasantarif-t-form',
        'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
                                 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#'.CHtml::activeId($modPasien,'no_rekam_medik'),
    )); ?>

    <?php $this->renderPartial('_ringkasDataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien));?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

        <?php echo $form->errorSummary($model); ?>

                <?php echo $form->hiddenField($model,'pegawai_id',array('class'=>'span3', 'readonly'=>true)); ?>


                <?php //echo $form->textFieldRow($model,'tindakanpelayanan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'komponentarif_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'jmlpembebasan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>

        <table width="100%">
            <thead>
            <tr>
                <th>
                    <div class="control-group ">
                        <?php $model->pegawai_nama = (!empty($model->pegawai_id)) ? PegawaiM::model()->findByPk($model->pegawai_id)->nama_pegawai : ''; ?>
                        <?php echo $form->labelEx($model,'pegawai_id',array('class'=>'control-label required')); ?>
                        <div class="controls">
                            <?php $this->widget('MyJuiAutoComplete',array(
                                        'model'=>$model,
                                        'attribute'=>'pegawai_nama',
                                        'source'=>'js: function(request, response) {
                                                       $.ajax({
                                                           url: "'.Yii::app()->createUrl('ActionAutoComplete/DaftarDokter').'",
                                                           dataType: "json",
                                                           data: {
                                                               term: request.term,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $(this).val( ui.item.label);
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                                                            $(this).val(ui.item.value);
                                                $("#'.CHtml::activeId($model, 'pegawai_id').'").val(ui.item.value);
                                                                                            setDataPasien();
                                                return false;
                                            }',

                                        ),
                                        'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                                                    'class'=>'span3',
                                                                                    'onblur' => 'if(this.value === "") $("#'.CHtml::activeId($model, 'pegawai_id').'").val("");setDataPasien(); '),
                                        'tombolDialog'=>array('idDialog'=>'dialogDokter','idTombol'=>'tombolDialogDokter'),
                            )); ?>
                        </div>
                    </div>
                </th>
                <th>
                    <?php //echo $form->textFieldRow($model,'tglpembebasan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
                        <?php echo $form->labelEx($model,'tglpembebasan', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tglpembebasan',
                                                    'mode'=>'datetime',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2-5'),
                            )); 
                                     ?>
                        </div>
                    </div>
                </th>
            </tr>
            </thead>
        </table>

        <div id="divTarifPasien">
            <table id="tblTindakanPasien" class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>Tabel Pembebasan Tarif Pasien</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                        array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)'));
                 ?>
                  <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->module->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
                <?php /*echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.pembebasantarifT.'/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); */ ?>
            <?php
    $content = $this->renderPartial('rawatJalan.views/tips/transaksiPembebasanTarif',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
        </div>

    <?php $this->endWidget(); ?>

    <?php 
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'=>'dialogDokter',
        'options'=>array(
            'title'=>'Dokter',
            'autoOpen'=>false,
            'resizable'=>true,
            'modal'=>true,
            'width'=>640,
        ),
    ));

    $criteria = new CDbCriteria();
    $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
    $criteria->order = 'nama_pegawai';
    $models = DokterV::model()->findAll($criteria);
    $dataProvider = new CActiveDataProvider('DokterV',array(
        'criteria'=>$criteria,
    ));

    $modDokter = new RJDokterV('searchDokterdialog');
    $modDokter->unsetAttributes();
    if(isset($_GET['RJDokterV'])) {
        $modDokter->attributes = $_GET['RJDokterV'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rjobat-alkes-m-grid',
            'dataProvider'=>$modDokter->searchDokterdialog(),
            'filter'=>$modDokter,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                        'header'=>'Pilih',
                        'type'=>'raw',
                        'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "                                        
                                            $(\"#'.CHtml::activeId($model,'pegawai_nama').'\").val(\"$data->nama_pegawai\");
                                            $(\"#'.CHtml::activeId($model,'pegawai_id').'\").val(\"$data->pegawai_id\");
                                                                                    setDataPasien();
                                                                                    $(\"#dialogDokter\").dialog(\"close\");
                                        "))',
                ),
                array(
                    'header' => 'NIP',
                    'name' => 'nomorindukpegawai',
                    'value' => '$data->nomorindukpegawai',
                    'filter' => Chtml::activeTextField($modDokter, 'nomorindukpegawai', array('class'=>'numbers-only'))
                ),
                array(
                    'header'=>'Nama Pegawai',
                    'name' => 'nama_pegawai',
                    'value'=>'$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                    'filter' => Chtml::activeTextField($modDokter, 'nama_pegawai', array('class'=>'hurufs-only'))
                ),
                array(
                    'header'=>'Jabatan',
                    'name' => 'jabatan_id',
                    'value'=> function($data){
                        $j = JabatanM::model()->findByPk($data->jabatan_id);
                        
                        if (count($j)>0){
                            return $j->jabatan_nama;
                        }else{
                            return '-';
                        }
                    },
                    'filter' => Chtml::activeDropDownList($modDokter, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll(" jabatan_aktif = TRUE ORDER BY jabatan_nama ASC "), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --'))
                ),
                ),
     'afterAjaxUpdate'=>'function(id, data){            
            $(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });            
        }',
));

    $this->endWidget('ext.bootstrap.widgets.BootGridView');

    ?>
</div>
<script type="text/javascript">

$(document).ready(function(){
    // Notifikasi Pasien
    <?php 
        if(isset($_GET['smspasien'])){
            if($_GET['smspasien']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS PASIEN', isinotifikasi:'Pasien <?php echo $modPasien->nama_pasien; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
    // Notifikasi Dokter
    <?php 
        if(isset($_GET['smsdokter'])){
            if($_GET['smsdokter']==0){
    ?>
        var params = [];
        params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Yii::app()->session['modul_id']; ?>, judulnotifikasi:'GAGAL KIRIM SMS DOKTER', isinotifikasi:'dr. <?php echo $model->pegawai->nama_pegawai; ?> tidak memiliki nomor mobile'}; // 16 
        insert_notifikasi(params);
    <?php            
            }
        }
    ?>
});
</script>

