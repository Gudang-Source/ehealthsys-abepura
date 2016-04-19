<legend class='rim'><i class="icon-white icon-search"></i> Pencarian</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rjrinciantagihanpasien-v-search',
    'type' => 'horizontal',
        ));
?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_pendaftaran', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                    $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_akhir', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tgl_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                    ));
                    ?>    
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('class' => 'span3', 'maxlength' => 20, 'autofocus' => true, 'placeholder' => 'Ketik no. pendaftaran')); ?>
            <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Ketik no. rekam medik')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Ketik nama pasien')); ?>
            <?php echo $form->dropDownListRow($model, 'statusBayar', LookupM::getItems('statusbayar'), array('empty' => '-- Pilih --', 'class' => 'span3', 'maxlength' => 20)); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); echo "&nbsp;"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'konfirmasi()', 'onKeypress' => 'return formSubmit(this,event)'));
    ?>          
    <?php
    $content = $this->renderPartial('gizi.views.tips.informasiPembayaranGizi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>
