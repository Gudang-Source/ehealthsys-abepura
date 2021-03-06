<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
                'id'=>'gzpengajuanbahanmkn-search',
                 'type'=>'horizontal',
)); ?>
<table width="100%" class="table-condensed">
    <tr>
        <td>
            <?php //echo  $form->textFieldRow($model,'tgl_pendaftaran'); ?>
            <div class="control-group ">
                <?php echo Chtml::label("Tanggal Terima Bahan",'tglterimabahan', array('class'=>'control-label')) ?>
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
        </td>
        <td>
			<div class="control-group">
				<?php echo Chtml::label("No Penerimaan Bahan",'nopenerimaanbahan', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->textField($model,'nopenerimaanbahan',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'autofocus'=>true, 'placeholder'=>'Ketik no. penerimaan bahan')); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo Chtml::label("Ruangan",'ruangan_id', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->dropDownList($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
				</div>
			</div>
                        
        </td>
        <td>
			<div class="control-group">
				<?php echo Chtml::label("Supplier",'supplier_id', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->dropDownList($model,'supplier_id', CHtml::listData(SupplierM::model()->findAll("supplier_aktif = true AND supplier_jenis = '".Params::SUPPLIER_JENIS_GIZI."' ORDER BY supplier_nama ASC"), 'supplier_id', 'supplier_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
				</div>
			</div>
			
			<div class="control-group">
				<?php echo Chtml::label("Sumber Dana Bahan",'sumberdanabhn', array('class' => 'control-label')) ?>
				<div class="controls">
						<?php echo $form->dropDownList($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
				</div>
			</div>
            
            
        </td>
    </tr>
</table>

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
					 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
$content = $this->renderPartial('../tips/informasiPenerimaanMakanan',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
	</div>

<?php $this->endWidget(); ?>