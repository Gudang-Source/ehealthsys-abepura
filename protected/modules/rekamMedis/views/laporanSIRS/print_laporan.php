<style>
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

    .table {
        box-shadow:none;
    }

    .table tbody tr:hover td, .table tbody tr:hover th {
        background-color: none;
    }
    </style>
<?php $data=ProfilrumahsakitM::model()->findByPk(Params::DEFAULT_PROFIL_RUMAH_SAKIT); ?>
<?php
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$title.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');     
    }
?>
<table  style="width:100%;font-size: 11px;">
    <tbody>
    <tr>
        <td width="5%" style="border-bottom: 3px solid #000000;">
            <img src="<?php echo Yii::app()->request->baseUrl . "/images/bhakti_husada.jpg"; ?>" width="80"/>
        </td>
        <td width="45%"  align="left" VALIGN=MIDDLE style="border-bottom: 3px solid #000000;">
            <?php echo($formulir);?><br><?php echo($title);?></br>
        </td>
        <td width="50%" style="border-bottom: 3px solid #000000;">
            <div style="border:1px solid #AEAEAE;font-size:9px;font-style: italic;border-style: dotted;padding: 10px;">
                Ditjen Bina Upaya Kesehatan<br>
                Kementrian Kesehatan RI
            </div>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    </tbody>
</table>
    
<table cellpadding="0" cellspacing="0" width='100%' border="0">
    <tr>
        <td width="50%">
            <table border="0">
                <tr>
                    <td width="100">Kode RS</td>
                    <td width="180">: <?php echo (isset($data->nokode_rumahsakit) ? $data->nokode_rumahsakit : "-"); ?></td>
                </tr>
                <tr>
                    <td>Nama RS</td>
                    <td>: <?php echo $data->nama_rumahsakit ?></td>
                </tr>
                <tr>
                    <td>Tahun</td>
                    <td>: <?=date('Y')?></td>
                </tr>
            </table>                        
        </td>
        <td width="50%">
            <table border="0" >
                <tr>
                    <td width="100">Kab/Kota</td>
                    <td width="180">: <?php echo isset($data->kabupaten->kabupaten_nama) ? $data->kabupaten->kabupaten_nama : "-"; ?></td>
                </tr>
                <tr>
                                                    <td>Kode Propinsi</td>
                    <td>: <?php echo isset($data->propinsi->kode_propinsi) ? $data->propinsi->kode_propinsi : "-"; ?></td>
                </tr>
                <tr>
                    <td>Periode</td>
                    <td>: <?=$periode?></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
   

<?=$table;?>
       