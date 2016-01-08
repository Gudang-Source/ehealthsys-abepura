<style>
    th{
        border-bottom: 2px #000 solid;
    }
</style>
<div style="text-align: center;">
    <h2><?php echo $judulLaporan; ?></h2>
    <b>Periode : <?php echo $periode; ?></b><br>
</div>
<table width="100%">
    <tr>
        <td width="120px"><b>Ruangan Asal</b></td><td><b>: <?php echo (isset($ruanganAsal) ? $ruanganAsal : ""); ?></b></td>
        <td width="120px"><b>No. Mutasi</b></td><td><b>: <?php echo (isset($model->nomutasioa) ? $model->nomutasioa : ""); ?></td>
    </tr>
    <tr>
        <td width="120px"><b>Ruangan Tujuan</b></td><td><b>: <?php echo (isset($model->ruangantujuan->ruangan_nama) ? $model->ruangantujuan->ruangan_nama : ""); ?></td>
        <td width="120px"><b>Status Terima</b></td><td><b>: <?php echo (!empty($model->terimamutasi_id)) ? "Sudah Diterima" : "Belum Diterima"; ?></td>
    </tr>
</table>
<table width="100%">
    <thead>
        <th>No.</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Tgl. Kadaluarsa</th>
        <th>Asal Barang</th>
        <th>Jml Pesan</th>
        <th>Jml Mutasi</th>
        <th>Satuan</th>
        <th>HPP</th>
        <th>Harga Jual</th>
        <th>Diskon (%)</th>
        <th>Keterangan</th>
    </thead>
    <tbody>
<?php
$i = 0;
$tr = null;
foreach($modDetail as $i => $mod){
    $tr .= "<tr>";
    $tr .= "<td>".($i+1)."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_kode."</td>";
    $tr .= "<td>".$mod->obatalkes->obatalkes_nama."</td>";
    $tr .= "<td>".date("d/m/Y H:i:s", strtotime($mod->tglkadaluarsa))."</td>";
    $tr .= "<td>".$mod->sumberdana->sumberdana_nama."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->jmlpesan,0,",",".")."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->jmlmutasi,0,",",".")."</td>";
    $tr .= "<td>".$mod->satuankecil->satuankecil_nama."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->harganetto,0,",",".")."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->hargajualsatuan,0,",",".")."</td>";
    $tr .= "<td style='text-align:right;'>".number_format($mod->persendiscount,0,",",".")."</td>";
    $tr .= "</tr>";
}
echo $tr;
?>
    </tbody>
</table>
<?php 
if(isset($_GET['caraPrint']))
    $this->renderPartial('penerimaanObatAlkes/_tandatangan', array('model'=>$model, 'caraPrint'=>$caraPrint)); 
?>