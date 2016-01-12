<?php

class DashboardController extends MyAuthController
{
	public $layout='//layouts/column1';
    public $defaultAction = 'index';
						
	public function actionIndex()
	{	
		$modMenu = new MenumodulK;
		$kelompokMenu = KelompokmenuK::model()->findAllAktif();
		$menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id'],'t.kelmenu_id'=>Yii::app()->session['kelMenu']));
		$this->render('index',array(
					'kelompokMenu'=>$kelompokMenu,
					'menu'=>$menu,
					'modMenu'=>$modMenu,
		));
	}
        /**
         * set list pencarian menu
         */
        public function actionSetListPencarianMenu(){
            if (Yii::app()->request->isAjaxRequest){
                $content = "";
                parse_str($_POST['data'], $post);
                $postPencarian = $post['MenumodulK'];
                    $criteria = new CDbCriteria;
                    $criteria->compare('LOWER(menu_nama)',strtolower($postPencarian['menu_nama']), true);
					$criteria->addCondition('modul_id = '.Yii::app()->session['modul_id']);
					$criteria->addCondition('menu_aktif IS TRUE');
                    $criteria->order = 'menu_urutan';
                    $modPencarianMenu = MenumodulK::model()->findAll($criteria);
                    $content = $this->renderPartial('_listMenu',array('modPencarianMenu'=>$modPencarianMenu), true);
                echo CJSON::encode(array(
                    'content'=>$content));
                Yii::app()->end();
            }
        }  
}
