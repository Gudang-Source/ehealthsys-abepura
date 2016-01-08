<?php 
	if(count($modUraian) > 0){
    foreach ($modUraian as $i => $uraian) { 
	if(!isset($removeButton)){
		$removeButton = false;
	}
?>
<tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
    <td>
        <?php echo $form->textField($uraian,"[$i]uraiantransaksi",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]volume",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel lebar2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($uraian,"[$i]satuanvol", LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]hargasatuan",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel lebar3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[$i]totalharga",array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer totalharga', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 			
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } ?>
<?php }else{ 
$uraian = new KUUraianpenumumT;	
?>
<tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
    <td>
        <?php echo $form->textField($uraian,"[0]uraiantransaksi",array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[0]volume",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel lebar2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->dropDownList($uraian,"[0]satuanvol", LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[0]hargasatuan",array('onkeyup'=>'hitungTotalUraian(this)','class'=>'inputFormTabel lebar3 integer', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php echo $form->textField($uraian,"[0]totalharga",array('readonly'=>true,'class'=>'inputFormTabel lebar3 integer totalharga', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    </td>
    <td>
        <?php 
			if(!isset($removeButton)){
                $removeButton = false;
            }
			
            if($removeButton || $i>0){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian')); 
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan uraian'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowUraian(this); return false;','rel'=>'tooltip','title'=>'Klik untuk menambah uraian'));
            }
        ?>
    </td>
</tr>
<?php } ?>


