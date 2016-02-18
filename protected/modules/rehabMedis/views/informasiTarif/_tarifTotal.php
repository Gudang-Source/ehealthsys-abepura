<?php
//Di kasih else dulu saya tidak tau kelas pelayannya itu boleh kosong atw ngak???? 
//Alna dari dummi data yang ada ada yang kosong
if($kelaspelayanan_id!=''){
$modTarifTindakan=  RMTariftindakanM::model()->find('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                   daftartindakan_id='.$daftartindakan_id.'
                                                   and t.jenistarif_id='.$jenistarif_id.'
                                                   AND komponentarif_id='.Params::KOMPONENTARIF_ID_TOTAL.'');
}else{ 
    $modTarifTindakan=RMTariftindakanM::model()->find('daftartindakan_id='.$daftartindakan_id.'
                                                   and t.jenistarif_id='.$jenistarif_id.'
                                                   AND komponentarif_id='.Params::KOMPONENTARIF_ID_TOTAL.'');
    $modTarifTindakan->harga_tariftindakan=0;//Belum Disetting dr masternya Berarti
}
echo MyFormatter::formatNumberForUser($modTarifTindakan->harga_tariftindakan);
?>
