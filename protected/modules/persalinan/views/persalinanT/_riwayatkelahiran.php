<div class="block-tabel">
    <table width="100%" id ="riwayatkelahiran" class = "table table-striped table-condensed">
        <thead>
            <tr>
                <th style = "text-align:center;"> Anak Ke - </th>
                <th style = "text-align:center;"> Keterangan </th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if (!empty($modRiwayatKelahiran)){
       
        foreach ($modRiwayatKelahiran as $i=>$detail){?>    
            
            <tr>   
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']anak_ke', array('class'=>'', 'readonly'=>TRUE)); echo $detail->anak_ke; ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']keterangan', array('class'=>'', 'readonly'=>TRUE )); echo $detail->keterangan;  ?> </td>       
            </tr>   
        <?php }
        }
        ?>
    </tbody>
    </table>
</div>
