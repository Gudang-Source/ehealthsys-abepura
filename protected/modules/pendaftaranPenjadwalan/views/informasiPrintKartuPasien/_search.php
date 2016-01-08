<legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'ppinformasiprintkartupasien-search',
    'type' => 'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'no_rekam_medik'),
        ));
?>

<style>
    #ruangan label{
        width: 200px;
            display:inline-block;
        }
</style>
<div class="row-fluid">
    <div class="span4">
        <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
        <div class="control-group ">
            <?php echo CHtml::label('Tanggal Pendaftaran', 'tgl_pendaftaran', array('class' => 'control-label')) ?>
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
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder'=>'Ketik No. Rekam Medik','class' => 'span3', 'maxlength' => 10)); ?>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder'=>'Ketik Nama Pasien','class' => 'span3', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model,'alamat_pasien',array('placeholder'=>'Ketik Alamat Pasien','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo CHtml::label('RT / RW','rt', array('class'=>'control-label inline')) ?>
            <div class="controls">
                <?php echo $form->textField($model,'rt', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?>   / 
                <?php echo $form->textField($model,'rw', array('onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1 numberOnly','maxlength'=>3)); ?> 
            </div>
        </div>

        <?php
            echo $form->dropDownListRow(
                $model, 'statusprintkartu',array( '0' => 'Belum', '1' => 'Sudah'),array('empty'=>'-- Pilih --', 'options'=>array(1=>array('selected'=>false)))
        ); ?>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('informasiPrintKartuPasien/index'), array('class'=>'btn btn-danger')); ?>
    <?php 
        $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>	
</div>

<?php $this->endWidget(); ?>
