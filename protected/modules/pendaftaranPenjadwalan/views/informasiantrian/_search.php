<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        ));
?>
<style>
    #ruangan label{
    width: 200px;
        display:inline-block;
    }
</style>
<fieldset class="box">
    <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
    <div class="row-fluid">
        <div class="span4">
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true,
                                    'class' => 'dtPicker2'),
                    ));
                    ?>
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div>
            </div>
            <div class="control-group ">
                <label class='control-label'>Sampai dengan</label>
                <div class="controls">
                    <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 
                                    'class' => 'dtPicker2'),
                    ));
                    ?>
                    <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20,'placeholder'=>'Ketik No. Pendaftaran')); ?>
        </div>
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true and instalasi_id in (2,4)'), 'instalasi_id', 'instalasi_nama'), array('empty'=>'-- Pilih --', 'class' => 'span3', 'ajax' => array('type' => 'POST',
                                                        'url' => $this->createUrl('GetRuanganForCheckBox', array('encode' => false, 'namaModel' => ''.$model->getNamaModel().'')),
                                                        'update' => '#ruangan',  //selector to update
                                                    ),)); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'ruangan_id', array('class'=>'control-label')); ?>
                <div class="controls">
                    <div id='ruangan'>
                        <label> Data Tidak Ditemukan</label>
                    <?php //echo $form->checkBoxList($model, 'ruangan_id', array(), array('empty'=>'-- Pilih --', 'class' => 'span5')); ?>
                        </div>
                </div>
            </div>
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10,'placeholder'=>'Ketik No. Rekam Medik')); ?>
        </div>
        <div class="span4">
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50,'placeholder'=>'Ketik Nama Pasien')); ?>
            <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('class' => 'span3','empty' => '-- Pilih --')); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
        <?php 
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>          
    </div>
</fieldset>
<?php $this->endWidget(); ?>
<script>
    function checkAll(){
        if($('#checkAllRuangan').is(':checked')){
           $('#search input[name*="ruangan_id"]').each(function(){
                $(this).attr('checked',true);
           });
        }else{
             $('#search input[name*="ruangan_id"]').each(function(){
                $(this).removeAttr('checked');
           });
        }
    } 
</script>
