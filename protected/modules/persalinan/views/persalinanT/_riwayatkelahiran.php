<div class="block-tabel"> 
    <h6>Tabel <b>Riwayat kehamilan</b></h6>
    <table width="100%" id ="riwayatkelahiran" class = "table table-striped table-condensed">
        <thead>
            <tr>
                <th style = "text-align:center;"> Anak Ke - </th>
                <th style = "text-align:center;"> Keterangan </th>
                <th style = "text-align:center;"> Batal </th>
            </tr>
        </thead>
        <tbody>
        <?php 
        if (!empty($modGinekologi->pemeriksaanginekologi_id)){
            $modRiwayatKehamilan = PSRiwayatkehamilanT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' ");
        }else{
            $modRiwayatKehamilan = '';
        }
                
        if (!empty($modRiwayatKehamilan)){
       
        foreach ($modRiwayatKehamilan as $i=>$detail){?>    
            
            <tr>   
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']anak_ke', array('class'=>'', 'readonly'=>TRUE)); echo $detail->anak_ke; ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']keterangan', array('class'=>'', 'readonly'=>TRUE )); echo $detail->keterangan;  ?> </td>       
                <td style = "text-align:center;"> <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRow(this); return false;')) ?> </td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
    </table>
</div>
