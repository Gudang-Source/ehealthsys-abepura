

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sabahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php // echo $form->textFieldRow($model,'jenisbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'jenisbahanmakanan', CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>

            <?php // echo $form->textFieldRow($model,'kelbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'kelbahanmakanan', CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>

            <?php echo $form->textFieldRow($model, 'namabahanmakanan', array('size' => 60, 'maxlength' => 100)); ?>
            <?php echo $form->textFieldRow($model, 'jmlpersediaan'); ?>
            <?php
            echo $form->dropDownListRow($model, 'jmldlmkemasan', CHtml::listData($model->JmlDlmKemasanItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'jmlminimal'); ?>
            <?php // echo $form->textFieldRow($model,'sumberdanabhn',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'sumberdanabhn', CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>

            <?php echo $form->textFieldRow($model, 'harganettobahan'); ?>
            <?php echo $form->textFieldRow($model, 'hargajualbahan'); ?>
        </td>
        <td>
            <div class="control-group">
                <?php // echo $form->textFieldRow($model,'tglkadaluarsabahan');  ?>
                <?php echo $form->labelEx($model, 'tglkadaluarsabahan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglkadaluarsabahan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                        ),
                        'htmlOptions' => array('readonly' => true,
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'dtPicker3',
                        ),
                    ));
                    ?> 
                </div>
            </div>
            <?php // echo $form->textFieldRow($model,'golbahanmakanan_id'); ?>
            <?php
            echo $form->dropDownListRow($model, 'golbahanmakanan_id', CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
            <?php // echo $form->textFieldRow($model,'satuanbahan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'satuanbahan', CHtml::listData($model->SatuanBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
            <?php echo $form->textFieldRow($model, 'discount'); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <hr />
            <span class="help-block">Zat Gizi Bahan Makanan :</span>
            <fieldset>
                <div id="divZatgizi">
                    <?php
                    $datas = ZatBahanMakananM::model()->findAll("bahanmakanan_id='$model->bahanmakanan_id' ORDER BY zatbahanmakan_id");
                    $returnVal = array();
                    $tr = '';
                    $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                    /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br/>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                      <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                    $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span1" style="width:400px; float:left;"><th> Pilih </th>
                                            <th>Nama Zatgizi</th><th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                    foreach ($datas as $data) {
                        $ZatgiziId = ZatgiziM::model()->findAll("zatgizi_id='$data->zatgizi_id' ORDER BY zatgizi_id");
                        if (!empty($zatgizi[$data->zatgizi_id])) {
                            $ceklis = true;
                            $kandungan = $data->kandunganbahan;
                        } else {
                            $ceklis = false;
                            $kandungan = 0;
                        }
                        foreach ($ZatgiziId as $ZatgiziNama) {
                            $tr .= "<tr><td>";
                            $tr .= CHtml::checkBox('zatbahanmakan_id[]', $ceklis, array('value' => $data->getAttribute('zatbahanmakan_id')));
                            $tr .= '</td><td>' . $ZatgiziNama->getAttribute('zatgizi_nama');
                            $tr .= '</td><td>' . CHtml::textField("kandunganbahan[$data->zatbahanmakan_id]", $kandungan, array('size' => 6, 'class' => 'default'));
                            $tr .= "</td></tr>";
                        }
                    }
                    $returnVal .= $tr;
                    $returnVal .= '</table>';
                    echo $returnVal;
                    ?>
                </div>
            </fieldset>
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bahan Makanan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp";
                $content = $this->renderPartial('../tips/tipsaddedit', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?> 
            </div>
        </td>
    </tr>
</table>
            
<?php $this->endWidget(); ?>