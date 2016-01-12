<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->kirimperlinensteril_no) ? $model->kirimperlinensteril_no : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->kirimperlinensteril_tgl) ? MyFormatter::formatDateTimeForUser($model->kirimperlinensteril_tgl) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pengiriman</td>
            <td>:</td>
            <td><?php echo (isset($model->pegawaiMengirim->NamaLengkap) ? $model->pegawaiMengirim->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->kirimperlinensteril_ket) ? $model->kirimperlinensteril_ket : ""; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Nama Peralatan</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->kirimperlinensteril->ruangan_id) ? $detail->kirimperlinensteril->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->barang->barang_id) ? $detail->barang->barang_id : ""); ?></td>
                <td><?php echo (!empty($detail->kirimperlinensterildet_jml) ? $detail->kirimperlinensterildet_jml : ""); ?></td>
                <td><?php echo (!empty($detail->kirimperlinensterildet_ket) ? $detail->kirimperlinensterildet_ket : ""); ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>