<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('PPPegawai-m', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
    <legend class="rim2">Informasi <b>Pegawai</b></legend>
    <div class="block-tabel">
        <h6>Tabel <b>Pegawai</b></h6>
        <div class="table-responsive">  
            <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'PPPegawai-m',
                    'dataProvider'=>$modPPPegawaiM->search(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                        'nomorindukpegawai', 
                         array(
                           'name'=>'nama_pegawai',
                           'type'=>'raw',
                           'value'=>'CHtml::link("<i class=icon-form-lihat></i>", Yii::app()->createUrl("sistemAdministrator/pegawaiM/view",array("id"=>"$data->pegawai_id")), array("rel"=>"tooltip","title"=>"Klik Untuk Melihat Data Pegawai Lebih Lanjut"))." ".CHtml::link($data->nama_pegawai, Yii::app()->createUrl("sistemAdministrator/pegawaiM/view",array("id"=>"$data->pegawai_id")))',  
                           'htmlOptions'=>array('style'=>'text-align: left')
                        ),
                        'tempatlahir_pegawai',
                        array(
                            'name'=>'tgl_lahirpegawai',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
                        ),
                        'alamat_pegawai',
                        'jeniskelamin'

                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            )); ?>
        </div>
    </div>
    <fieldset class="search-form box">
        <legend class="rim"><i class="icon-search icon-white"></i> Pencarian berdasarkan : </legend>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
                'action'=>Yii::app()->createUrl($this->route),
                'method'=>'get',
                'type'=>'horizontal',
                'focus'=>'#'.CHtml::activeId($modPPPegawaiM,'nama_pegawai'),
                'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),

        )); ?>
    
        <div class="row-fluid">
            <div class="span4">
                <?php echo $form->textFieldRow($modPPPegawaiM,'nama_pegawai',array('placeholder'=>'Ketik Nama Pegawai','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
                <?php echo $form->dropDownListRow($modPPPegawaiM,'pendidikan_nama',LookupM::getItems('kategoripegawai'), 
                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                        )); ?>
            </div>
            <div class="span4">
                <?php echo $form->dropDownListRow($modPPPegawaiM,'pangkat_id',  CHtml::listData($modPPPegawaiM->getPangkatItems(), 'pangkat_id', 'pangkat_nama'), 
                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                        )); ?>
                <?php echo $form->textFieldRow($modPPPegawaiM,'nomorindukpegawai',array('placeholder'=>'Ketik No. Induk Pegawai','class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            </div>
            <div class="span4">
                <?php echo $form->dropDownListRow($modPPPegawaiM,'kelompokpegawai_id',  CHtml::listData($modPPPegawaiM->getKelompokPegawaiItems(), 'kelompokpegawai_id', 'kelompokpegawai_nama'), 
                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                        )); ?> 
                <?php echo $form->dropDownListRow($modPPPegawaiM,'jabatan_id',  CHtml::listData($modPPPegawaiM->getJabatanItems(), 'jabatan_id', 'jabatan_nama'), 
                                                  array('class'=>'span3','empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)", 
                                                        )); ?> 
            </div>
        </div>
        <div class="form-actions">
            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="icon-search icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit')); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('informasiPegawai/index'), array('class'=>'btn btn-danger')); ?>
            <?php 
            $content = $this->renderPartial('../tips/informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
        </div>
    </fieldset>
    <?php $this->endWidget(); ?>
</div>