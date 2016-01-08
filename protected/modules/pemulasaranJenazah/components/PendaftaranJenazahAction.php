<?php

class PendaftaranJenazahAction extends CAction
{
    public $pasien;
    
    
    public function run()
    {
        $this->controller->layout = '//layouts/column1';
        $this->controller->render('index');
    }
}
?>
