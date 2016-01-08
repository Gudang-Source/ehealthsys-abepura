<?php
$sukses = null;
if(isset($_GET['sukses'])){
    $sukses = $_GET['sukses'];
}
if($sukses > 0) 
    Yii::app()->user->setFlash('success',"Data berhasil disimpan !");
$this->widget('bootstrap.widgets.BootAlert');
?> 
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'kppresensi-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#namapegawai',
)); ?>
<legend class="rim2"><b>Presensi</b></legend>	
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php echo $form->errorSummary($model); ?>
<fieldset class="box">
    <legend class="rim">Data Pegawai</legend>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
    <?php $this->renderPartial('_pegawai', array('model'=>$modPegawai, 'form'=>$form)); ?>        
</fieldset>
<fieldset class="box row-fluid">
    <legend class="rim">Data Presensi</legend>
    <div class="span4">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'tglpresensi', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php   
                $model->tglpresensi = (!empty($model->tglpresensi) ? date("d/m/Y",strtotime($model->tglpresensi)) : null);
                $this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglpresensi',
                                        'mode'=>'date',
                                        'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                            'showOn' => false,
                                            'maxDate' => 'd',
                                            'yearRange'=> "-150:+0",
                                        ),
                                        'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                                        ),
                )); ?>
                <?php echo $form->error($model, 'tglpresensi'); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo $form->labelEx($model,'statuskehadiran_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                    echo $form->dropDownList($model,'statuskehadiran_id', CHtml::listData(StatuskehadiranM::model()->findAll('statuskehadiran_aktif = true order by statuskehadiran_id asc'), 'statuskehadiran_id', 'statuskehadiran_nama'), array('style'=>'width:100px','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)", "empty"=>'-- Pilih --')); 
                    echo $form->dropDownList($model,'statusscan_id', CHtml::listData(StatusscanM::model()->findAll('statusscan_aktif = true'), 'statusscan_id', 'statusscan_nama'), array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",'style'=>'width:100px', "empty"=>'-- Pilih --'));
                ?>
            </div>
        </div>
        <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
    <div class="span4">        
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jamkerjamasuk', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php   
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'jamkerjamasuk',
                    'mode'=>'time',
                    'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                    ),
                    'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 timemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
            <?php echo $form->error($model, 'jamkerjamasuk'); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'jamkerjapulang', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php   
                $this->widget('MyDateTimePicker',array(
                    'model'=>$model,
                    'attribute'=>'jamkerjapulang',
                    'mode'=>'time',
                    'options'=> array(
//                                            'dateFormat'=>Params::DATE_FORMAT,
                        'showOn' => false,
                    ),
                    'htmlOptions'=>array('placeholder'=>'00:00:00','class'=>'dtPicker2 timemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            )); ?>
            <?php echo $form->error($model, 'jamkerjapulang'); ?>
            </div>
        </div>
    </div>
    <div class="span4">
        <?php echo $form->textFieldRow($model,'terlambat_mnt',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        <?php echo $form->textFieldRow($model,'pulangawal_mnt',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
    </div>
</fieldset>
    <div class="form-actions">
        <?php 
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['presensi_id'])) ? true : ($sukses > 0) ? true : false;; 
        ?>
        <?php $disablePrint = ($disableSave) ? false : true; ?>
        <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onclick'=>'return cekDokter();','onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
             ?>
        <?php if(!isset($_GET['frame'])){
            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                $this->createUrl($this->id.'/create'), 
                array('class'=>'btn btn-danger',
                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        } ?>
        <?php
                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        ?>
        <?php
            $content = $this->renderPartial('tips/transaksi_presensi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>

<?php $this->endWidget(); ?>
<script>
function konfirmasi(){
  location.reload();     
}
/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var presensi_id = '<?php echo isset($model->presensi_id) ? $model->presensi_id : null ?>';
    window.open('<?php echo $this->createUrl('printPresensi'); ?>&presensi_id='+presensi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>