<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB  ?>
<div class="white-container">
    <legend class="rim2">Pergantian <b>Kacamata</b></legend>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gantikacamata-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
        'focus' => '#cari_nomorindukpegawai',
    ));
    ?>
    <?php
    if (isset($_GET['sukses'])) {
        Yii::app()->user->setFlash('success', "Data pengambilan kacamata berhasil disimpan !");
    }
    ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
    <fieldset class="box" id="form-pasien">
        <legend class="rim"><span class='judul'>Data Pasien</span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>', array('class' => 'btn btn-danger btn-mini', 'onclick' => 'setPegawaiBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span></legend>
        <div class="row-fluid">    
<?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPegawai' => $modPegawai)); ?>
        </div>
    </fieldset>
    <fieldset>	
        <div class="row-fluid">
            <div class="block-tabel">
                <h6>Ukuran <b>Visus Mata</b></h6>
                <div id="form-tindakanpemeriksaan-diluar-paket" style="">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2"><center>VOD</center></th>
                        <th colspan="2"><center>VOS</center></th>
                        <th rowspan="2"><center>ADD</center></th>
                        </tr>						
                        <tr>
                            <th>Spheris</th>
                            <th>Cylindrys</th>
                            <th>Spheris</th>
                            <th>Cylindrys</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php echo $this->renderPartial($this->path_view . '_rowDataKacamata', array('model' => $model)); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <fieldset id="form-gantikacaamta"> 
            <div class="row-fluid">
                <?php $this->renderPartial($this->path_view . '_formGantiKacamata', array('form' => $form, 'model' => $model, 'modPegawai' => $modPegawai)); ?>
            </div>
        </fieldset>
        <div class="row-fluid">
            <div class="form-actions">
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onkeypress' => 'formSubmit(this,event)'))."&nbsp";
					echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','disabled'=>true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'))."&nbsp";
					echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','onclick'=>'print(\'PRINT\')','disabled'=>false));
                }
                ?>
                <?php
                echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                    'onclick' => 'return refreshForm(this);'));
                ?>
                <?php
                $content = $this->renderPartial($this->path_view . 'tips/tipsPergantianKacamata', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?> 
            </div>
        </div>
    </fieldset>
<?php $this->endWidget(); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPegawai' => $modPegawai)); ?>