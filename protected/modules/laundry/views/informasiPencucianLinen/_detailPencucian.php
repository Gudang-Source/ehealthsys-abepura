<fieldset>
    <table width="74%" style="margin:0px;" cellpadding="0" cellspacing="0">
        <tr>
            <td>No. Pencucian</td>
            <td>:</td>
            <td><?php echo $model->nopencucianlinen; ?></td>
        </tr>
        <tr>
            <td>Tanggal Perawatan</td>
            <td>:</td>
            <td><?php echo isset($model->tglpencucianlinen) ? MyFormatter::formatDateTimeForUser($model->tglpencucianlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Mengetahui</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpenerima->NamaLengkap) ? $model->pegpenerima->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo $model->keterangan_pencucianlinen; ?></td>
        </tr>
    </table><br/>
    <table class="items table table-striped table-bordered table-condensed" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Ruangan Asal</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Status Pencucian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->create_ruangan) ? $detail->ruangan->ruangan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->statuspencucian; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>