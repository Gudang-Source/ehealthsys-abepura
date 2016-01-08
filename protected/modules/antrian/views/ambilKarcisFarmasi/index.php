<div class="white-container">
    <legend class="rim2">Karcis <b>Antrian Ke Farmasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Anantrianfarmasi Ts'=>array('index'),
            'Tiket Antrian Farmasi ',
    );
    ?>
    <?php
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success','Data karcis farmasi berhasil disimpan!');
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row-fluid">
        <div class = "span4">
            <fieldset class="box">
                <legend class="rim">Buat Karcis</legend>
                <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                        'id'=>'anantrianfarmasi-t-form',
                        'enableAjaxValidation'=>false,
                        'type'=>'horizontal',
                        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
                        'focus'=>'#'.CHtml::activeId($model, 'racikan_id'),
                )); ?>

                <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

                <?php echo $form->errorSummary($model); ?>
                <?php echo $form->textFieldRow($model,'tglambilantrian',array('class'=>'span3 realtime', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php // echo $form->textFieldRow($model,'racikan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'racikan_id', $model->getListRacikans(),array('class'=>'span3','empty'=>'-- Pilih --') )?>
                <?php echo $form->textFieldRow($model,'noantrian',array('readonly'=>true,'placeholder'=>'Otomatis','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'maxlength'=>6)); ?>
                <div class="form-actions">
                        <?php 
                        if($model->isNewRecord){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('disabled'=>true,'class'=>'btn btn-primary', 'type'=>'button','style'=>'cursor:not-allowed;')); 
                        }
                        ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                        <?php 
                            if(isset($_GET['id'])){
                                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn btn-info', 'type'=>'button','onclick'=>'printKarcisFarmasi('.$model->antrianfarmasi_id.',\'PRINT\')')); 
                            }else{
                                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn btn-info', 'disabled'=>true,'type'=>'button','style'=>'cursor:not-allowed;')); 
                            }
                        ?>
                        <?php 
                            $content = $this->renderPartial($this->path_view.'tips/tipsAmbilKarcisFarmasi',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                        ?> 
                </div>
                <?php $this->endWidget(); ?>
            </fieldset>
        </div>
        <div class = "span8">
            <div class="block-tabel">
                <?php echo $this->renderPartial($this->path_view.'_tableKarcisTerakhir'); ?>
            </div>
        </div>
    </div>
    <?php echo $this->renderPartial($this->path_view.'_jsFunctions'); ?>
</div>