<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB ?>

<legend class="rim2">Resume Dokter</legend>
<?php 
    if(isset($_GET['sukses'])){
        Yii::app()->user->setFlash('success',"Data pemakaian Bahan berhasil disimpan !");
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
    
    <fieldset id="form-datakunjungan">
        <legend class="rim"><span class='judul'>Data Kunjungan </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>
        <div class="row-fluid box">
            <?php $this->renderPartial('_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <fieldset id="form-tambahobatalkes">
        <legend class='rim'>Resume Medis - Dokter</legend>
        <div class="row-fluid box">
            <?php $this->renderPartial('_formResumeDokter',array('modKunjungan'=>$modKunjungan)); ?>
        </div>
    </fieldset>
    <div class="row-fluid">
        <div class="form-actions">
                <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'formSubmit(this,event);', 'onkeypress'=>'formSubmit(this,event);')); 

                    echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->module->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                    'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));
					
//                    if($modKunjungan->isNewRecord){
//                        echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info', 'disabled'=>'true'));
//                    }else{
//                        echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(".$modKunjungan->pendaftaran_id.");return false"));
                        echo CHtml::link(Yii::t('mds', '{icon} Print Resume', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"print(33210);return false"));
//                    }


                    $content = $this->renderPartial('tips/tipsPemakaianBahan',array(),true);
                    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                ?> 
        </div>
    </div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial('_jsFunctions', array('modKunjungan'=>$modKunjungan)); ?>
