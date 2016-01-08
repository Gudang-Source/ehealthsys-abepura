<?php 
if(isset($modKemampuanPelamars)){
     foreach ($modKemampuanPelamars as $i => $modKemampuanPelamar) {
         $no=$i+1;
        ?> <tr>
            <td><?php echo $form->textField($modKemampuanPelamar,"[$i]no_urut",array('class'=>'span1', 'readonly'=>true, 'value'=>"$no"))?></td>
            <td><?php echo $form->textField($modKemampuanPelamar,"[$i]kemampuan_nama",array('class'=>'span3 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?></td>
            <td><?php echo $form->textField($modKemampuanPelamar,"[$i]kemampuan_tingkat",array('class'=>'span3 isDetailReq', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?></td>
            <td width="5%">
                
            </td>

        </tr>
    <?php }
} else {
?>
<tr>
    <td><?php echo CHtml::textField('no_urut',0,array('readonly'=>true,'class'=>'span1 integer', 'style'=>'width:20px;')); ?></td>
    <td><?php echo $form->textField($modKemampuanPelamar,'[ii]kemampuan_nama',array('class'=>'span3 isDetailReq3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?></td>
    <td><?php echo $form->dropDownList($modKemampuanPelamar,'[ii]kemampuan_tingkat', CHtml::listData(LookupM::model()->findAllByAttributes(array('lookup_type'=>'kemampuan_tingkat')), 'lookup_name', 'lookup_name'), array('class'=>'span2 isDetailReq3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20, 'empty'=>' --Pilih-- ',)); ?></td>
    <td width="5%">
        <?php 
            echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowSkill(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Kemampuan'));
            if($btnHapus == true){
                echo "&nbsp;&nbsp;";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalSkill(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan Kemampuan'));
            }
        ?>
    </td>

</tr>
<?php } ?>