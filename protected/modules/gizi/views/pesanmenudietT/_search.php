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
            <div class="control-group ">
                <?php echo Chtml::label("Tanggal Pesan Menu",'tglpesanmenu', array('class'=>'control-label')) ?>
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
					?> 
				</div></div>
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
            
            <div class ="control-group">
                    <?php echo Chtml::label("No Pesan Menu",'nopesnamenu', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model,'nopesanmenu',array('class'=>'span3 angkahuruf-only', 'maxlength'=>20, 'autofocus'=>true, 'placeholder'=>'Ketik no. pesan menu')); ?>
                </div>
            </div>
        </td>
        <td>
            
            
            
            <?php 
			if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIZI) {
                           echo $form->dropDownListRow($model,'instalasi_id', Chtml::listData(InstalasiM::model()->findAll("instalasi_aktif = TRUE ORDER BY instalasi_nama ASC"), 'instalasi_id', 'instalasi_nama'), 
                                array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 
                                'ajax'=>array('type'=>'POST',
                                            'url'=>$this->createUrl('/ActionDynamic/GetRuanganDariInstalasi',array('encode'=>false,'namaModel'=>get_class($model))),
                                            'update'=>"#".CHtml::activeId($model, 'ruangan_id'),
                                )));
                
            ?>
                                <div class = "control-group">
                                    <?php echo Chtml::label("Ruangan",'ruangan_id',array('class'=>'control-label')); ?>
                                    <div class = "controls">
                                        <?php echo $form->dropDownList($model,'ruangan_id',array(),array('class'=>'span3','empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event);"));  ?>
                                    </div>
                                </div>
            <?php
                               
				//echo $form->dropDownListRow($model,'ruangan_id', CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); 
			} ?>
            
            <div class ="control-group">
                    <?php echo Chtml::label("Jenis Pesanan", 'jenispesanmenu', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->dropDownList($model,'jenispesanmenu', LookupM::getItems('jenispesanmenu'),array('empty'=>'-- Pilih --','class'=>'span3', 'maxlength'=>20)); ?>
                </div>
            </div>
            
        </td>
        <td>
            <div class ="control-group">
                    <?php echo Chtml::label("Nama Pemesan", 'nama_pemesan', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model,'nama_pemesan',array('class'=>'span3 hurufs-only', 'maxlength'=>100, 'placeholder'=>'Ketik Nama Pemesan')); ?>
                </div>
            </div>
            
            <?php echo $form->dropDownListRow($model, 'status_terima', Params::getStatusTerima(),array('class'=>'span2','empty'=>'-- Pilih --')) ?>
            <?php //echo $form->dropDownListRow($model,'sumberdanabhn', LookupM::getItems('sumberdanabahan'),array('empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
		$content = $this->renderPartial('gizi.views.tips.informasiPesanMenuDiet',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
</div>
<?php $this->endWidget(); ?>