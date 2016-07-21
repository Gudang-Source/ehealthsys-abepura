<?php 
$dataArray = array();
$header = true;
$format = new MyFormatter();
$mergeTanggal = array();
foreach($models AS $row => $data){ 
    $dataArray["$data->jenisdiet_id"]["jenisdiet_id"] = $data->jenisdiet_id;
    $dataArray["$data->jenisdiet_id"]["jenisdiet_nama"] = $data->jenisdiet_nama;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["tglkirimmenu"] = date('d-m-Y',strtotime($data->tglkirimmenu));
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jml_kirim"] =  number_format($data->jml_kirim);
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_id"] = $data->jeniswaktu_id;
    $dataArray["$data->jenisdiet_id"]["$data->jeniswaktu_id"]["jeniswaktu_nama"] = $data->jeniswaktu_nama;
} 
?>
<table class="table table-striped table-condensed">
    <thead>
    <?php 
        $jmlKolom = 0;
        $jenisWaktus = array();
        $tglKirims = array();
        echo "<tr>";
        echo "<th rowspan=2>No.</th>";
        echo "<th rowspan=2>Uraian dan Jenis Diet</th>";
        foreach ($dataArray AS $i => $datas){
            foreach($datas AS $j => $data){                
                if(is_array($data)){
                    $tglKirims[$jmlKolom] = $data['tglkirimmenu'];
//                    if($tglKirims[$jmlKolom-1] == $tglKirims[$jmlKolom]){
//                        echo "<th>";
//                        echo CustomFunction::getNamaHari($data['tglkirimmenu']);
//                        echo "</th>";
//                    }else{
                        echo "<th>";
//                        echo CustomFunction::getNamaHari($data['tglkirimmenu'])." ".$data['tglkirimmenu'];
						  echo date("j F Y", strtotime($data['tglkirimmenu']));
						echo "</th>";
//                    }
                    $jmlKolom ++;
                }
            }
        }
        echo "</tr>";
        $jmlKolom = 0;
        echo "<tr>";
        foreach ($dataArray AS $i => $datas){
            foreach($datas AS $j => $data){
                if(is_array($data)){
                    echo "<th>";
                    echo $data['jeniswaktu_nama'];
                    echo "</th>";
                    $jenisWaktus[$jmlKolom] = $data['jeniswaktu_id'];
                    $jmlKolom ++;
                }
            }
        }
        echo "</tr>";
    ?>
    </thead>
    <tbody>
        <?php

        $no = 1;
        $jml = array();
        
        foreach ($dataArray AS $i => $datas){
            echo "<tr>";
            echo "<td>".$no."</td>";
            echo "<td>";
            echo $datas['jenisdiet_nama'];
            echo "</td>";
            //cari data jml dan masukan ke array $jml[]
            
            for($x = 0;$x < $jmlKolom;$x++){
                $jml[$x] = 0;
                foreach($datas AS $j => $data){
                    if(is_array($data)){                        
                        if($data['jeniswaktu_id'] == $jenisWaktus[$x] && $data['tglkirimmenu'] == $tglKirims[$x]){
                            $jml[$x] = $data['jml_kirim'];
                        }
                    }
                }
                
            }
            //tampilkan array $jml[]
            for($x = 0;$x < $jmlKolom;$x++){
                echo "<td>";
                echo $jml[$x];
                echo "</td>";
            }
            echo "</tr>";
            $no ++;
        }
        
        ?>
        
    </tbody>
    
</table>