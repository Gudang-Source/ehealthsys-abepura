<?php
$modTindakanPelayanan= SAPaketpelayananM::model()->with('daftartindakan')->findAllByAttributes(array('tipepaket_id'=>$tipepaket_id));
if(COUNT($modTindakanPelayanan)>0)
{
	echo "<ul>";
	foreach($modTindakanPelayanan as $i=>$row)
	{
		echo '<li>'.$row->daftartindakan->daftartindakan_nama.'</li>';
	}
	echo "</ul>";
}else
{
	echo "Belum di Set";
}   
?>

