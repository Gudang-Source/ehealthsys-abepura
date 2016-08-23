<style>
    .border{
        border:1px solid #000;
    }    
    .table thead:first-child tr th{
        border-top: 1px #000 solid;
    }
    thead th{
        background:none;
        color:#000;    
    }
</style>
<fieldset>
    <table  style="width:50%;box-shadow: none;" cellpadding="0" cellspacing="0" class = "table">
        <tr>
            <td>No. Pencucian</td>
            <td>:</td>
            <td><?php echo $model->nopencucianlinen; ?></td>
            <td></td>
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
    <table style = "box-shadow: none;border-top:1px;" class="table" id="table-detailpemesanan">
        <thead>
            <tr>
                <th class = "border">No.</th>
                <th class = "border">Ruangan Asal</th>
                <th class = "border">Kode Linen</th>
                <th class = "border">Nama Linen</th>
                <th class = "border">Status Pencucian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ;?>
            <tr>
                <td class = "border"><?php echo $i+1; ?></td>
                <td class = "border"><?php echo (!empty($detail->penerimaanlinen_id) ? $detail->penerimaanlinen->pengPerawatan->ruangan->ruangan_nama : ""); ?></td>
                <td class = "border"><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td class = "border"><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td class = "border"><?php echo $detail->statuspencucian; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>