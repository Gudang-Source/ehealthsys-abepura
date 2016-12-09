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
        $KBYa = PSRiwayatkbT::model()->findAll(" pemeriksaanginekologi_id = '".$modGinekologi->pemeriksaanginekologi_id."' AND kb_status = TRUE");
        if (!empty($KBYa)){
       
        foreach ($KBYa as $i=>$detail){?>    
            
            <tr>   
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']kb_jenis', array('class'=>'', 'readonly'=>TRUE)); echo $detail->kb_jenis; ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']kb_pasang', array('class'=>'', 'readonly'=>TRUE )); echo MyFormatter::formatDateTimeForUser($detail->kb_pasang);  ?> </td>       
                <td> <?php echo Chtml::activeHiddenField($detail, '['.$i.']kb_lepas', array('class'=>'', 'readonly'=>TRUE )); echo MyFormatter::formatDateTimeForUser($detail->kb_lepas);  ?> </td>       
                <td style = "text-align:center;"> <?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>'delRowKb(this); return false;')) ?> </td>
            </tr>   
        <?php }
        }
        ?>
    </tbody>
    </table>
</div>
