<?php
	$namaModel = 'InvtanahT';
	$noUrut = 1;
	if(count($modRincian) > 0){
		foreach($modRincian as $key=>$value)
	    {
			echo"<tr>";
				echo "<td>".
    				CHtml::checkBox($namaModel."[$key][is_checked]", "checked",array('class'=>'span1', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onclick'=>'checkRekening(this)')).
    				CHtml::hiddenfield($namaModel."[$key][invtanah_id]", $value['invtanah_id'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][hargajualaktiva]", $value['hargajualaktiva'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][invtanah_harga]", $value['invtanah_harga'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    			"</td>";

				echo "<td>".$value['invtanah_kode'];
				echo "</td>";

				echo "<td>".$value['invtanah_noregister'];
				echo "</td>";

				echo "<td>".$value['invtanah_namabrg'];
				echo "</td>";

				echo "<td>".$value['invtanah_alamat'];
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['invtanah_harga']);
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['hargajualaktiva']);
				echo "</td>";
			echo"</tr>";
		}
	}

?>