<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'rminfo-pasien-baru-v-search',
    'type' => 'horizontal',
        ));
?>
<fieldset class="box">
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        Tanggal Kunjungan
                    </label>
                    <div class="controls">
                        <?php
                        $format = new MyFormatter;
                        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
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
                        ?> </div>
                </div>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">
                        Sampai dengan
                    </label>
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
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('class' => 'span3', 'maxlength' => 10, 'autofocus' => true, 'placeholder' => 'Ketik no. rekam medik')); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'nama_pasien', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Ketik nama pasien')); ?>
                <?php echo $form->textFieldRow($model, 'penanggungJawab', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Ketik nama penanggung jawab')); ?>
                <?php echo $form->textFieldRow($model, 'alamat_pasien', array('class' => 'span3', 'maxlength' => 50, 'placeholder' => 'Ketik alamat pasien')); ?>
            </td>
            <td>
                <?php
                echo $form->dropDownListRow($model, 'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",
                    'ajax' => array('type' => 'POST',
                        'url' => $this->createUrl('GetPenjaminPasien', array('encode' => false, 'namaModel' => 'RKInfoPasienBaruV')),
                        'update' => '#' . CHtml::activeId($model, 'penjamin_id') . ''  //selector to update
                    ),
                ));
                ?>
                <?php echo $form->dropDownListRow($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                <?php echo $form->dropDownListRow($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --')); ?>
            </td>
        </tr>
    </table>
</fieldset>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>

    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/infoPasienBaruV/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    $content = $this->renderPartial('../tips/informasi', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div> 
<?php $this->endWidget(); ?>
