
	<?php 
		$str = 
		$form->hiddenField($kaskeluar, 'preparedby', array('id'=>'preparedby')).
		$form->hiddenField($kaskeluar, 'reviewedby', array('id'=>'reviewedby')).
		$form->hiddenField($kaskeluar, 'approvedby', array('id'=>'approvedby')); 
		
		?> 
		<?php
			if (!empty($kaskeluar->preparedby)) $kaskeluar->preparedby = PegawaiM::model()->findByPk($kaskeluar->preparedby)->nama_pegawai;
			if (!empty($kaskeluar->reviewedby)) $kaskeluar->reviewedby = PegawaiM::model()->findByPk($kaskeluar->reviewedby)->nama_pegawai;
			if (!empty($kaskeluar->approvedby)) $kaskeluar->approvedby = PegawaiM::model()->findByPk($kaskeluar->approvedby)->nama_pegawai;
		
		?>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($kaskeluar, 'preparedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
					'model'=>$kaskeluar,
                    'attribute'=>'preparedby',
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BukitkaskeluarT_preparedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BukitkaskeluarT_preparedby", "#preparedby");
                        }',

                    ),
                    'htmlOptions'=>array('placeholder'=>'Dibuat','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolPrepare', 'jsFunction'=>"$('#target_attr').val('preparedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
			?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kaskeluar, 'prepareddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
			//	$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kaskeluar, 'attribute'=>'prepareddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kaskeluar,
					'attribute'=>'prepareddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#BukitkaskeluarT_prepareddate').focus();">
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
			<?php echo $form->label($kaskeluar, 'reviewedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'reviewedby',
                    'model'=>$kaskeluar,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BukitkaskeluarT_reviewedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BukitkaskeluarT_reviewedby", "#reviewedby");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolReview',  'jsFunction'=>"$('#target_attr').val('reviewedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kaskeluar, 'revieweddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
			//	$this->widget('bootstrap.widgets.TbDateTimePicker', array(
			//		'model'=>$kaskeluar, 'attribute'=>'revieweddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
			//	));
			?>
                         <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kaskeluar,
					'attribute'=>'revieweddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#BukitkaskeluarT_revieweddate').focus();">
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
			<?php echo $form->label($kaskeluar, 'approvedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'approvedby',
                    'model'=>$kaskeluar,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BukitkaskeluarT_approvedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BukitkaskeluarT_approvedby", "#approvedby");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolApprove', 'jsFunction'=>"$('#target_attr').val('approvedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kaskeluar, 'approveddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kaskeluar, 'attribute'=>'approveddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                        
                        <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kaskeluar,
					'attribute'=>'approveddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
                        
			<!--<div class='input-group-addon' onclick="$('#BukitkaskeluarT_approveddate').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
			</div>
		</div>
	</div>
	<?php echo $str; ?> 
	