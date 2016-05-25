<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'lookup-m-form',
    'enableAjaxValidation'=>false,
    'type'=>'horizontal',
    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    'focus'=>'#'.CHtml::activeId($model,'lookup_type'),
)); ?>

    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid">
        
        <div class="control-group ">
            <label for="LookupM_lookup_type" class="control-label required">Type <span class="required">*</span></label>
            <div class="controls">
                <?php echo CHtml::textField('lookup_type',$model->lookup_type,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'onblur'=>'setLookup(this.value);', 'maxlength'=>100,'readonly'=>(!empty($model->lookup_id)?true:false),)); ?>
            </div>
        </div>
    </div>
    <div class="row-fluid block-tabel">
        <h6>Tabel <b>Lookup</b></h6>
        <table id="table-lookup" class="table table-striped table-bordered table-condensed">
            <thead>
                <th>Nama</th>
                <th>Value</th>
                <th>Kode</th>
                <th>Urutan</th>
                <?php if ($this->action->id == "update") :?>
                <th>Aktif</th>
                <?php endif; ?>
                <th></th>
            </thead>
            <tbody>
        
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                "#", 
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = window.location.href;} ); return false;')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Pengaturan Lookup',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl($this->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success')); ?>
        <?php $this->widget('UserTips',array('type'=>'create'));?>
        </div>
    </div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial('_jsFunctions',array('model'=>$model,'modDetail'=>$modDetail)); ?>