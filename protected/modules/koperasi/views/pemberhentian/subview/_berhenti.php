
	
		
		<?php echo $form->hiddenField($berhenti, 'keanggotaan_id'); ?>
		<?php echo $form->hiddenField($berhenti, 'pegawai_id'); ?>
	
	<div class="span4">
		<div class="control-group">
			<?php echo Chtml::label('Tanggal Permintaan', 'tglpermintaanberhenti', array('class'=>'control-label')); ?>
			<div class="controls">
				<!--<div class="input-group">-->
				<?php 
				//		$this->widget('bootstrap.widgets.TbDatePicker', array(
					//		'model'=>$berhenti, 'attribute'=>'tglpermintaanberhenti', 'options'=>array('format'=>'dd/mm/yyyy'), 'htmlOptions'=>array('class'=>'form-control'),
					//	));
				?>
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$berhenti,
					'attribute'=>'tglpermintaanberhenti',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
						<!--	<div class='input-group-addon' onclick="$('#PemintaanberhentiT_tglpermintaanberhenti').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>-->
			</div>
		</div>
            
		<div class="control-group">
			<?php echo Chtml::label('Tanggal Berhenti', 'tglberhenti_dipecat', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<!--<div class="input-group">-->
				<?php 
						//$this->widget('bootstrap.widgets.TbDatePicker', array(
					//		'model'=>$berhenti, 'attribute'=>'tglberhenti_dipecat', 'options'=>array('format'=>'dd/mm/yyyy'), 'htmlOptions'=>array('class'=>'form-control'),
						//));
				?>
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$berhenti,
					'attribute'=>'tglberhenti_dipecat',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
				<!--	<div class='input-group-addon' onclick="$('#PemintaanberhentiT_tglberhenti_dipecat').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>-->
			</div>
		</div>
		<div class="control-group">
			<?php echo Chtml::label('Sebab Berhenti', 'sebabberhenti', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textArea($berhenti,'sebabberhenti', array('rows'=>3, 'class'=>'form-control')); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group">
			<?php echo Chtml::label('Alasan Berhenti', 'alasanberhenti', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textArea($berhenti,'alasanberhenti', array('rows'=>7, 'class'=>'form-control')); ?>
			</div>
		</div>
	</div>
<div class="span4">&nbsp;</div>
<div class="span12">&nbsp;</div>
	<?php 
		$str = 
		$form->hiddenField($berhenti, 'dibuatolehperm_id', array('id'=>'dibuatolehperm_id')).
		$form->hiddenField($berhenti, 'diperiksaprmint_id', array('id'=>'diperiksaprmint_id')).
		$form->hiddenField($berhenti, 'disetuuiolehperm_id', array('id'=>'disetuuiolehperm_id')); 
		
		?> 
		<?php
			if (!empty($berhenti->dibuatolehperm_id)) $berhenti->dibuatolehperm_id = PegawaiM::model()->findByPk($berhenti->dibuatolehperm_id)->nama_pegawai;
			if (!empty($berhenti->diperiksaprmint_id)) $berhenti->diperiksaprmint_id = PegawaiM::model()->findByPk($berhenti->diperiksaprmint_id)->nama_pegawai;
			if (!empty($berhenti->disetuuiolehperm_id)) $berhenti->disetuuiolehperm_id = PegawaiM::model()->findByPk($berhenti->disetuuiolehperm_id)->nama_pegawai;
		
		?>
	<div class="span4">
		<div class="control-group">
			<?php echo Chtml::label('Dibuat', 'dibuatolehperm_id', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
					'model'=>$berhenti,
                    'attribute'=>'dibuatolehperm_id',
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PemintaanberhentiT_dibuatolehperm_id").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#PemintaanberhentiT_dibuatolehperm_id", "#dibuatolehperm_id");
                        }',

                    ),
                    'htmlOptions'=>array('placeholder'=>'Dibuat','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolPrepare', 'jsFunction'=>"$('#target_attr').val('dibuatolehperm_id'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                ));
			?>
			</div>
		</div>
		<div class="control-group">
			<?php echo Chtml::label('Tanggal', 'tgldibuatpermintaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$berhenti, 'attribute'=>'tgldibuatpermintaan', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                         <?php   
                                $this->widget('MyDateTimePicker',array(
                                'model'=>$berhenti,
                                'attribute'=>'tgldibuatpermintaan',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
                            
			<!--<div class='input-group-addon' onclick="$('#PemintaanberhentiT_tgldibuatpermintaan').focus();">
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
			<?php echo Chtml::label('Diperiksa', 'diperiksaprmint_id', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'diperiksaprmint_id',
                    'model'=>$berhenti,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PemintaanberhentiT_diperiksaprmint_id").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#PemintaanberhentiT_diperiksaprmint_id", "#diperiksaprmint_id");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolReview',  'jsFunction'=>"$('#target_attr').val('diperiksaprmint_id'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo Chtml::label('Tanggal', 'tgldiperiksaperm', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
			//	$this->widget('bootstrap.widgets.TbDateTimePicker', array(
			//		'model'=>$berhenti, 'attribute'=>'tgldiperiksaperm', 'htmlOptions'=>array('class'=>'form-control datepicker'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
			//	));
			?>
                             <?php   
                                $this->widget('MyDateTimePicker',array(
                                'model'=>$berhenti,
                                'attribute'=>'tgldiperiksaperm',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
			<!--<div class='input-group-addon' onclick="$('#PemintaanberhentiT_tgldiperiksaperm').focus();">
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
			<?php echo Chtml::label('Disetujui', 'disetuuiolehperm_id', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'disetuuiolehperm_id',
                    'model'=>$berhenti,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#PemintaanberhentiT_disetuuiolehperm_id").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#PemintaanberhentiT_disetuuiolehperm_id", "#disetuuiolehperm_id");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai_pengurus','idTombol'=>'tombolApprove', 'jsFunction'=>"$('#target_attr').val('disetuuiolehperm_id'); $('#dialog_pegawai_pengurus').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo Chtml::label('Tanggal', 'tgldisetujuiperm', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<div class="input-group">
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$berhenti, 'attribute'=>'tgldisetujuiperm', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
			//	));
			?>
                         <?php   
                                $this->widget('MyDateTimePicker',array(
                                'model'=>$berhenti,
                                'attribute'=>'tgldisetujuiperm',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
			<!--<div class='input-group-addon' onclick="$('#PemintaanberhentiT_tgldisetujuiperm').focus();">
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
        </div>