<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gumutasibrg-t-search',
	'type'=>'horizontal',
	'focus'=>'#'.CHtml::activeId($model,'nomutasibrg'),
)); ?>
        <table width="100%" class="table-condensed">
            <tr>
                <td>
                    <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
                    <div class="control-group ">
                        <?php echo CHtml::label('Tanggal Mutasi Barang','tglmutasibrg', array('class'=>'control-label')) ?>
                        <div class="controls">
                            <?php   
                            $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
                                    $this->widget('MyDateTimePicker',array(
                                                    'model'=>$model,
                                                    'attribute'=>'tgl_awal',
                                                    'mode'=>'date',
                                                    'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                                    $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                                ?> </div></div>
						<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                        <?php    
                            $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
                            $this->widget('MyDateTimePicker',array(
                                                'model'=>$model,
                                                'attribute'=>'tgl_akhir',
                                                'mode'=>'date',
                                                'options'=> array(
                                                    'dateFormat'=>Params::DATE_FORMAT,
                                                    'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                            )); 
                            $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
                            ?>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                            <?php echo CHtml::activeLabel($model,'nomutasibrg',array('class'=>'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->textField($model,'nomutasibrg',array('placeholder'=>'Ketik No. Mutasi Barang', 'class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <div class="control-group ">
                        <?php echo CHtml::activeLabel($model,'ruangantujuan_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                           <?php echo $form->dropDownList($model,'ruangantujuan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by ruangan_nama'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
                        <?php echo CHtml::activeLabel($model,'pegpengirim_id',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php echo $form->dropDownList($model,'pegpengirim_id', CHtml::listData(PegawaiM::model()->findAll('pegawai_aktif = true'), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                        </div>
                    </div>
                    <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
                </td>
            </tr>
        </table>

	            <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit','ajax' => array(
                 'type' => 'GET', 
                 'url' => array("/".$this->route), 
                 'update' => '#gumutasibrg-t-grid',
                 'beforeSend' => 'function(){
                                      $("#gumutasibrg-t-grid").addClass("animation-loading");
                                  }',
                 'complete' => 'function(){
                                      $("#gumutasibrg-t-grid").removeClass("animation-loading");
                                  }',
             ))); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                $this->createUrl($this->id.'/index'), 
                                array('class'=>'btn btn-danger',
                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
            <?php  
                $content = $this->renderPartial($this->path_view.'tips.informasi',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>  
    </div>

<?php $this->endWidget(); ?>

<script>
    function refresh(){
        location.reload();
    }
</script>
