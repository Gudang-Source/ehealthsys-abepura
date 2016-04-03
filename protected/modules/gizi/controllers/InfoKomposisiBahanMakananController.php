<?php
    class InfoKomposisiBahanMakananController extends MyAuthController
    {
            public function actionIndex()
            {
                    $modKomposisiBahanMakanan = new GZBahanMakananM;
                    
                    if(isset($_REQUEST['GZBahanMakananM'])){
                        $modKomposisiBahanMakanan->attributes=$_REQUEST['GZBahanMakananM'];
                    }
                    $this->render('index',array('modKomposisiBahanMakanan'=>$modKomposisiBahanMakanan));
            }

    }

?>