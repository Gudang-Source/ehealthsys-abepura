<?php 
echo $this->renderPartial('application.views.headerReport.headerAnggaran',array('judulLaporan'=>$judulLaporan, 'deskripsi'=>$deskripsi, 'colspan'=>10));
?>
<style>
    table{
        font-size: 11px;
    }
     .border th, .border td{
        border:1px solid #000;
    }
    .table thead:first-child{
        border-top:1px solid #000;        
    }

    thead th{
        background:none;
        color:#333;
    }

    .border {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
</style>

<div class="row-fluid">
    <table class = "table" style="margin:0px;box-shadow:none;" cellpadding="0" cellspacing="0" >
        <tr>
            <td><b>No. Penyimpanan</b></td>
            <td>:</td>
            <td><?php echo isset($model->nopenyimpamanlinen) ? $model->nopenyimpamanlinen : ""; ?></td>
        </tr>
        <tr>
            <td><b>Tanggal Penyimpanan</b></td>
            <td>:</td>
            <td><?php echo isset($model->tglpenyimpananlinen) ? MyFormatter::formatDateTimeForUser($model->tglpenyimpananlinen) : ""; ?></td>
        </tr>
        <tr>
            <td><b>Pegawai Mengetahui</b></td>
            <td>:</td>
            <td><?php echo (isset($model->pegmengetahui->NamaLengkap) ? $model->pegmengetahui->NamaLengkap : ""); ?></td>
        </tr>
        <tr>
            <td><b>Keterangan</b></td>
            <td>:</td>
            <td><?php echo isset($model->keterangan_penyimpanan) ? $model->keterangan_penyimpanan : ""; ?></td>
        </tr>
    </table><br/>
    <table class="items table border" id="table-detailpemesanan">
        <thead>
            <tr>
                <th>No.</th>
                <th>Lokasi Penyimpanan</th>
                <th>Sub Rak</th>
                <th>No. Pencucian</th>
                <th>Kode Linen</th>
                <th>Nama Linen</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($modDetail) > 0){
                foreach($modDetail AS $i=>$detail){ ?>
            <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo (!empty($detail->lokasipenyimpanan_id) ? $detail->lokasipenyimpanan->lokasipenyimpanan_nama : ""); ?></td>
                <td><?php echo (!empty($detail->rakpenyimpanan_id) ? $detail->rakpenyimpanan->rakpenyimpanan_id : ""); ?></td>
                <td><?php echo (!empty($detail->pencucianlinen_id) ? $detail->pencucianlinen->nopencucianlinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->kodelinen : ""); ?></td>
                <td><?php echo (!empty($detail->linen_id) ? $detail->linen->namalinen : ""); ?></td>
                <td><?php echo $detail->keterangan_penyimpaanlinen; ?></td>
            </tr>
            <?php    }
            }
            ?>
        </tbody>
    </table>
    <table class = "table" style = "box-shadow:none;">
    <tr>
        <td width="100%" align="left" align="top">
            <table width="100%">
                <tr>
                    <td width="35%" align="center">
                       
                    </td>
                    <td width="35%" align="center">
                    </td>
                    <td width="35%" style="text-align:center">
                        <div style="font-size: 11px;">Mengetahui</div>
                        <div style="margin-top:60px;font-size: 11px;"><?php echo isset($model->pegmengetahui->nama_pegawai) ? $model->pegmengetahui->nama_pegawai : "-"; ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
</div>
<?php
if (isset($_GET['frame'])){
    echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";     
?>
<?php 
    

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/InformasiPenyimpananLinen/Detail');
?>
    <script type="text/javascript">
function print(caraPrint)
{
    var penyimpananlinen_id = '<?php echo isset($model->penyimpananlinen_id) ? $model->penyimpananlinen_id : null; ?>';
    window.open('<?php echo $url; ?>&id='+penyimpananlinen_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
</script>
<?php
}?>

