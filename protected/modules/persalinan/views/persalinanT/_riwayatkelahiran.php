<div class="block-tabel">
    <table width="100%">
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
                <td> <?php var_dump($modRiwayatKelahiran);//echo Chtml::activeTextField($detail, '['.$i.']anak_ke', array('class'=>'span1 numbersOnly mutasi')); ?> </td>       
            </tr>   
        <?php }
        }
        ?>
    </tbody>
    </table>
</div>
