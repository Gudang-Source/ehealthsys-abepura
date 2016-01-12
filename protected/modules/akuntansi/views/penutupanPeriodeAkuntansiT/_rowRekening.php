<?php foreach($modRekenings AS $i => $modRekening){ ?>
<tr>
	<td><?php 
		echo $i+1;
		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekperiod_id',array('readonly'=>true,'value'=>$modRekening->periodeposting->rekperiode_id)); 	
		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']periodeposting_id',array('readonly'=>true,'value'=>$modRekening->periodeposting_id)); 
		?></td>
	<td><?php 
	$kode = '';
//	if(isset($modRekening->rekening1_id))
//	{
//		$kode .= $modRekening->rekening1->kdrekening1;
//		echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening1_id',array('readonly'=>true,'value'=>$modRekening->rekening1_id));
//		if(isset($modRekening->rekening2_id))
//		{
//			$kode .= '-' . $modRekening->rekening2->kdrekening2;
//			echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening2_id',array('readonly'=>true,'value'=>$modRekening->rekening2_id));
//			if(isset($modRekening->rekening3_id))
//			{
//				$kode .= '-' . $modRekening->rekening3->kdrekening3;
//				echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening3_id',array('readonly'=>true,'value'=>$modRekening->rekening3_id));
//				if(isset($modRekening->rekening4_id))
//				{
//					$kode .= '-' . $modRekening->rekening4->kdrekening4;
//					echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening4_id',array('readonly'=>true,'value'=>$modRekening->rekening4_id));
					if(isset($modRekening->rekening5_id))
					{
						$kode .= $modRekening->rekening5->kdrekening5;
						echo CHtml::activeHiddenField($modSaldoAwal,'['.$i.']rekening5_id',array('readonly'=>true,'value'=>$modRekening->rekening5_id));
					}
//				}
//			}
//		}
//	}
	echo $kode;
	?></td>
	<td><?php 
	if ($modRekening->rekening5_id){
		echo $modRekening->rekening5->nmrekening5;
	}  
	?></td>
	<td><?php echo $format->formatUang($modRekening->saldodebit); ?><?php echo CHtml::hiddenField('debit',$modRekening->saldodebit,array('readonly'=>true)); ?></td>
	<td><?php echo $format->formatUang($modRekening->saldokredit); ?><?php echo CHtml::hiddenField('kredit',$modRekening->saldokredit,array('readonly'=>true)); ?></td>
</tr>
<?php } ?>


