
<?php   	
    if ($jam == 'selesai'){
	$this->widget('MyDateTimePicker',array(		                                        
		'name'=>"KPRencanaLemburT[".$no."][jamSelesai]",		
		'mode'=>'time',							
		'options'=> array(
			'showOn' => false,			
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array('readonly'=>TRUE,'placeholder'=>'00:00:00','class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
        ));
    }elseif($jam == 'mulai'){
        $this->widget('MyDateTimePicker',array(		                                        
		'name'=>"KPRencanaLemburT[".$no."][jamMulai]",		
		'mode'=>'time',							
		'options'=> array(
			'showOn' => false,			
			//'format' => 'H:i',			
		),
		'htmlOptions'=>array('readonly'=>TRUE,'placeholder'=>'00:00:00','class'=>'dtPicker2','onkeyup'=>"return $(this).focusNextInputField(event),"
		),
        ));
    }

?>
                        