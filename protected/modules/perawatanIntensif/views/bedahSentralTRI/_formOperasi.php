<table width="100%">
    <tr>
        <td>
        <div id="formOperasi">
    <?php foreach($modKegiatanOperasi as $i=>$kegiatanOperasi){ 
            $ceklist = false;
    ?>
            <div class="boxtindakan">
                <h6><?php echo $kegiatanOperasi->kegiatanoperasi_nama; ?></h6>
                <?php foreach ($modOperasi as $j => $operasi) {
                         if($kegiatanOperasi->kegiatanoperasi_id == $operasi->kegiatanoperasi_id) {
                             echo '<label class="checkbox inline">'.CHtml::checkBox("operasi[]", $ceklist, array('value'=>$operasi->operasi_id,
                                                                                      'onclick' => "inputOperasi(this);"));
                             echo "<span>".$operasi->operasi_nama."</span></label><br/>";
                         }
                     } ?>
            </div>
    <?php } ?>
        </div>
        </td>
    </tr>
</table>
<script>
    $('#formOperasi').tile({widths : [ 198 ]});
</script>