<?php
$implementasi_id=  ImplementasikeperawatanM::model()->with('implementasikeperawatan')->findByPk($implementasikeperawatan_id)->diagnosakeperawatan_id;
$modImplementasiId = LookupM::model()->findAllByAttributes(array('diagnosakeperawatan_id'=>$implementasi_id));
if(COUNT($modLookup)>0)
    {
        echo "<ul>";
        foreach($modImplementasiId as $i=>$implementasi_id)
        {
            echo '<li>'.$diagnosakeperawatan_id->implementasikeperawatan->rencanakeperawatan_id.'</li>';
        }
        echo "</ul>";
    }
else
    {
        echo "Belum di Set";
    }   
?>

