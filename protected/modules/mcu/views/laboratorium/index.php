<style type="text/css">
    .nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > li > a{
        cursor: pointer;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/jquery.tiler.js'); ?>
<?php
$this->breadcrumbs=array(
	'Laboratorium',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'laboratorium-mcu-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
						 'onsubmit'=>'return requiredCheck(this);'),
)); ?>

<div id='form-hasilpemeriksaanlab'>
    <fieldset class="box">
        <legend class="rim">Hasil Pemeriksaan Laboratorium Klinik</legend>
        <div class="row-fluid">
            <div class="span6">
                <?php echo $form->hiddenField($modHasilPemeriksaan, 'hasilpemeriksaanlab_id',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'nohasilperiksalab', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modHasilPemeriksaan, 'nohasilperiksalab',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'statusperiksahasil', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php echo $form->textField($modHasilPemeriksaan, 'statusperiksahasil',array('readonly'=>true,'onkeyup'=>"return $(this).focusNextInputField(event);"));?>
                    </div>
                </div>
            </div>
            <div class="span6">    
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'tglhasilpemeriksaanlab', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $modHasilPemeriksaan->tglhasilpemeriksaanlab = (!empty($modHasilPemeriksaan->tglhasilpemeriksaanlab) ? date("d/m/Y H:i:s",strtotime($modHasilPemeriksaan->tglhasilpemeriksaanlab)) : null);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'tglhasilpemeriksaanlab',
                                'mode'=>'datetime',
                                'options'=> array(
    //                                'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                        )); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'tglpengambilanhasil', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $modHasilPemeriksaan->tglpengambilanhasil = (!empty($modHasilPemeriksaan->tglpengambilanhasil) ? date("d/m/Y H:i:s",strtotime($modHasilPemeriksaan->tglpengambilanhasil)) : null);
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'tglpengambilanhasil',
                                'mode'=>'datetime',
                                'options'=> array(
    //                                'dateFormat'=>Params::DATE_FORMAT,
                                    'showOn' => false,
    //                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)",),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row-fluid"> 
            <table id="form-pemeriksaan-mcu" class="table table-condensed table-bordered">
                <thead>
                    <th>No.</th>
                    <th>Kelompok Pemeriksaan</th>
                    <th width="30%">Detail Pemeriksaan</th>
                    <th>Hasil Pemeriksaan</th>
                    <th>Nilai Rujukan</th>
                    <th>Satuan</th>
                    <th>Metode</th>
                    <th>Keterangan</th>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'catatanlabklinik', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'catatanlabklinik',
                                'toolbar'=>'mini','height'=>'150px'));?>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <?php echo $form->labelEx($modHasilPemeriksaan, 'kesimpulan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php $this->widget('ext.redactorjs.Redactor',array(
                                'model'=>$modHasilPemeriksaan,
                                'attribute'=>'kesimpulan',
                                'toolbar'=>'mini','height'=>'150px'));?>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>
<!-- LNG-990
	<div class="formInputTab">
    <?php // echo $form->errorSummary($modKirimKeUnitLain); ?>
	<table id="form-pemeriksaan-mcu" class="table table-bordered table-condensed">
		<thead>
			<tr>
				<th>NAMA PEMERIKSAAN</th>
				<th>HASIL PEMERIKSAAN</th>
				<th>NILAI RUJUKAN</th>
				<th>SATUAN</th>
				<th>METODE</th>
				<th>HASIL LABORATORIUM</th>
			</tr>
		</thead>
		<tbody>

		</tbody>
	</table>
</div>-->
<div class="form-actions">
	<?php 
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','type'=>'submit', 'onkeypress'=>'formSubmit(this,event)'))."&nbsp;";
		echo CHtml::link(Yii::t('mds', '{icon} Print Hasil', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printHasil();return false",'disabled'=>FALSE  )).'&nbsp;';
	?>
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view_mcu.'_jsFunctions', array('modPendaftaran'=>$modPendaftaran,'modKirimKeUnitLain'=>$modKirimKeUnitLain,'modHasilPemeriksaan'=>$modHasilPemeriksaan)); ?>
