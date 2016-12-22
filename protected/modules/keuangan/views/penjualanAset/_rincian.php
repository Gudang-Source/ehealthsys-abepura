<?php
	$namaModel = 'InvperalatanT';
	$noUrut = 1;
	if(count($modRincian) > 0){
		foreach($modRincian as $key=>$value)
	    {
			echo"<tr>";
				echo "<td>".
    				CHtml::checkBox($namaModel."[$key][is_checked]", "checked",array('class'=>'span1', 'onkeypress'=>'return $(this).focusNextInputField(event)', 'onclick'=>'checkRekening(this)')).
    				CHtml::hiddenfield($namaModel."[$key][invperalatan_id]", $value['invperalatan_id'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][hargajualaktiva]", $value['hargajualaktiva'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][invperalatan_harga]", $value['invperalatan_harga'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][keuntungan]", $value['keuntungan'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][kerugian]", $value['kerugian'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    				CHtml::hiddenfield($namaModel."[$key][invperalatan_akumsusut]", $value['invperalatan_akumsusut'],array('onkeypress'=>'return $(this).focusNextInputField(event)')).
    			"</td>";

				echo "<td>".$value['invperalatan_kode'];
				echo "</td>";

				echo "<td>".$value['invperalatan_noregister'];
				echo "</td>";

				echo "<td>".$value['invperalatan_namabrg'];
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['invperalatan_harga']);
				echo "</td>";

				echo "<td style='text-align: right;'>".MyFormatter::formatNumberForPrint($value['hargajualaktiva']);
				echo "</td>";
			echo"</tr>";
		}
	}

?>