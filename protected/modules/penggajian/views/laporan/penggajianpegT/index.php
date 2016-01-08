<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#laporan-search').submit(function(){
	$.fn.yiiGridView.update('laporan-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Laporan <b>Penggajian</b></legend>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'laporan-search',
            'type'=>'horizontal',
        )); ?>
        <table width="100%">
            <tr>
                <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tgl_awal', array('class' => 'control-label')); ?>
                    <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_awal',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'changeYear'=>true,
                                                'changeMonth'=>true,
                                                'yearRange'=>'-70y:+4y',
                                                'maxDate'=>'d',
                                                'showAnim'=>'fold',
                                                'timeText'=>'Waktu',
                                                'hourText'=>'Jam',
                                                'minuteText'=>'Menit',
                                                'secondText'=>'Detik',
                                                'showSecond'=>true,
                                                'timeFormat'=>'hh:mm:ss',


                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                  'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                  'class'=>'dtPicker3',
                                             ),
                    )); ?> 
                    </div>
                </div>
                <?php echo $form->textFieldRow($model,'nama_pegawai',array('class'=>'span3','maxlength'=>30)); ?>
                </td>
                <td>
                       <div class="control-group ">
                            <?php echo $form->labelEx($model, 'tgl_akhir', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_akhir',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'changeYear'=>true,
                                                        'changeMonth'=>true,
                                                        'yearRange'=>'-70y:+4y',
                                                        'maxDate'=>'d',
                                                        'showAnim'=>'fold',
                                                        'timeText'=>'Waktu',
                                                        'hourText'=>'Jam',
                                                        'minuteText'=>'Menit',
                                                        'secondText'=>'Detik',
                                                        'showSecond'=>true,
                                                        'timeFormat'=>'hh:mm:ss',

                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,
                                                                          'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                          'class'=>'dtPicker3',
                                                     ),
                            )); ?> 
                            </div>
                        </div>
                            <?php echo $form->dropDownListRow($model,'jabatan_id',CHtml::listData($model->getJabatanItems(),'jabatan_id','jabatan_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
                </td>
            </tr>
        </table>
	<div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                       Yii::app()->createUrl($this->module->id.'/Laporan/laporanPenggajian'), 
                       array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
	</div>
    </fieldset>
    <?php
    $this->endWidget();
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Penggajian</b></h6>
        <?php $this->renderPartial('penggajian.views.laporan.penggajianpegT/_table',array('model'=>$model)); ?>
        <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/PrintLaporanPenggajian');
        $url = "";//?
        $this->renderPartial('penggajian.views.laporan._footerWithoutgrafik', array('urlPrint'=>$urlPrint, 'url'=>$url));
        ?>
    </div>
</div>