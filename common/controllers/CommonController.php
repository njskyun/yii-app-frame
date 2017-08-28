<?php
namespace common\controllers;

use Yii;
use yii\web\Controller;

class CommonController extends Controller 
{
    public function getActions()
    {
        return [
            //列表操作
            'list' => [
                'class' => 'common\actions\ApiListAction',
            ],
            //新增操作
            'create' => [
                'class' => 'common\actions\ApiCreateAction',
            ],
            //更新操作
            'update' => [
                'class' => 'common\actions\ApiUpdateAction',
            ],
            //删除操作
            'delete' => [
                'class' => 'common\actions\ApiDeleteAction',
            ],
            //导入操作
            'import' => [
                'class' => 'common\actions\ApiImportAction',
            ],
            //导出操作
            'export' => [
                'class' => 'common\actions\ApiExportAction',
            ],
        ];
    }
    
    /**
     * 判断是否有执行节点action的权限
     */
    public function isAuth($userID, $action)
    {
        $permissionName =  Yii::$app->id . '/' . $action->uniqueId;//权限节点
        
        if (Yii::$app->authManager->checkAccess($userID, $permissionName)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function flash($data = [])
    {
        if (!$data || !is_array($data)) exit(json_encode($data));
        
        $data['code'] = isset($data['code']) ? $data['code'] : 1001;
        $data['msg'] = isset($data['msg']) ? $data['msg'] : $this->getMsgByCode($data['code']);
        $data['res'] = isset($data['res']) ? $data['res'] : [];

        exit(json_encode($data));
    }
    
    public function getMsgByCode($code)
    {
        $codeMsg = [
            '1001' => '操作成功',
            '3001' => '操作失败',
            '3002' => '无权限访问',
            '3003' => '请登录',
            '3004' => '登陆失败',
            '3005' => '用户名或密码错误',
        ];
        
        return isset($codeMsg[$code]) ? $codeMsg[$code] : '';
    }
}
