
<?php
if(!empty($tr)){
?>
       <div id="tablehide">
           <?php $this->widget('bootstrap.widgets.BootPager', array(
                    'pages' => $pages,    
                    'header'=>'<div class="pagination" id="pagin">',
                    'footer'=>'</div>',
           )); ?>
            <table class="items table table-striped table-bordered table-condensed" >
            <thead>
                <tr >
                    <th rowspan="2">Tgl. Kunjungan/<br/>No.Pendaftaran</th>
                    <th colspan ="2"><center>Anamnesis</center></th>  
                    <th colspan ="4"><center>Pemeriksaan Fisik</center></th>  
                    <th rowspan="2"><center>Nama Diagnosa</center></th>  
                    <th valign='middle' rowspan="2"><center>Tanggal Asuhan Keperawatan</center></th>  
                    <th rowspan="2"><center>Diagnosa Keperawatan</center></th>  
                    <th valign='middle' rowspan="2"><center>Rencana</center></th>  
                    <th valign='middle' rowspan="2"><center>Evaluasi</center></th>  
                    <th valign='middle' rowspan="2"><center>Planning</center></th>  
                </tr>
                <tr>
                    <th><center>Keluhan Utama</center></th>  
                    <th><center>Riwayat Penyakit</center></th>  
                    <th><center>TD</center></th>  
                    <th><center>DN</center></th>  
                    <th><center>ST</center></th>  
                    <th><center>TB/BB</center></th>  
                </tr>
            </thead>
            <tbody>
                <?php 
                    echo $tr;
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                    
                </tr>
            </tfoot>
        </table>
            </div>
        
        
<?php
} else {
?>
<div class="alert alert-block alert-error">
    <a class="close" data-dismiss="alert">×</a>
    Tidak ada data Riwayat Asuhan Keperawatan pasien
</div>

<?php   
}
?>