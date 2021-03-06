<div id="divSearch-form">
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'informasi-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'instalasi_id'),
)); ?> 
<fieldset class="box">
    <legend class="rim">Pencarian Obat Alkes</legend>
    <div class="row-fluid">
        <div class="span4">
            <?php /* echo $form->dropDownListRow($model,'instalasi_id', $instalasiAsals, 
                    array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                            'ajax'=>array('type'=>'POST',
                                        'url'=>$this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                        'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                            ))); */ ?>
            <?php // echo $form->dropDownListRow($model,'ruangan_id',$ruanganAsals,array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            <div class = "control-group">
                <?php echo Chtml::label('Jenis Kelompok', 'jnskelompok',array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model,'jnskelompok', LookupM::getItems('jnskelompok'),array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'jenisobatalkes_id',  
                    CHtml::listData(JenisobatalkesM::model()->findAll(array(
                        'condition'=>'jenisobatalkes_aktif = true',
                        'order'=>'jenisobatalkes_nama',
                    )), 'jenisobatalkes_id', 'jenisobatalkes_nama'), 
                    array('empty'=>'-- Pilih --', 'class'=>'span3'));?>
            <?php echo $form->dropDownListRow($model,'obatalkes_kategori',  ObatAlkesKategori::items(),array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
            <?php echo $form->dropDownListRow($model,'obatalkes_golongan',  ObatAlkesGolongan::items(),array('empty'=>'-- Pilih --','class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
        <div class="span4">
            
            <?php echo $form->textFieldRow($model,'obatalkes_kode',array('class'=>'span3 kode-dtd all-caps','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder' => 'Ketikkan Kode Obat & Alkes')); ?>
            <?php echo $form->textFieldRow($model,'obatalkes_nama',array('class'=>'span3 custom-only all-caps','onkeyup'=>"return $(this).focusNextInputField(event)", 'placeholder' => 'Ketikkan Nama Obat & Alkes')); ?>
        </div>
        <div class="span4">
            
            <?php // echo $form->textFieldRow($model,'satuankecil_nama',array('class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
//                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));echo '&nbsp;'; ?><?php
           $content = $this->renderPartial('gudangFarmasi.views.tips.informasiStokObatAlkesRJ',array(),true);
           $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</fieldset>
    <?php $this->endWidget(); ?>
</div>
