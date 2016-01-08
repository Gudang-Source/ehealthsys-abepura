<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Perawatan</td>
            <td>:</td>
            <td><?php echo isset($model->noperawatan) ? $model->noperawatan : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Perawatan</td>
            <td>:</td>
            <td><?php echo isset($model->tglperawatanlinen) ? MyFormatter::formatDateTimeForUser($model->tglperawatanlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegmengetahui->NamaLengkap) ? $model->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->keterangan_perawatan) ? $model->keterangan_perawatan : ""; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>No. Penerimaan</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
                <th>Status Perawatan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->ruangan_id) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->penerimaanlinen_id) ? $detail->penerimaanlinen->nopenerimaanlinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->keteranganperawatan; ?></td>
                <td><?php echo $detail->statusperawatanlinen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>