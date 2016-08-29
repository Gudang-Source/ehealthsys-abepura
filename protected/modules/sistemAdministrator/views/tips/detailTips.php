<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<table width = "100%">   
    <?php
        $total = ceil(count($tips)/2);
        $petunjuk = Tips::getTips();
      //  var_dump($tips);die;
        $a=1;
        for ($i=0;$i<count($tips);$i++){
            echo '<tr><td style = "vertical-align:middle">'.$a.'</td><td style = "vertical-align:middle;">'.$petunjuk[$tips[$i]].'<td></tr>';                                  
            $a++;
        }
    ?>        
</table>