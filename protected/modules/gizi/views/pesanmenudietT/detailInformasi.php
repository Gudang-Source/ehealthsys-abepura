<table class='table'>
    <tr>
        <td>
            <b><?php echo CHtml::encode($modPesan->getAttributeLabel('jenispesanmenu')); ?>:</b>
            <?php echo CHtml::encode($modPesan->jenispesanmenu); ?>
            <br />
            <b><?php echo CHtml::encode($modPesan->getAttributeLabel('nopesanmenu')); ?>:</b>
            <?php echo CHtml::encode($modPesan->nopesanmenu); ?>
            <br />
            

        </td>
        <td>
            <b><?php echo CHtml::encode($modPesan->getAttributeLabel('ruangan_id')); ?>:</b>
            <?php echo CHtml::encode($modPesan->ruangan->ruangan_nama); ?>
            <br />
            <b><?php echo CHtml::encode($modPesan->getAttributeLabel('tglpesanmenu')); ?>:</b>
            <?php echo CHtml::encode(MyFormatter::formatDateTimeForUser($modPesan->tglpesanmenu)); ?>
            <br/>
        </td>
    </tr>   
</table>
<style>
    .table thead tr th{
        vertical-align:middle;
    }
</style>
<?php if ($modPesan->jenispesanmenu == Params::JENISPESANMENU_PASIEN) { ?>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2">No.Urut</th>
                <th rowspan="2">Instalasi</th>
                <th rowspan="2">Ruangan</th>
                <th rowspan="2">No. Pendaftaran</th>
                <th rowspan="2">No. Rekam Medik</th>
                <th rowspan="2">Nama Pasien</th>
                <th rowspan="2">Umur</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
    <th rowspan="2">Jumlah</th>
    <th rowspan="2">Satuan/URT</th>
    </tr>
    <tr>
        <?php
        foreach (JeniswaktuM::getJenisWaktu() as $row) {
            echo '<th>' . $row->jeniswaktu_nama . '</th>';
        }
        ?>
    </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetailPesan AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $modPesan->ruangan->ruangan_nama . "</td>
            <td>" . $tampilData->pendaftaran->no_pendaftaran . "</td>   
            <td>" . $tampilData->pasien->no_rekam_medik . "</td>   
            <td>" . $tampilData->pasien->namadepan.$tampilData->pasien->nama_pasien . "</td>   
            <td>" . $tampilData->pendaftaran->umur . "</td>   
            <td>" . $tampilData->pasien->jeniskelamin . "</td>";

            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = PesanmenudetailT::model()->with('menudiet')->findByAttributes(array('pendaftaran_id' => $tampilData->pendaftaran_id, 'pasienadmisi_id' => $tampilData->pasienadmisi_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id));
                if (empty($detail->menudiet_id)) {
                    echo "<td><center>-</center></td>";
                } else {
                    echo "<td>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td style='text-align: right !important;'>" . $tampilData->jml_pesan_porsi . "</td>
            <td>" . $tampilData->satuanjml_urt . "</td>";
            "
          </tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>

<?php } else { ?>
    <table id="tableObatAlkes" class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th rowspan="2">No.Urut</th>
                <th rowspan="2">Instalasi</th>
                <th rowspan="2">Ruangan</th>
                <th rowspan="2">Nama Pegawai/Tamu</th>
                <th rowspan="2">Jenis Kelamin</th>
                <th colspan="<?php echo count(JeniswaktuM::getJenisWaktu()); ?>"><center>Menu Diet</center></th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Satuan/URT</th>
            </tr>
            <tr>
                <?php
                foreach (JeniswaktuM::getJenisWaktu() as $row) {
                    echo '<th>' . $row->jeniswaktu_nama . '</th>';
                }
                ?>
            </tr>
        </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($modDetailPesan AS $tampilData):
            echo "<tr>
            <td>" . $no . "</td>
            <td>" . $modPesan->ruangan->instalasi->instalasi_nama . "</td>  
            <td>" . $modPesan->ruangan->ruangan_nama . "</td>";
            if (!empty($tampilData->pegawai->nama_pegawai)) {
                echo "<td>" . $tampilData->pegawai->nama_pegawai . "</td>   
            <td>" . $tampilData->pegawai->jeniskelamin . "</td>";
            } else {
                echo "<td>Tamu " . $no . "</td>   
            <td><center>-</center></td>";
            }
            foreach (JeniswaktuM::getJenisWaktu() as $row) {
                $detail = PesanmenupegawaiT::model()->with('menudiet')->findByAttributes(array('pegawai_id' => $tampilData->pegawai_id, 'pesanmenudiet_id' => $tampilData->pesanmenudiet_id, 'jeniswaktu_id' => $row->jeniswaktu_id, ));
                if (empty($detail->menudiet_id)) {
                    echo "<td><center>-</center></td>";
                } else {
                    echo "<td>" . $detail->menudiet->menudiet_nama . "</td>";
                }
            };

            echo "<td>" . $tampilData->jml_pesan_porsi . "</td>
            <td>" . $tampilData->satuanjml_urt . "</td>";
            "
          </tr>";
            $no++;

        endforeach;
        ?>
    </tbody>
    </table>
<?php } ?>