<?php
namespace common\controllers;

use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Url;

class ApiAuthController extends CommonController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [//通过url上access_token来检测用户登陆状态
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if ($status = parent::beforeAction($action)) {
            if ($status == 'no_access')
                $this->flash(['code' => 3002]);
            
            if (Yii::$app->user->isGuest) //判断是否登录
                $this->flash(['code' => 3003, 'res' => ['login_url' => Url::to(Yii::$app->user->loginUrl)]]);

            if (!$this->isAuth(Yii::$app->user->id, $action)) //判断用户是否有权限执行操作
                $this->flash(['code' => 3002]);
            
            return true;
        }

        return false;
    }
}
