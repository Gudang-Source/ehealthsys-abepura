

<?php 
		$str = 
		$form->hiddenField($permintaan, 'dibuatoleh_id_pengpemb', array('id'=>'dibuatoleh_id_pengpemb')).
		$form->hiddenField($permintaan, 'diperiksaoleh_id_pengpemb', array('id'=>'diperiksaoleh_id_pengpemb')).
		$form->hiddenField($permintaan, 'disetujuioleh_id_pengpemb', array('id'=>'disetujuioleh_id_pengpemb')); 
		
		?> 
		<?php
			if (!empty($permintaan->dibuatoleh_id_pengpemb)) $permintaan->dibuatoleh_id_pengpemb = PegawaiM::model()->findByPk($permintaan->dibuatoleh_id_pengpemb)->nama_pegawai;
			if (!empty($permintaan->diperiksaoleh_id_pengpemb)) $permintaan->diperiksaoleh_id_pengpemb = PegawaiM::model()->findByPk($permintaan->diperiksaoleh_id_pengpemb)->nama_pegawai;
			if (!empty($permintaan->disetujuioleh_id_pengpemb)) $permintaan->disetujuioleh_id_pengpemb = PegawaiM::model()->findByPk($permintaan->disetujuioleh_id_pengpemb)->nama_pegawai;
		
		?>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($permintaan, 'dibuat', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
					'model'=>$permintaan,
                                        'attribute'=>'dibuatoleh_id_pengpemb',
                                        'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                                        'options'=>array( 
                                           'showAnim'=>'fold',
                                           'minLength' => 2,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#PengajuanpembayaranT_dibuatoleh_id_pengpemb").val( ui.item.nama );
                                                return false;
                                            }', 
                                           'select'=>'js:function( event, ui ) {
                                                loadPengurus(ui.item.id, ui.item.nama, "#PengajuanpembayaranT_dibuatoleh_id_pengpemb", "#dibuatoleh_id_pengpemb");
                                            }',

                                        ),
                                        'htmlOptions'=>array('disabled'=>!empty($no), 'placeholder'=>'Dibuat','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                        'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolPrepare', 'jsFunction'=>"$('#target_attr').val('dibuatoleh_id_pengpemb'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                                ));
			?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($permintaan, 'tgl', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDatePicker', array(
			//		'model'=>$permintaan, 'attribute'=>'tgldibuat_pengpemb', 'htmlOptions'=>array('disabled'=>!empty($no), 'class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
				//));
			?>
                            <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$permintaan,
					'attribute'=>'tgldibuat_pengpemb',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#PengajuanpembayaranT_tgldibuat_pengpemb').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($permintaan, 'diperiksa', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'diperiksaoleh_id_pengpemb',
                    'model'=>$permintaan,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PengajuanpembayaranT_diperiksaoleh_id_pengpemb").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#PengajuanpembayaranT_diperiksaoleh_id_pengpemb", "#diperiksaoleh_id_pengpemb");
                        }',

                    ),
                    'htmlOptions'=>array('disabled'=>!empty($no), 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolReview',  'jsFunction'=>"$('#target_attr').val('diperiksaoleh_id_pengpemb'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($permintaan, 'tgl', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDatePicker', array(
				//	'model'=>$permintaan, 'attribute'=>'tgldiperiksa_pengpemb', 'htmlOptions'=>array('disabled'=>!empty($no), 'class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
				//));
			?>
                          <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$permintaan,
					'attribute'=>'tgldiperiksa_pengpemb',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#PengajuanpembayaranT_tgldiperiksa_pengpemb').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
			</div>-->
		</div>
	</div>
        </div>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($permintaan, 'disetujui', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'disetujuioleh_id_pengpemb',
                    'model'=>$permintaan,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PengajuanpembayaranT_disetujuioleh_id_pengpemb").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#PengajuanpembayaranT_disetujuioleh_id_pengpemb", "#disetujuioleh_id_pengpemb");
                        }',

                    ),
                    'htmlOptions'=>array('disabled'=>!empty($no), 'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolApprove', 'jsFunction'=>"$('#target_attr').val('disetujuioleh_id_pengpemb'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($permintaan, 'tgl', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDatePicker', array(
				//	'model'=>$permintaan, 'attribute'=>'tgldisetujui_pengpemb', 'htmlOptions'=>array('disabled'=>!empty($no), 'class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
				//));
			?>
                          <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$permintaan,
					'attribute'=>'tgldisetujui_pengpemb',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#PengajuanpembayaranT_tgldisetujui_pengpemb').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>
			</div>-->
		</div>
	</div>
	<?php echo $str; ?>
	</div>

