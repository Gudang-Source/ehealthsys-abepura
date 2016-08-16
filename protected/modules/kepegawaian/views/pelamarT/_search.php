<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pelamar-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nama_pelamar'),
)); 
$format = new MyFormatter();
?>

	<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
	<table style = "width:100%">
            <tr>
                <td>
                    <div class='control-group hari'>
                    <?php echo CHtml::label('Tanggal Lowongan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>                     
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                                               
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>                     
                    </div> 

                </div>
                <div class='control-group hari'>
                    <?php echo CHtml::label('Sampai Dengan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">  
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>                     
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => "dtPicker3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>                     
                    </div> 
                </td>
                <td>
                    <div class = "control-group">
                        <?php echo CHtml::label('Nama Pelamar', 'nama_pelamar', array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php
                            echo $form->textField($model, 'nama_pelamar',array('class'=>'hurufs-only'));
                            /*$this->widget('MyJuiAutoComplete',array(
                                'model'=>$model,
                                'attribute'=>'nama_pelamar',
                                'sourceUrl'=>  Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/NamaPelamar'),
                                'options'=>array(
                                    'showAnim'=>'fold',
                                    'minLength'=>2,
                                    'select'=>'js:function( event, ui ) {
                                            $("#HRDPelamarT_nama_pelamar").val(ui.item.nama_pelamar);
                                                }',
                                ),
//                                'tombolDialog'=>array('idDialog'=>'dialogPegawaiYangMengajukan'),
                                'htmlOptions'=>array('class'=>'span2','style'=>'float:left;')
                            ));*/
                        ?>
                        </div>
                    </div>
                    <div class = "control-group">
                        <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class'=>'control-label')); ?>
                        <div class = "controls">
                            <?php echo $form->dropDownList($model, 'jeniskelamin', LookupM::getItems('jeniskelamin') ,array('empty' => '-- Pilih --')); ?>
                        </div>
                    </div>
                   
                </td>                
                <td>
                        <div class = "control-group">
                                <?php echo CHtml::label('Status Perkawinan', 'statusperkawinan', array('class'=>'control-label')); ?>
                            <div class = "controls">
                                <?php echo $form->dropDownList($model,'statusperkawinan', LookupM::getItems('statusperkawinan') ,array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                            </div>
                        </div>
                        
                        <?php echo $form->dropDownListRow($model,'pendidikan_id', CHtml::listData($model->PendidikanItems, 'pendidikan_id', 'pendidikan_nama') ,array('class'=>'span3', 'empty'=>'-- Pilih --')); ?>
                </div>
                </td>                
            </tr>
        </table>
		

           
		<div class="control-group">
			<?php echo CHtml::label('Semua Pelamar','',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->checkBox($model,'semuapelamar', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
	
	
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('pelamarT/admin'), array('class'=>'btn btn-danger')); ?>
    <?php
          $content = $this->renderPartial('../tips/informasi_pelamar',array(),true);
          $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
