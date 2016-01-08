<div class="block-tabel">
    <h6>Riwayat Pemakaian <b>Obat & Kesehatan</b></h6>
    <table class="table table-striped" id="riwayat-obatalkespasien-t">
        <thead>
            <tr>
                <th>Tanggal Pemakaian</th>
                <th>Nama Obat Alkes</th>
                <th>Jumlah</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($modViewBmhp as $i => $bmhp) { ?>
    <tr>
        <td >
            <?php echo $bmhp->tglpelayanan; ?>
        </td>
        <td>
            <?php echo $bmhp->obatalkes->obatalkes_nama; ?>
        </td>
        <td>
            <?php echo $bmhp->qty_oa; ?>
            <?php //echo $bmhp->satuankecil->satuankecil_nama; ?>
        </td>
        <td>
            <a onclick="hapusOaPasien('<?php echo $bmhp->obatalkespasien_id; ?>',this);return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Obat / Alat Kesehatan"><i class="icon-trash"></i></a>
        </td>
    </tr>
    <?php } ?>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    function hapusOaPasien(obatalkespasien_id,obj)
    {
        tabel = obj;
        myConfirm('Apakah anda akan menghapus obat / alat kesehatan ini?', 'Perhatian!', function(r)
        {
            if(r){
                $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('hapusObatAlkesPasien'); ?>',
                    data: {obatalkespasien_id:obatalkespasien_id},
                    dataType: "json",
                    success:function(data){
                        if(data.sukses){
                            var delete_row = $(tabel).parents('tr');
                            delete_row.detach();
                        }
                        myAlert(data.pesan);
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                });

            }
        });
    }
</script>