<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sasmsgateway-m-form',
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
        <?php //echo $form->textFieldRow($model,'modul_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'jenissms', LookupM::getItems('jenissms'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->dropDownListRow($model, 'tujuansms', LookupM::getItems('tujuansms'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
<?php echo $form->textFieldRow($model, 'formatsms', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 10)); ?>
<?php echo $form->textFieldRow($model, 'jmlkaraktersms', array('class' => 'span3 integer', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>


    </div>
    <div class = "span4">
        <?php echo $form->textFieldRow($model, 'katawalsms', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <?php echo $form->textFieldRow($model, 'kataakhirsms', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 5)); ?>
        <div>
            <?php echo $form->checkBoxRow($model, 'ishurufkapital', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->checkBoxRow($model, 'statussms', array('onkeyup' => "return $(this).focusNextInputField(event);")); ?>
        </div>
    </div>
    <div class = "span4">
        <?php
        echo $form->dropDownListRow($model, 'modul_id', SAModulK::getModuls(), array('empty' => '-- Pilih --',
            'class' => 'span3',
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'ajax' => array('type' => 'POST',
                'url' => $this->createUrl('GetControllers', array('encode' => false)),
                'update' => '#' . CHtml::activeId($model, 'modcontroller')
            ),
                )
        );

        echo $form->dropDownListRow($model, 'modcontroller', array(), array('empty' => '-- Pilih --',
            'class' => 'span3',
            'onkeypress' => "return $(this).focusNextInputField(event)",
                )
        );
        ?>
        <div class="control-group">
        <?php echo CHtml::label('Nama Action', '', array('class' => 'control-label')) ?>
            <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'modaction',
            'value' => $model->modaction,
            // 'sourceUrl'=> $this->createUrl('AutocompleteGetActions'),
            'source' => 'js: function(request, response) {
                                       $.ajax({
                                           url: "' . $this->createUrl('AutocompleteGetActions') . '",
                                           dataType: "json",
                                           data: {
                                               term:request.term, modul:$("#' . CHtml::activeId($model, 'modul_id') . '").val(), controller:$("#' . CHtml::activeId($model, 'modcontroller]') . '").val(),
                                           },
                                           success: function (data) {
                                                   response(data);
                                           }
                                       })
                                    }',
            'options' => array(
                'showAnim' => 'fold',
                'minLength' => 0,
                'focus' => 'js:function( event, ui ) {
                                            $("#modaction").val(ui.item.value);
                                            return false;
                                        }',
                'select' => 'js:function( event, ui ) {
                                            $("#modaction").val(ui.item.value);
                                            return false;
                                        }',
            ),
            'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 '),
        ));
        ?>

            </div>
        </div>
        <?php echo $form->textAreaRow($model, 'templatesms', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 250)); ?>
    </div>
</div>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl('create'), array('class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Smsgateway', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php $this->widget('UserTips', array('type' => 'create')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>