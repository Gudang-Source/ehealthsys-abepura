
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    $template = "{items}";
}
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judul_print.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');   
    $table = 'ext.bootstrap.widgets.BootExcelGridView';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judul_print, 'colspan'=>''));      
?>

<table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
    <tr>
            <td width="20%">No. Rencana</td>
            <td>:</td>
            <td><?php echo $rencana[0]->norencana; ?></td>
        </tr>    
    <tr>
            <td>Tanggal Rencana Lembur</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($rencana[0]->tglrencana); ?></td>
    </tr>
    <tr>
            <td>Pemberi Tugas</td>
            <td>:</td>
            <td><?php echo (isset($rencana[0]->pemberitugas_id) ? PegawaiM::model()->findByPk($rencana[0]->pemberitugas_id)->nama_pegawai:""); ?></td>
    </tr>
    <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $rencana[0]->keterangan; ?></td>
    </tr>
    </table><br/>
    <table id="tabelPegawaiLembur" class="table table-bordered table-condensed">
        <thead >
            <th width="20%" style="text-align: center;">No.</th>
            <th style="text-align: center;">No. Induk Pegawai</th>
            <th style="text-align: center;">Nama Pegawai</th>
            <!--<th style="text-align: center;">Jabatan</th>-->
            <th style="text-align: center;">Jam Mulai</th>
            <th style="text-align: center;">Jam Selesai</th>
            <th style="text-align: center;">Alasan Lembur</th>
        </thead>
        <tbody>
        <?php
            $tr = '';
            $no = 1;
            $format = new MyFormatter;
           if(count($rencana) > 0){
                foreach($rencana AS $key=> $modDetail){
                            $rencana[$key]->jamMulai = date('H:i', strtotime($rencana[$key]->tglmulai));
                            $rencana[$key]->jamSelesai = date('H:i', strtotime($rencana[$key]->tglselesai));
                            $tr.="<tr>
                               <td style='text-align: center;'>".$no++."</td>
                               <td >".$rencana[$key]->pegawai->nomorindukpegawai."</td>
                               <td >".$rencana[$key]->pegawai->nama_pegawai."</td>
                               <td style='text-align:center;'>".$rencana[$key]->jamMulai."</td>
                               <td style='text-align:center;'>".$rencana[$key]->jamSelesai."</td>
                               <td>".$rencana[$key]->alasanlembur."</td>
                               </tr>   
                           "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>

                     }
                     echo $tr;
                
            }
            ?>
    </tbody>
    </table>
   