
	<?php 
		$str = 
		$form->hiddenField($kasmasuk, 'preparedby', array('id'=>'preparedby')).
		$form->hiddenField($kasmasuk, 'reviewedby', array('id'=>'reviewedby')).
		$form->hiddenField($kasmasuk, 'approvedby', array('id'=>'approvedby')); 
		
		?> 
		<?php
			if (!empty($kasmasuk->preparedby)) $kasmasuk->preparedby = PegawaiM::model()->findByPk($kasmasuk->preparedby)->nama_pegawai;
			if (!empty($kasmasuk->reviewedby)) $kasmasuk->reviewedby = PegawaiM::model()->findByPk($kasmasuk->reviewedby)->nama_pegawai;
			if (!empty($kasmasuk->approvedby)) $kasmasuk->approvedby = PegawaiM::model()->findByPk($kasmasuk->approvedby)->nama_pegawai;
		
		?>
	<div class="span4">
		<div class="control-group">
			<?php echo $form->label($kasmasuk, 'preparedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
					'model'=>$kasmasuk,
                    'attribute'=>'preparedby',
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BuktikasmasukT_preparedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BuktikasmasukT_preparedby", "#preparedby");
                        }',

                    ),
                    'htmlOptions'=>array('placeholder'=>'Dibuat','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolPrepare', 'jsFunction'=>"$('#target_attr').val('preparedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
			?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'prepareddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kasmasuk, 'attribute'=>'prepareddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                             <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kasmasuk,
					'attribute'=>'prepareddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#BuktikasmasukT_prepareddate').focus();">
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
			<?php echo $form->label($kasmasuk, 'reviewedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'reviewedby',
                    'model'=>$kasmasuk,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BuktikasmasukT_reviewedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BuktikasmasukT_reviewedby", "#reviewedby");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolReview',  'jsFunction'=>"$('#target_attr').val('reviewedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'revieweddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				// $this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kasmasuk, 'attribute'=>'revieweddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
			//	));
			?>
                             <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kasmasuk,
					'attribute'=>'revieweddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#BuktikasmasukT_revieweddate').focus();">
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
			<?php echo $form->label($kasmasuk, 'approvedby', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php

				$this->widget('MyJuiAutoComplete',array(
                    'attribute'=>'approvedby',
                    'model'=>$kasmasuk,
                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPengurusKoperasi'),
                    'options'=>array( 
                       'showAnim'=>'fold',
                       'minLength' => 2,
                       'focus'=> 'js:function( event, ui ) {
                            $("#BuktikasmasukT_approvedby").val( ui.item.nama );
                            return false;
                        }', 
                       'select'=>'js:function( event, ui ) {
                            loadPengurus(ui.item.id, ui.item.nama, "#BuktikasmasukT_approvedby", "#approvedby");
                        }',

                    ),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                    'tombolModal'=>array('idModal'=>'dialog_pegawai','idTombol'=>'tombolApprove', 'jsFunction'=>"$('#target_attr').val('approvedby'); $('#dialog_pegawai').modal('show');"),
                        
                ));
		?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'approveddate', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kasmasuk, 'attribute'=>'approveddate', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                        <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kasmasuk,
					'attribute'=>'approveddate',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
			<!--<div class='input-group-addon' onclick="$('#BuktikasmasukT_approveddate').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
			</div>
		</div>
	</div>
	<?php echo $str; ?> 
	