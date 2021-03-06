<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
        'id'=>'gzpesanmenudiet-t-search',
        'type'=>'horizontal',
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <?php echo Chtml::Label('Tanggal Kirim Menu','tglkirimmenu', array('class'=>'control-label')) ?>
                <div class="controls">
                    <?php   
                            $model->tgl_awal = MyFormatter::formatDateTimeForUser($model->tgl_awal);
                            $model->tgl_akhir = MyFormatter::formatDateTimeForUser($model->tgl_akhir);
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
                  
?> </div></div>
		<div class="control-group ">
                    <label for="namaPasien" class="control-label">
                       Sampai dengan
                      </label>
                    <div class="controls">
                            <?php   
                            $this->widget('MyDateTimePicker',array(
                                            'model'=>$model,
                                            'attribute'=>'tgl_akhir',
                                            'mode'=>'date',
                                            'options'=> array(
                                                'dateFormat'=>Params::DATE_FORMAT,
                                                'maxDate' => 'd',
                                            ),
                                            'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3'),
                    )); ?>
                </div>
            </div>
            
            <div class = "control-group">
                <?php echo Chtml::label('No. Kirim Menu','nokirimmenu',array('class'=>'control-label')) ?>
                <div class = "controls">
                <?php echo $form->textField($model,'nokirimmenu',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'autofocus'=>true, 'placeholder'=>'Ketik no. kirim menu')); ?>
                </div>
            </div>
            
            
        </td>
        <td>
            <div class = "control-group">
                <?php echo Chtml::label('No. Pesan Menu','nokirimmenu',array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model,'pesan_menu',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'autofocus'=>true, 'placeholder'=>'Ketik no. pesan menu')); ?>
                </div>
            </div>
            
            <div class = "control-group">
                <?php echo Chtml::label('Jenis Pesan','nokirimmenu',array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model,'jenispesanmenu', LookupM::getItems('jenispesanmenu'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                </div>
            </div>
            
            <div class = "control-group">
                <?php echo Chtml::label('Jenis Menu Diet','nokirimmenu',array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model,'jenisdiet_id', Chtml::ListData(JenisdietM::model()->findAll("jenisdiet_aktif = TRUE ORDER BY jenisdiet_nama ASC"),'jenisdiet_id','jenisdiet_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                </div>
            </div>
            
            <?php //echo $form->dropDownListRow($model,'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
        </td>
        <td>
             <div class = "control-group">
                <?php echo Chtml::label('Pegawai Pengirim','nokirimmenu',array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model,'create_loginpemakai_id', Chtml::ListData(GZPegawaiM::model()->PegawaiRuangan(),'loginpemakai_id','namaLengkap'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                </div>
            </div>
            <?php //echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
            <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
            
        </td>
    </tr>
</table>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
					 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
$content = $this->renderPartial('../tips/informasiPengirimanMenuDiet',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
	</div>

<?php $this->endWidget(); ?>