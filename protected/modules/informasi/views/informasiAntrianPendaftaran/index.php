<legend class="rim2">Informasi Antrian Pendaftaran</legend>
<?php
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#search').submit(function(){
	$.fn.yiiGridView.update('ininformasiAntrianPendaftaran-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim">Tabel Antrian Pendaftaran</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'ininformasiAntrianPendaftaran-grid',
	'dataProvider'=>$modAntrianPendaftaran->searchAntrian(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//        'mergeColumns'=>array('no_urutantri'),
	'columns'=>array(
            'tglantrian',
            array(
              'header'=>'Loket',
              'value'=>'isset($data->loket->loket_nama)? $data->loket->loket_nama : " "',
            ),
            array(
              'header'=>'Loket (singkatan)',
              'value'=>'isset($data->loket->loket_singkatan)? $data->loket->loket_singkatan : " ")',
            ),
            'noantrian',
            array(
              'name'=>'statuspasien',
              'value'=>'(empty($data->pendaftaran_id)? "Antri" : "Sudah Mendaftar / ".$data->pendaftaran->no_pendaftaran)',
            ),
            array(
              'header'=>'Karcis',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\"icon-print\"></i>", "onclick=printKarcis(\'$data->antrian_id\')", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))." ".CHtml::link("Print", "javascript:printKarcis(\'$data->antrian_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint karcis"))',
              'htmlOptions'=>array('style'=>'text-align:center;'),
            ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>


<legend class="rim">Pencarian</legend> 
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'search',
        'type'=>'horizontal',        
        'focus'=>'#INPasienmasukpenunjangV_instalasi_id',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<?php echo $form->errorSummary($modAntrianPendaftaran); ?>
    <div class="span5">
        <div class="control-group"> 
        <?php echo CHtml::label('Loket','loket_id',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php echo $form->dropDownList($modAntrianPendaftaran,'loket_id', CHtml::listData($modAntrianPendaftaran->getLoket(), 'loket_id', 'loket_nama'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3'));
            ?>
            </div>
        </div>
    </div>
    <div class="span5">
    <?php
        echo $form->textFieldRow($modAntrianPendaftaran, 'noantrian', array('placeholder'=>'Ketik No. Antrian','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50));
    ?>
    </div>
<div class="form-group">
    <div class="span12">
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),
                                                   array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                                                   array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
            <?php 
               $content = $this->renderPartial('../tips/informasiAntrianPendaftaran',array(),true);
               $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>

<script type="text/javascript">
    function printKarcis(antrian_id){
        window.open('<?php echo $this->createUrl('printKarcis'); ?>'+'&antrian_id='+antrian_id,'printwin','left=100,top=100,width=860,height=480');
    }
</script>