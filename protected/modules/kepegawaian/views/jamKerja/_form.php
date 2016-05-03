<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'kpjamkerja-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
        ));
?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <div class = "span4">
        <?php echo $form->dropDownListRow($model, 'shift_id', CHtml::listData(ShiftM::model()->findAll(array('order' => 'shift_nama')), 'shift_id', 'shift_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => 'return $(this).focusNextInputField(event)'))
        ?>
        <?php echo $form->textFieldRow($model, 'jamkerja_nama', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>

        <div class="control-group ">
                <?php echo $form->labelEx($model, 'jammasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jampulang', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jampulang',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div>
            <?php echo $form->checkBoxRow($model, 'jamkerja_aktif', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jamisitrahat', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamisitrahat',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jammasukistirahat', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammasukistirahat',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jammulaiscanmasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaiscanmasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jamakhirscanmasuk', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirscanmasuk',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
    </div>
    <div class = "span4">  
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jammulaiscanplng', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jammulaiscanplng',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jamakhirscanplng', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'jamakhirscanplng',
                    'mode' => 'time',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true,
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'class' => 'dtPicker3',
                    ),
                ));
                ?> 
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'toleransiterlambat', array('class' => 'span1', 'placeholder' => 'menit', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'toleransiplgcpt', array('class' => 'span1', 'placeholder' => 'menit', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Jam Kerja', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
            $content = $this->renderPartial('kepegawaian.views.tips.tipsaddedit4c',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
