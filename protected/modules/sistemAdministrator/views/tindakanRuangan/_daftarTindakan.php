<?php
	$modDaftarTindakan=TindakanruanganM::model()->findAll('ruangan_id='.$ruangan_id.'');
	$modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$modDaftarTindakan[0]->daftartindakan_id));
        $daftarTindakan = array();
if(COUNT($modDaftarTindakan)>0)
    {   
        //echo "<ul>"; 
        foreach($modDaftarTindakan as $i=>$tindakan)
        {            
            $daftarTindakan[$tindakan->daftartindakan->kategoritindakan->kategoritindakan_nama][$tindakan->daftartindakan->daftartindakan_nama] = $tindakan->daftartindakan->daftartindakan_nama;            
            //$daftarTindakan['kategoritindakan_id']['daftartindakan_nama'] = $tindakan->daftartindakan->daftartindakan_nama;
            //echo "<li>".$tindakan->daftartindakan->daftartindakan_nama.'</li>';
            
        }
        //echo "</ul>";
    }
else
    {
        echo Yii::t('zii','Not set'); 
    }   
if (count($daftarTindakan)>0){
    foreach($daftarTindakan as $tes => $value){
        echo "<ul>";
        echo "<li><b>".$tes."</b><br/><ul>";
        foreach($value as $i => $daftar){
            echo "<li> - ".$daftar."</li>";
        }
        echo "</ul></li></ul>";
    }
    //var_dump($daftarTindakan);
}else
{
    echo Yii::t('zii','Not set'); 
}       
    
?>
<br><br>
<legend class=rim> Daftar Tarif </legend>
<table class=table table-striped table-bordered table-condensed>
    <thead>
        <tr>
            <th>No</th>
            <th>Kelas Pelayanan</th>
            <th>Tarif Tindakan</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($modTarifTindakan as $key=>$tarif){
        echo "<tr>";
        echo "<td>".($key+1)."</td>";
        echo "<td>".$tarif->kelaspelayanan->kelaspelayanan_nama."</td>";
        echo "<td>".number_format($tarif->harga_tariftindakan,0,"",".")."</td>";
        echo "</tr>";
    }
?>
    </tbody>
</table>