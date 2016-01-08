<table class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.</th>
        <th><?php echo CHtml::activeLabel($models[0], "nilaiuang"); ?></th>
        <th><?php echo CHtml::activeLabel($models[0], "banyakuang"); ?></th>
        <th><?php echo CHtml::activeLabel($models[0], "jumlahuang"); ?></th>
    </thead>
    <tbody>
        <?php  
        if(count($models) > 0){
            $no = 1;
            foreach($models as $i => $model){
                if($model->banyakuang > 0){
                    echo "<tr>";
                    echo "<td>".($no)."</td>";
                    echo "<td> Rp. ".number_format($model->nilaiuang)."</td>";
                    echo "<td>".number_format($model->banyakuang)."</td>";
                    echo "<td> Rp. ".number_format($model->jumlahuang)."</td>";
                    echo "</tr>";
                    $no ++;
                }
            }
        }else{
            echo "<tr><td>Data tidak ditemukan</td></tr>";
        }
        ?>
    </tbody>
</table>
