<div class="white-container">
    <legend class="rim2">Informasi Rincian <b>Tagihan Pasien</b></legend>
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rjrinciantagihanpasien-v-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php 
    $module  = $this->module->name; 
    $controller = $this->id;
    ?>
    <div class="block-tabel">
        <h6>Tabel Rincian <b>Tagihan Pasien</b></h6>
        <?php echo $this->renderPartial('rawatJalan.views.rinciantagihanpasienV._tableRinciantagihan', array('model'=>$model));  ?> 
    </div>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'caripasien-form',
        'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
                    'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
    )); ?>

    <div class="row-fluid">
        <fieldset class="box">
            <?php $this->renderPartial('rawatJalan.views.rinciantagihanpasienV._search',array(
                'model'=>$model, 'form'=>$form)); ?>
            <div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
                     'type' => 'GET', 
                     'url' => array("/".$this->route), 
                     'update' => '#rjrinciantagihanpasien-v-grid',
                     'beforeSend' => 'function(){
                                          $("#rjrinciantagihanpasien-v-grid").addClass("animation-loading");
                                      }',
                     'complete' => 'function(){
                                          $("#rjrinciantagihanpasien-v-grid").removeClass("animation-loading");
                                      }',
                 ))); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
                <?php  
                    $content = $this->renderPartial('rawatJalan.views.tips.informasiRincianTagihanPasien',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
        </fieldset>
    </div>
    <?php $this->endWidget(); ?>
    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogRincian',
        'options' => array(
            'title' => 'Rincian Tagihan Pasien',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 550,
            'resizable' => false,
        ),
    ));
    ?>
    <iframe name='frameRincian' width="100%" height="100%"></iframe>
    <?php $this->endWidget(); ?>
</div>