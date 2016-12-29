<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'search-penunjangrujukan-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#noPendaftaran',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); 

Yii::app()->clientScript->registerScript('search', "
$('#search-penunjangrujukan-form').submit(function(){
	$.fn.yiiGridView.update('pasienpenunjangrujukan-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert');
$format = new MyFormatter;
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
            <?php /*
            <div class="control-group ">
                <label for="noPendaftaran" class="control-label">No. Pendaftaran </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_pendaftaran',array('placeholder'=>'Ketik No. Pendaftaran')); ?>
                </div>
            </div>  
             * 
             */ ?>  
            <div class="control-group ">
                <label for="noRekamMedik" class="control-label">No. Rekam Medik </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'no_rekam_medik',array('class' => 'numbers-only','placeholder'=>'Ketik No. Rekam Medik')); ?>
                </div>
            </div>    
            <div class="control-group ">
                <label for="namaPasien" class="control-label">Nama Pasien </label>
                <div class="controls">
                    <?php echo CHtml::activeTextField($model,'nama_pasien',array('class' => 'hurufs-only','placeholder'=>'Ketik Nama Pasien')); ?>
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
                    'order'=>'carabayar_nama',
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
		<?php
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl($this->id.'/index'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'return refreshForm(this);'));
	?>
		<?php 
$content = $this->renderPartial('../tips/informasiPasienRujukan',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
		
    </div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    
    // document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
    // document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
    function cekTanggal(){
        
        var checklist = $('#cbTglMasuk');
        var pilih = checklist.attr('checked');
     

        // var tgl_masuk = $(document)
        if(pilih){
            // document.getElementById('tgl_awal').disabled = false;
            // document.getElementById('tgl_akhir').disabled = false;
            document.getElementById('tgl_awal_date').setAttribute("style","display:block;");
            document.getElementById('tgl_akhir_date').setAttribute("style","display:block;");
        }
        else{
            // document.getElementById('tgl_awal').disabled = true;
            // document.getElementById('tgl_akhir').disabled = true;
            document.getElementById('tgl_awal_date').setAttribute("style","display:none;");
            document.getElementById('tgl_akhir_date').setAttribute("style","display:none;");
        }
    }

</script>