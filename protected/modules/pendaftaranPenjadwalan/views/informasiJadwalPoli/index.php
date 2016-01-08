<div class="white-container">
<?php
$this->widget('bootstrap.widgets.BootAlert');
?>
<legend class="rim2">Informasi <b>Jadwal Poliklinik</b></legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'carijadwal-form',
        'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'focus'=>'#RDJadwaldokterM_jadwaldokter_hari',
                'method'=>'GET',
                'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
));

Yii::app()->clientScript->registerScript('cariPasien', "
$('#carijadwal-form').submit(function(){
        $.fn.yiiGridView.update('pencarianjadwal-grid', {
                data: $(this).serialize()
        });
        return false;
});
");?>
<div class='block-tabel'>
    <h6>Tabel Jadwal Poliklinik</h6>
    <div class='table-responsive'>
<?php
$timePickerUpdate = <<< timePicker
jQuery('.jam').timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'onSelect':function(){},'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'changeMonth':true,'showAnim':'fold'}));
timePicker;
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id'=>'pencarianjadwal-grid',
	'dataProvider'=>$model->searchInformasi(),
//                'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",

                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                   'ruangan.ruangan_nama',
                   array(
                     'header'=>'Senin',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Senin\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Selasa',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Selasa\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Rabu',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Rabu\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Kamis',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Kamis\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Jumat',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Jumat\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Sabtu',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Sabtu\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                   array(
                     'header'=>'Minggu',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_formHari\',array(\'ruangan_id\'=>$data->ruangan_id,\'hariCari\'=>\'Minggu\'),true)',
                     'htmlOptions'=>array('style'=>"width:200px;"),
                   ),
                    
            ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                           '.$timePickerUpdate.' 
                            }',
    ));
     

?>
</div>
</div>
<fieldset class='box'>
     <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
    <table width="100%">
        <tr>
            <td>
                <?php //echo $form->dropDownListRow($model,'hari', CustomFunction::getNamaHari() ,array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);",'empty'=>'- Pilih -')); ?>
                <div class="control-group ">
                <?php echo CHtml::activeLabel($model,'ruangan_id', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(PPPendaftaranT::model()->getRuanganItems(Params::INSTALASI_ID_RJ), 'ruangan_id', 'ruangan_nama') ,
                                                      array('empty'=>'-- Pilih --',
                                                            'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                   
                </div>
            </div>
            </td>
            <td>
                <div class="control-group ">
                <?php echo CHtml::activeLabel($model,'jammulai', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jammulai',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?> <?php echo $form->error($model, 'jammulai'); ?>
                   
                </div>
                </div>
            </td>
            <td>
            <div class="control-group ">
                <?php echo CHtml::activeLabel($model,'jamtutup', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'jamtutup',
                                            'mode'=>'time',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,
                                                                 'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                                 ),
                    )); ?><?php echo $form->error($model, 'jamtutup'); ?>
                    
                </div>
            </div>
            </td>
        </tr>
    </table>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class'=>'btn btn-danger',
                                        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('index').'";} ); return false;'));  ?>
        <?php 
            $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>
</fieldset>
<?php $this->endWidget(); ?>
</div>