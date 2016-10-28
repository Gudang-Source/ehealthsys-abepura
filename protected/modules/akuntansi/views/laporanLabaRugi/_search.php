<legend class="rim"><i class='icon-white icon-search'></i> Pencarian</legend>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
	'action' => Yii::app()->createUrl($this->route),
	'method' => 'get',
	'type' => 'horizontal',
	'id' => 'searchLaporan',
	'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
		));
?>

<div class="row-fluid">
	<div class="span4">
		 <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'bank',
                            'slide'=>false,
                            'content'=>array(
                            'content3'=>array(
                                'header'=>'Tahun',
                                'isi'=> CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')).                                                                
                                             '<table><tr><td>'.
                                                           $form->dropDownList($model, 'thn_awal', CustomFunction::getTahun(null, null), array('onkeypress' => "return $(this).focusNextInputField(event)", 'prompt'=>'--Pilih--'))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),       
                            )); ?>	
			

		 <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'segmen',
                            'slide'=>false,
                            'content'=>array(
                            'content3'=>array(
                                'header'=>'Segmen',
                                'isi'=> CHtml::checkBox('pilihSemuaSg', false, array('onclick' => 'pilihSemuaSegmen();pilihSegmen();')).'Pilih Semua <br\>                                             
                                            <table id="cbSegmen">                                            
                                            <tr>
                                                    <td>'.
                                                           CHtml::checkBoxList('Segmen','',array('1'=>'Segmen 1','2'=>'Segmen 2','3'=>'Segmen 3','4'=>'Segmen 4','5'=>'Segmen 5'),array('separator' => '    ','onClick'=>'Segmen(this);', 'onkeypress' => "return $(this).focusNextInputField(event)"))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),       
                            )); ?>	
                            
	</div>
	<div class="span8">
		 <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                            'id'=>'segmen',
                            'slide'=>false,
                            'content'=>array(
                            'content3'=>array(
                                'header'=>'Bulan',
                                'isi'=> CHtml::checkBox('pilihSemua', false, array('onclick' => 'pilihSemuaBulan();')).'Pilih Semua <br\>                                             
                                            <table id="cbBulan">                                            
                                            <tr>
                                                    <td>'.
                                                           Chtml::activecheckBoxList($model, 'bulan', CustomFunction::getBulan(null, null), array('separator' => '    ', 'onkeypress' => "return $(this).focusNextInputField(event)"))
                                                    .'</td>
                                            </tr>
                                            </table>',            
                                'active'=>true,
                                    ),
                            ),       
                            )); ?>
				
	</div>
</div>
<!--<table width='100%'>
    <tr>
        <td>
        <div class="control-group ">
<?php //echo $form->labelEx($model, 'Periode Awal', array('class' => 'control-label')); ?>
            <div class="controls">
<?php
/*$this->widget('MyDateTimePicker', array(
	'model' => $model,
	'attribute' => 'tgl_awal',
	'mode' => 'date',
	'options' => array(
		'dateFormat' => Params::DATE_FORMAT,
	),
	'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)",
		'class' => 'dtPicker3',
	),
));*/
?> 
            </div>
        </div>
        </td>
        <td>
        <div class="control-group ">
<?php //echo $form->labelEx($model, 'sampai', array('class' => 'control-label')); ?>
            <div class="controls">
<?php
/*$this->widget('MyDateTimePicker', array(
	'model' => $model,
	'attribute' => 'tgl_akhir',
	'mode' => 'date',
	'options' => array(
		'dateFormat' => Params::DATE_FORMAT,
	),
	'htmlOptions' => array('readonly' => true,
		'onkeypress' => "return $(this).focusNextInputField(event)",
		'class' => 'dtPicker3',
	),
));*/
?> 
            </div>
        </div>
        </td>
    </tr>
</table>-->

<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>            
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/Index'), array('class' => 'btn btn-danger',
		'onclick' => 'return refreshForm(this);'));
	?>
</div>
<?php
$this->endWidget();
?>
<script>
	function pilihSemuaBulan() {
		if ($("#pilihSemua").is(':checked')) {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#cbBulan").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}
    
    function pilihSemuaSegmen() {
		if ($("#pilihSemuaSg").is(':checked')) {
			$("#cbSegmen").find("input[type=\'checkbox\']").attr("checked", "checked");
		} else {
			$("#cbSegmen").find("input[type=\'checkbox\']").attr("checked", false);
		}
	}
	$(document).ready(function(){
        <?php if (isset($_GET['caraPrint'])) { ?>
            
        <?php } else { ?>
            $("#pilihSemuaSg").attr('checked', "checked");
            pilihSemuaSegmen();
        <?php } ?>
    });
    pilihSemuaBulan();
</script>