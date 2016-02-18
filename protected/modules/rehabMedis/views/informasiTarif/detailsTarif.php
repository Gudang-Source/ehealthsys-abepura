<?php
echo "<table>";
echo "<tr>
        <td>Kategori Tindakan</td>
        <td>".$modTarif ['kategoritindakan_nama']."</td>

         </tr>";
echo "<tr>"
        . "<td>Jenis Tarif</td>"
        . "<td>".$modTarif->jenistarif_nama."</td>"
        . "</tr>";
echo "<tr>"
        . "<td>Kelas Pelayanan</td>"
        . "<td>".$modTarif->kelaspelayanan_nama."</td>"
        . "</tr>";
echo "<tr>
        <td>Nama Tindakan</td>
        <td>".$modTarif ['daftartindakan_nama']."</td>      

         </tr>";
echo "</table><hr/>";

$tarifTotal=0;
if($jumlahTarifTindakan>0){//Jika Tarif Sudah Disetting Didata Masternya dan ada
echo '<table width="100%">';
foreach($modTarifTindakan AS $tampilTarifTindakan):
    echo "<tr>
            <td>".$tampilTarifTindakan->komponentarif['komponentarif_nama']."</td>
            <td style=\"text-align: right;\">".MyFormatter::formatNumberForUser($tampilTarifTindakan['harga_tariftindakan'])."</td>    
          </tr>"; 
$tarifTotal=$tarifTotal+$tampilTarifTindakan['harga_tariftindakan'];
endforeach;
echo "<tr>
        <td colspan=\"2\"><hr>
     <tr>
        <td>Total</td>
        <td style=\"text-align: right;\">".MyFormatter::formatNumberForUser($tarifTotal)."
    </table>";
}else{
    echo "Tarif Belum Disetting";
}
?>