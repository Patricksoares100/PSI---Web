<?php

namespace backend\modules\api;

/**
 * api module definition class
 */
class APIModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        //PPT8 slide 5 e 6
        \Yii::$app->user->enableSession = false;
        // custom initialization code goes here
    }
}
