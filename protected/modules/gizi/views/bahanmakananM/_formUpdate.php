<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gzbahanmakanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this)'),
    'focus' => '#BahanmakananM_jenisbahanmakanan',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php
            echo $form->dropDownListRow($model, 'sumberdanabhn', CHtml::listData($model->SumberDanaItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
             <?php
                echo $form->dropDownListRow($model, 'golbahanmakanan_id', CHtml::listData($model->GolBahanMakananItems, 'golbahanmakanan_id', 'golbahanmakanan_nama'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
            <?php // echo $form->textFieldRow($model,'jenisbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'jenisbahanmakanan', CHtml::listData($model->JenisBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>

            <?php // echo $form->textFieldRow($model,'kelbahanmakanan',array('size'=>50,'maxlength'=>50)); ?>
            <?php
            echo $form->dropDownListRow($model, 'kelbahanmakanan', CHtml::listData($model->KelBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
           
            <?php echo $form->textFieldRow($model, 'namabahanmakanan', array('onkeypress' => "return $(this).focusNextInputField(event)", 'size' => 60, 'maxlength' => 100)); ?>
           
           <?php echo $form->checkBoxRow($model,'bahanmakanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
        <td>
             <?php
                echo $form->dropDownListRow($model, 'satuanbahan', CHtml::listData($model->SatuanBahanMakananItems, 'lookup_name', 'lookup_value'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
             <?php echo $form->textFieldRow($model, 'jmlpersediaan', array('class' => "span1 numbers-only",'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            <?php
            echo $form->dropDownListRow($model, 'jmldlmkemasan', CHtml::listData($model->JmlDlmKemasanItems, 'lookup_value', 'lookup_name'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --',));
            ?>
            <?php echo $form->textFieldRow($model, 'jmlminimal', array('class' => "span1 numbers-only", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style'=>'text-align: right;',)); ?>
            <?php // echo $form->textFieldRow($model,'sumberdanabhn',array('size'=>50,'maxlength'=>50)); ?>
            

            <?php echo $form->textFieldRow($model, 'harganettobahan', array('class' => "span2 integer2", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style'=>'text-align: right;',)); ?>
            <?php echo $form->textFieldRow($model, 'hargajualbahan', array('class' => "span2 integer2", 'onkeypress' => "return $(this).focusNextInputField(event)", 'style'=>'text-align: right;',)); ?>
        </td>
        <td>
            <?php // echo $form->textFieldRow($model,'tglkadaluarsabahan');  ?>
            <div class="control-group">
                <?php $model->tglkadaluarsabahan = MyFormatter::formatDateTimeForUser($model->tglkadaluarsabahan)?>
                <?php echo $form->labelEx($model, 'tglkadaluarsabahan', array('class' => 'control-label')) ?>
                <div class="controls">  
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglkadaluarsabahan',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => 'dd M yy',
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
            
            <?php // echo $form->textFieldRow($model,'satuanbahan',array('size'=>50,'maxlength'=>50)); ?>
           
            <?php echo $form->textFieldRow($model, 'discount', array('class' => "span2 numbers-only", 'style'=>'text-align: right;', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <hr />
            <span class="help-block">Zat Gizi Bahan Makanan :</span>
            <fieldset>
                <div id="divZatgizi">
<!--                                    <table id="tblinputZatgizi">
                        <tbody>-->
                    <?php
                    $datas = $datas = ZatgiziM::model()->findAll(array(
                                'order'=>'zatgizi_nama',
                              ));
                    $md = Chtml::listData($modZatBahanMakananM, 'zatgizi_id', 'kandunganbahan');
                    
                    $gid = array();
                    foreach ($md as $idx=>$val) {
                        array_push($gid, $idx);
                    }
                    
                    
                    $returnVal = array();
                    $tr = '';
                    $inputHiddenZatgizi = '<input type="hidden" size="4" name="zatgizi_id[]" readonly="true"/>';
                    /* $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span3" style="width:500px;"><th> Pilih Semua <br/>'.CHtml::checkBox('checkUncheck', false, array('onclick'=>'checkUncheckAll(this);')).'</th>
                      <th>Nama Zatgizi</th><th>'.$inputHiddenZatgizi.'Kandungan</th>'; */
                    $returnVal = '<table id="tblinputzatgizi" class="table table-condensed table-bordered span1" style="width:400px; float:left;"><th> Pilih </th>
                                                                <th>Nama Zatgizi</th><th>' . $inputHiddenZatgizi . 'Kandungan</th>';
                    foreach ($datas as $data) {
                        $c = false; $v = 0;
                        if (in_array($data->zatgizi_id, $gid)) {
                            $c = true; $v = $md[$data->zatgizi_id];
                        }
                        $tr .= "<tr><td>";
                        $tr .= CHtml::checkBox('zatgizi_id[]', $c, array('value'=>$data->getAttribute('zatgizi_id')));
                        $tr .= '</td><td width="100%">'.$data->getAttribute('zatgizi_nama');
                        $tr .= '</td><td nowrap>'.CHtml::textField("kandunganbahan[$data->zatgizi_id]", str_replace('.',',',$v), array('size'=>6,'class'=>'default float2 span1', 'style'=>'text-align: right'));
                        $tr .= ' '.$data->zatgizi_satuan;
                        $tr .= "</td></tr>";
                    }
                    $returnVal .= $tr;
                    $returnVal .= '</table>';
                    echo $returnVal;
                    ?>
                    <!--                                        </tbody>
                                                        </table>-->
                </div>
            </fieldset> 
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <div class="form-actions">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/bahanMakananM/admin'), array('class' => 'btn btn-danger', 'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                ?>
                <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Bahan Makanan', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('bahanMakananM/admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab'=>'frame')), array('class' => 'btn btn-success'));
    ?>
                <?php
                $content = $this->renderPartial('../tips/tipsaddedit4b', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
        </td>
    </tr>
</table>
<?php $this->endWidget(); ?>
<script>
    $( document ).ready(function(){
        
        $('.integer2').each(
                    function () {
                        this.value = formatNumber(this.value)
                    }
            );
    });
</script>