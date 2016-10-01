<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<table width = "100%">   
    <?php
        $total = ceil(count($tips)/2);
        $petunjuk = Tips::getTips();
      //  var_dump($tips);die;
        $a=1;
        for ($i=0;$i<count($tips);$i++){
            
            if ($tips[$i] == 'bootaccordion'){
                echo "<tr><td style = 'vertical-align:middle'>".$a."</td><td style = 'vertical-align:middle'>";
                    $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
                    'id' => 'tips-accordition',
                    'content' => array(
                        'content-tips' => array(
                            'header' => CHtml::htmlButton("<i class='icon-minus icon-white'></i>", array('class' => 'btn btn-primary btn-mini', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk menampilkan data')).' Judul Header',
                            'isi' => 'Data',
                            'active' => false,
                        ),
                    ),
                ));
                    echo "<br/> berfungsi untuk menampilkan data, jika header di klik. </td></tr>";
            }else{
               echo '<tr><td style = "vertical-align:middle">'.$a.'</td><td style = "vertical-align:middle;">'.$petunjuk[$tips[$i]].'<td></tr>';                                   
            }
            $a++;
        }
    ?>        
</table>