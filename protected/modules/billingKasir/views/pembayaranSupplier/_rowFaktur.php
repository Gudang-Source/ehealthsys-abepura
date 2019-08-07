<?php 
$totalppn = 0;
$totalpph = 0;
$hargappn = 0;
$hargappnfaktur = 0;
$hargapph = 0;
$hargapphfaktur = 0;
if(count($modDetailBeli)>0){
    foreach ($modDetailBeli as $i => $detail) { 
        if($detail->persenppnfaktur <= 0) {
            $hargappnfaktur = 0;
        }else{
            $hargappn = $detail->harganettofaktur * ($detail->persenppnfaktur / 100);
            $hargappnfaktur = $detail->harganettofaktur + $hargappn;
        }
        if($detail->persenpphfaktur <= 0) {
            $hargapphfaktur = 0;
        }else{
            $hargapph = $detail->harganettofaktur * ($detail->persenpphfaktur / 100);
            $hargapphfaktur = $detail->harganettofaktur + $hargapph;
        }

        ?>
        <tr>
            <td>
                <?php echo $detail->obatalkes->obatalkes_nama; ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->jmlterima); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->harganettofaktur); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->hargasatuan); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($hargappnfaktur); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($hargapphfaktur); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->persendiscount); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->jmldiscount); ?>
            </td>
            <td style="text-align: right;">
                <?php echo MyFormatter::formatNumberForPrint($detail->jmlterima * $hargappnfaktur); ?>
            </td>
        </tr>
    <?php 

    }
}
?>

