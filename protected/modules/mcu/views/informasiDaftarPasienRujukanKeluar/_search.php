<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'caripasien-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'focus' => '#' . CHtml::activeId($model, 'no_pendaftaran'),
    'htmlOptions' => array(),
        ));
?>

<fieldset class="row-fluid box"> 
    <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <table width="100%" class="table-condensed">
        <tr>
            <td>
                <div class="control-group ">
                    <label class='control-label'>Tanggal Dirujuk</label>
                    <div class="controls">
                        <?php
                        $model->tgl_awal = isset($model->tgl_awal) ? MyFormatter::formatDateTimeForUser($model->tgl_awal) : date('d M Y');
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
                    <label class='control-label'>Tanggal Akhir</label>
                    <div class="controls">
                        <?php
                        $model->tgl_akhir = isset($model->tgl_akhir) ? MyFormatter::formatDateTimeForUser($model->tgl_akhir) : date('d M Y');
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
                <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'Ketik No. Pendaftaran', 'class' => 'span3', 'maxlength' => 20)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'Ketik No. Rekam Medik', 'class' => 'span3', 'maxlength' => 10)); ?>

                <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Ketik Nama Pasien', 'class' => 'span3', 'maxlength' => 50)); ?>
            </td>
            <td>
                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Status Periksa</label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'statusperiksa', LookupM::getItems('statusperiksa'), array('empty' => '-- Pilih --')); ?>
                    </div>
                </div>  

                <div class="control-group ">
                    <label for="namaPasien" class="control-label">Dokter Penanggung Jawab</label>
                    <div class="controls">
                        <?php echo $form->dropDownList($model, 'nama_pegawai', CHtml::listData(DokterV::model()->findAll(), 'nama_pegawai', 'nama_pegawai'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit'));
        ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'reset')); ?>
        <?php
        $content = $this->renderPartial('tips/informasiPasienRujukKeluar', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>