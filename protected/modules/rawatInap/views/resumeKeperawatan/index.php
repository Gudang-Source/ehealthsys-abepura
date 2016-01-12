<div class="white-container">
    <legend class="rim2">Resume <b>Keperawatan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>
    <?php 
        if(isset($_GET['sukses'])){
            Yii::app()->user->setFlash('success',"Data Resume Keperawatan berhasil disimpan !");
        }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'pemakaianbahp-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
            'focus'=>'#no_pendaftaran',
    )); ?>
    
    <fieldset class="box" id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan,'modPegawai'=>$modPegawai,'modPasienMasukKamar'=>$modPasienMasukKamar)); ?>
        </div>
    </fieldset>
    <fieldset class="box" id="form-dataresume">
        <legend class='rim'>Resume Keperawatan</legend>
        <div class="row-fluid">
            <?php $this->renderPartial($this->path_view.'_formResumeMedis',array('modKunjungan'=>$modKunjungan,'modResumeKeperawatan'=>$modResumeKeperawatan)); ?>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
            <?php 
                if($modKunjungan->isNewRecord){
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);', 'enabled'=>'true'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->module->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
                    echo "&nbsp;";
                }else{
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);', 'disabled'=>'true')); 
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->module->id.'/index'), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
                    echo "&nbsp;";
                    echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print();return false", 'enabled'=>'true'));
                    echo "&nbsp;";
                }


                $content = $this->renderPartial($this->path_view.'tips/tipsPemakaianBahan',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
            ?> 
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'modResumeKeperawatan'=>$modResumeKeperawatan,'modPegawai'=>$modPegawai,'modPasienMasukKamar'=>$modPasienMasukKamar)); ?>
