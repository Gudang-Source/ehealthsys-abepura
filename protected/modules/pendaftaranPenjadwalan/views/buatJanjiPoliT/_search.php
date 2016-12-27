<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppbuat-janji-poli-t-search',
        'focus'=>'#'.CHtml::activeId($model, 'nama_pegawai'),
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">                    
                    <?php echo CHtml::label('Tanggal Awal','tgl_awal', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                        </div>
                </div>
                <div class="control-group ">
                    <?php echo CHtml::label('Tanggal Akhir','tgl_akhir', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php $model->tgl_akhir= $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php   
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker2', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                                    ),
                            )); ?>
                            <?php $model->tgl_akhir= $format->formatDateTimeForDb($model->tgl_akhir); ?>
                        </div>
                </div> 
        </td>
        <td>            
            <?php echo $form->textFieldRow($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik','class'=>'numberOnly')); ?>
            <?php echo $form->textFieldRow($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien', 'class'=>'hurufs-only')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'nama_pegawai',array('placeholder'=>'Ketik Nama Dokter', 'class' => 'hurufs-only')); ?>
            
            <div class="control-group">
                <?php echo Chtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                <div class="controls">
            <?php //echo $form->textFieldRow($model,'ruangan_nama',array('placeholder'=>'Ketik Nama Ruangan')); 
                echo $form->dropDownList($model,'ruangan_id', Chtml::listData(PPRuanganM::model()->findAll('ruangan_aktif = TRUE ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --')); 
            ?>
                </div>
            </div>
            
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php $controller = Yii::app()->controller->id; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/Admin'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'return refreshForm(this);'));  ?>
    <?php  
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasiBuatJanjiPoli',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
	
</div>

<?php $this->endWidget(); ?>


<?php

$js = <<< JS
$('.numberOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});
JS;
Yii::app()->clientScript->registerScript('numberOnly',$js,CClientScript::POS_READY);
?>