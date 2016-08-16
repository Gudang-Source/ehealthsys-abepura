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
            <td>No. Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->nopengirimanlinen) ? $model->nopengirimanlinen : ""; ?></td>
        </tr>
        <tr>
            <td>Tanggal Pengiriman</td>
            <td>:</td>
            <td><?php echo isset($model->tglpengirimanlinen) ? MyFormatter::formatDateTimeForUser($model->tglpengirimanlinen) : ""; ?></td>
        </tr>
        <tr>
            <td>Pegawai Pengirim</td>
            <td>:</td>
            <td><?php echo (isset($model->pegpengirim->NamaLengkap) ? $model->pegpengirim->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td><?php echo isset($model->keterangan_perawatan) ? $model->keterangan_perawatan : ""; ?></td>
        </tr>
    </table><br/>
   <table style = "box-shadow: none;border-top:1px;" class="table" id="table-detailpemesanan">
        <thead>
            <tr>
                <th class = "border">No.</th>
                <th  class = "border">Ruangan Tujuan</th>
                <th  class = "border">No. Penerimaan</th>
                <th  class = "border">Kode Linen</th>
                <th  class = "border">Nama Linen</th>
                <th  class = "border">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td  class = "border"><?php echo $i+1; ?></td>
                <td  class = "border"><?php echo (!empty($detail->pengirimanlinen_id) ? $detail->pengirimanlinen->ruangan->ruangan_nama : ""); ?></td>
                <td  class = "border"><?php echo (!empty($detail->pengirimanlinen_id) ? $detail->pengirimanlinen->nopengirimanlinen : ""); ?></td>
                <td  class = "border"><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td  class = "border"><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td  class = "border"><?php echo $detail->keterangan_linen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
</fieldset>