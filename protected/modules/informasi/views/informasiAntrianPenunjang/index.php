<legend class="rim2">Informasi Antrian Masuk Penunjang</legend>

<?php
    Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#search').submit(function(){
	$.fn.yiiGridView.update('inAntrianPenunjang-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<legend class="rim">Tabel Antrian Masuk Penunjang</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
	'id'=>'inAntrianPenunjang-grid',
	'dataProvider'=>$modAntrianPenunjang->searchMP(),
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'mergeColumns'=>array('no_urutperiksa'),
	'columns'=>array(
            'no_urutperiksa',
            'no_pendaftaran',
            'ruangan_nama',
            array(
              'name'=>'nama_pegawai',
              'value'=>'(isset($data->gelarbelakang_nama)?$data->nama_pegawai.", ".$data->gelarbelakang_nama : $data->nama_pegawai)',
            ),
            'no_rekam_medik',
            'nama_pasien',
            'statusperiksa',
            array(
              'header'=>'Status Pasien',
              'type'=>'raw',
              'value'=>'CHtml::link("<i class=\"icon-print\"></i>", "onclick=printStatus(\'$data->pendaftaran_id\',\'$data->instalasi_id\',\'$data->pasienmasukpenunjang_id\')", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint status pasien"))." ".CHtml::link("Print", "javascript:printStatus(\'$data->pendaftaran_id\',\'$data->instalasi_id\',\'$data->pasienmasukpenunjang_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint status pasien"))',
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
<?php echo $form->errorSummary($modAntrianPenunjang); ?>
    <div class="span5">
        <div class="control-group"> 
        <?php echo CHtml::label('Instalasi','instalasi_id',array('class'=>'control-label')); ?>
            <div class="controls">
            <?php echo $form->dropDownList($modAntrianPenunjang,'instalasi_id', CHtml::listData($modAntrianPenunjang->getInstalasi(), 'instalasi_id', 'instalasi_nama'), array(
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3',
                                                                                'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($modAntrianPenunjang))),
                                                                                    'update'=>'#INPasienmasukpenunjangV_ruangan_id',))); 
            ?>
            </div>
        </div>
        <div class="control-group">
        <?php echo CHtml::label('Ruangan <span class="required">*</span>','ruangan_id', array('class'=>'control-label')); ?>
            <div class="controls">
            <?php echo $form->dropDownList($modAntrianPenunjang,'ruangan_id', array(), array('class'=>'span3',
                                                                                'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                'ajax'=>array(
                                                                                    'type'=>'POST',
                                                                                    'url'=>$this->createUrl('SetDropdownPegawai',array('encode'=>false,'model_nama'=>get_class($modAntrianPenunjang))),
                                                                                    'update'=>'#INPasienmasukpenunjangV_pegawai_id',))); 
            ?>
            </div>
        </div>
        <div class="control-group">
        <?php echo CHtml::label('Dokter', 'pegawai_id',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php
                      echo $form->dropDownList($modAntrianPenunjang,'pegawai_id',array(),array('empty'=>'-- Pilih --','class'=>'span3',
                                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)", "onFocus"=>"changeDropDownPegawai()",
                                                                                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="span5">
    <?php
        echo $form->textFieldRow($modAntrianPenunjang, 'no_pendaftaran', array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50));
        echo $form->textFieldRow($modAntrianPenunjang, 'no_rekam_medik', array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50));
    ?>
    </div>
    <div class="span5">
    <?php
        echo $form->textFieldRow($modAntrianPenunjang, 'nama_pasien', array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50));
        echo $form->dropDownListRow($modAntrianPenunjang,'statusperiksa',CHtml::listData($modAntrianPenunjang->getStatusPeriksa(), 'lookup_value', 'lookup_name'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)"));
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
               $content = $this->renderPartial('../tips/informasiAntrian',array(),true);
               $this->widget('UserTips',array('type'=>'admin','content'=>$content));
            ?>
        </div>
    </div>
</div>


<?php $this->endWidget(); ?>


<script type="text/javascript">
    function printStatus(pendaftaran_id,instalasi_id,pasienmasukpenunjang_id){
        window.open('<?php echo $this->createUrl('printStatus'); ?>'+'&pendaftaran_id='+pendaftaran_id+'&instalasi_id='+instalasi_id+'&pasienmasukpenunjang_id='+pasienmasukpenunjang_id,'printwin','left=100,top=100,width=860,height=480');
    }
    
    function refreshDropdownRuangan(){
        jQuery.ajax({
            'type':'POST',
            'url':'<?php echo $this->createUrl('SetDropdownRuangan',array('model_nama'=>'INPasienmasukpenunjangV')); ?>',
            'cache':false,
            'data':jQuery("#search").serialize(),
            'success':function(html){
                    jQuery("#<?php echo CHtml::activeId($modAntrianPenunjang,'ruangan_id');?>").html(html);        
            }});
        return false;
    }
    
    function changeDropDownPegawai(){
        jQuery.ajax({
            'type':'POST',
            'url': '<?php echo $this->createUrl('SetDropdownPegawai',array('model_nama'=>'INPasienmasukpenunjangV')); ?>',
            'cache':false,
            'data':jQuery("#search").serialize(),
            'success':function(html){
                jQuery("#<?php echo CHtml::activeId($modAntrianPenunjang,'pegawai_id')?>").html(html);
            }});
        return false;
    }
    
    $(document).ready(function(){
        refreshDropdownRuangan();
    })
</script>
   
   