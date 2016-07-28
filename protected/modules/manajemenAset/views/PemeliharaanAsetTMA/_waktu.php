
		<?php   
				$detail->waktuCek = (!empty($detail->waktuCek) ? MyFormatter::formatDateTimeForUser(date("Y-m-d",strtotime($detail->waktuCek))) : null);
                                
				$this->widget('MyDateTimePicker',array(		                                        
					'name'=>"MAPemeliharaanasetdetailT[".$no."][waktuCek]",
                                       // 'model'=>$detail,
					//'attribute'=>'[ii]waktuCek',
					'mode'=>'date',
                                        'value'=>$detail->waktuCek,                                        
					'options'=> array(
						'showOn' => false,
						'yearRange'=> "-150:+0",
                                                'dateFormat' => Params::DATE_FORMAT,
                                                'format' => 'Y-m-d',
                                                'onSelect' => 'js:function() {$("#MAPemeliharaanasetdetailT_'.$no.'_pemeliharaanasetdet_tgl").val(this.value);}',//$("#'.CHtml::activeId($detail,'[ii]pemeliharaanasetdet_tgl').'").val(selectedDate);
					),
					'htmlOptions'=>array('readonly'=>TRUE,'placeholder'=>'00/00/0000','class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event),"
					),
			));
                             /*   $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                                    'name'=>'MAPemeliharaanasetdetailT_'.$no.'_pemeliharaanasetdet_tgl',
                                   // 'flat'=>true,//remove to hide the datepicker
                                    'options'=>array(
                                       // 'showAnim'=>'slide',//'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                                    ),
                                    'htmlOptions'=>array(
                                        'style'=>''
                                    ),
                                ));*/
                         
                                ?>
                        