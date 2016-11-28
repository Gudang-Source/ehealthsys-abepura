<div class="block-tabel">
    <h6>Tabel <b>Pemeriksaan KB</b></h6>
    <table width="100%" id ="pemeriksaanKbYa" class = "table table-striped table-condensed">
        <thead>
            <tr>
                <th style = "text-align:center;"> Jenis </th>
                <th style = "text-align:center;"> Pasang </th>
                <th style = "text-align:center;"> Lepas </th>
                <th style = "text-align:center;"> Batal </th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if (!empty($modRiwayatKehamilan)){
       
        foreach ($modRiwayatKehamilan as $i=>$detail){?>    
            
            <tr>   
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']anak_ke', array('class'=>'', 'readonly'=>TRUE)); echo $detail->anak_ke; ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']keterangan', array('class'=>'', 'readonly'=>TRUE )); echo $detail->keterangan;  ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']keterangan', array('class'=>'', 'readonly'=>TRUE )); echo $detail->keterangan;  ?> </td>       
                <td style = "text-align:center;"> <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRowKb(this); return false;')) ?> </td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
    </table>
</div>
