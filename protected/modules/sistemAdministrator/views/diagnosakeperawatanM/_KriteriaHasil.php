<?php
$modKriteriaHasil=  KriteriahasilM::model()->findAll('diagnosakep_id='.$diagnosakeperawatan_id.'');
if(COUNT($modKriteriaHasil)>0)
    {
        echo "<ul>";
        foreach($modKriteriaHasil as $i=>$namaKriteria)
        {
            echo '<li>'.$namaKriteria->kriteriahasil_nama.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

