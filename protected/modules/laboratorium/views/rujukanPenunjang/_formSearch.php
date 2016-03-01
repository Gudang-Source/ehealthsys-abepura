<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(	
	'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type'=>'horizontal',
        'id'=>'search-penunjangrujukan-form',
        'focus'=>'#'.CHtml::activeId($model,'no_pendaftaran'),
        'htmlOptions'=>array(),
)); 
?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group ">
                <label for="namaPasien" class="control-label">
                    <?php //$model->cbTglMasuk = false; ?>
                    <?php //echo CHtml::activeCheckBox($model,'cbTglMasuk', array('uncheckValue'=>0,'onClick'=>'cekTanggal()')); ?>
                    Tanggal Rujukan 
                </label>
                <div class="controls">
                    <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                    <?php   $format = new MyFormatter;
                            $this->widget('MyDateTimePicker',array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); 
                       ?> 
                    <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                </div></div>
						<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
//                                          'maxDate'=>'d',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group ">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran')); ?>
                </div>
            </div> 
            <div class="control-group ">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('placeholder'=>'Ketik No. Rekam Medik')); ?>
                </div>
            </div>    
            <div class="control-group ">
                <label for="namaPasien" class="control-label">Nama Pasien </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'nama_pasien',array('placeholder'=>'Ketik Nama Pasien')); ?>
                </div>
            </div> 
        </td>
        <td>
            <?php
                $instalasi = InstalasiM::model()->findAllByAttributes(array(
                    'instalasi_id' => array(2,3,4),
                ));
                $ruangan = RuanganM::model()->findAllByAttributes(array(
                    'instalasi_id' => array(2,3,4),
                    'ruangan_aktif' => true,
                ), array(
                    'order'=>'instalasi_id, ruangan_nama',
                ));
                echo $form->dropDownListRow($model,'instalasiasal_id', CHtml::listData($instalasi, 'instalasi_id', 'instalasi_nama'), array(
                    'empty'=>'-- Pilih --',
                    'class'=>'span3', 
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('/actionDynamic/getRuanganAsalDariInstalasiAsal',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "ruanganasal_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'ruanganasal_id', CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

            ?>
            <?php 
                $carabayar = CarabayarM::model()->findAll(array(
                    'condition'=>'carabayar_aktif = true',
                    'order'=>'carabayar_nourut',
                ));
                foreach ($carabayar as $idx=>$item) {
                    $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                        'carabayar_id'=>$item->carabayar_id,
                        'penjamin_aktif'=>true,
                   ));
                   if (empty($penjamins)) unset($carabayar[$idx]);
                }
                $penjamin = PenjaminpasienM::model()->findAll(array(
                    'condition'=>'penjamin_aktif = true',
                    'order'=>'penjamin_nama',
                ));
                echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                    'empty'=>'-- Pilih --',
                    'class'=>'span3', 
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                        'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                    ),
                 ));
                echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'maxlength'=>50));

            ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','name'=>'submitSearch')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
//                                      'onclick'=>'if(!confirm("Apakah anda ingin mengulang ini ?")) return false;'));
                                  'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        echo "&nbsp;"; ?>
    <?php 
    $content = $this->renderPartial('../tips/informasi',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
</div>

<?php $this->endWidget(); ?>
