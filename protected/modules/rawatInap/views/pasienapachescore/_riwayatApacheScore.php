
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
                    <th>Tanggal Scoring</th>
                    <th><center>Nama Point</center></th>  
                    <th><center>Nilai Point</center></th>  
                    <th><center>Score Point</center></th>  
                    <th><center>Catatan Apache Score</center></th>  
                </tr>
            </thead>
            <tbody>
                <?php echo $tr; ?>
            </tbody>
            <tfoot>
                <tr>
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
    Tidak ada data riwayat apachescore pasien
</div>

<?php   
}
?>