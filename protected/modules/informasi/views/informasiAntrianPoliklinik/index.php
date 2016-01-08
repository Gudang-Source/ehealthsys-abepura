<div class="white-container">
    <legend class="rim2">Informasi <b>Antrian Poliklinik</b></legend> 
    <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('#search').submit(function(){
            $.fn.yiiGridView.update('ininformasiAntrianPoliklinik-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Antrian Poliklinik</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
            'id'=>'ininformasiAntrianPoliklinik-grid',
            'dataProvider'=>$modInfoAntrianPoli->searchRJ(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'mergeColumns'=>array('no_urutantri'),
            'columns'=>array(
                'no_urutantri',
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
                  'value'=>'CHtml::link("<i class=\"icon-print\"></i>", "javascript:void(0);", array("onclick"=>"printStatus(\'$data->pendaftaran_id\')","rel"=>"tooltip","title"=>"Klik untuk mengeprint status pasien"))." ".CHtml::link("Print", "javascript:printStatus(\'$data->pendaftaran_id\');", array("rel"=>"tooltip","title"=>"Klik untuk mengeprint status pasien"))',
                  'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend> 
        <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
        <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'id'=>'search',
            'type'=>'horizontal',
            'focus'=>'#INInfokunjunganrjV_ruangan_id',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        )); ?>
        <?php echo $form->errorSummary($modInfoAntrianPoli); ?>
        <div class="span5">
            <div class="control-group">
                <?php echo $form->labelEx($modInfoAntrianPoli,'ruangan_id <span class="required">*</span>', array('class'=>'control-label')); ?>
                <div class="controls">      
                <?php
                      echo $form->dropDownList($modInfoAntrianPoli,'ruangan_id', CHtml::listData($modInfoAntrianPoli->getRuangan(), 'ruangan_id', 'ruangan_nama'), array('class'=>'span3',
                                                                                    'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                                                    'ajax'=>array(
                                                                                        'type'=>'POST',
                                                                                        'url'=>$this->createUrl('SetDropdownPegawai',array('encode'=>false,'model_nama'=>get_class($modInfoAntrianPoli))),
                                                                                        'update'=>'#INInfokunjunganrjV_pegawai_id',))); 
                ?>
                </div>
            </div>
            <div class="control-group">    
                <?php echo CHtml::label('Dokter','pegawai_id', array('class'=>'control-label')); ?>
                <div class="controls">
                <?php
                      echo $form->dropDownList($modInfoAntrianPoli,'pegawai_id', array(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); 
                ?>
                </div>
            </div>
        </div>
        <div class="span5">
                <?php echo $form->textFieldRow($modInfoAntrianPoli, 'no_pendaftaran', array('placeholder'=>'Ketik No. Pendaftaran','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50)); ?>
                <?php echo $form->textFieldRow($modInfoAntrianPoli, 'no_rekam_medik', array('placeholder'=>'Ketik No. Rekam Medik','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50)); ?>
        </div>
        <div class="span5">
                <?php echo $form->textFieldRow($modInfoAntrianPoli, 'nama_pasien', array('placeholder'=>'Ketik Nama Pasien','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)",'maxlength'=>50)); ?>
                <?php echo $form->dropDownListRow($modInfoAntrianPoli,'statusperiksa',CHtml::listData($modInfoAntrianPoli->getStatusPeriksa(), 'lookup_value', 'lookup_name'),array('empty'=>'-- Pilih --','class'=>'span3','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
</div>
<script type="text/javascript">
    function printStatus(pendaftaran_id){
        window.open('<?php echo $this->createUrl('printStatus'); ?>'+'&pendaftaran_id='+pendaftaran_id,'printwin','left=100,top=100,width=860,height=480');
    }
    function refreshDropdownPegawai(){
        jQuery.ajax({
            'type':'POST',
            'url': '<?php echo $this->createUrl('SetDropdownPegawai',array('model_nama'=>'INInfokunjunganrjV')); ?>',
            'cache':false,
            'data':jQuery("#search").serialize(),
            'success':function(html){jQuery("#<?php echo CHtml::activeId($modInfoAntrianPoli,'pegawai_id')?>").html(html)}});
        return false;
    }
    
    $(document).ready(function(){
        refreshDropdownPegawai();
    })
</script>
   