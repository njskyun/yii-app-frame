<?php
namespace common\models;

use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "sky_menu".
 *
 * @property integer $menu_id
 * @property string $name
 * @property string $alias_name
 * @property integer $parent_id
 * @property string $parent_ids
 * @property string $child_ids
 * @property string $app
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $params
 * @property string $auth_item
 * @property string $auth_rules
 * @property integer $status
 * @property integer $sort
 * @property integer $type
 * @property string $class
 * @property string $icon
 * @property string $remark
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $creater_id
 * @property string $creater_ip
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sky_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'status', 'sort', 'type', 'create_time', 'update_time', 'creater_id'], 'integer'],
            [['name', 'alias_name', 'class'], 'string', 'max' => 50],
            [['parent_ids', 'auth_rules', 'remark'], 'string', 'max' => 255],
            [['child_ids'], 'string', 'max' => 1024],
            [['app', 'icon'], 'string', 'max' => 20],
            [['module', 'controller', 'action', 'params'], 'string', 'max' => 30],
            [['auth_item'], 'string', 'max' => 64],
            [['creater_ip'], 'string', 'max' => 63],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'menu_id' => 'Menu ID',
            'name' => 'Name',
            'alias_name' => 'Alias Name',
            'parent_id' => 'Parent ID',
            'parent_ids' => 'Parent Ids',
            'child_ids' => 'Child Ids',
            'app' => 'App',
            'module' => 'Module',
            'controller' => 'Controller',
            'action' => 'Action',
            'params' => 'Params',
            'auth_item' => 'Auth Item',
            'auth_rules' => 'Auth Rules',
            'status' => 'Status',
            'sort' => 'Sort',
            'type' => 'Type',
            'class' => 'Class',
            'icon' => 'Icon',
            'remark' => 'Remark',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'creater_id' => 'Creater ID',
            'creater_ip' => 'Creater Ip',
        ];
    }
    
    /**
     * 根据AppID/ModuleID/ControllerID/ActionID获取记录
     */
    public static function getMenu($item)
    {
        $menu = static::findOne(['auth_item' => $item]);
        
        if ($menu) {
            return $menu;
        } else {
            return false;
        }
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->auth_item = $this->app . '/' . (isset($this->module)?$this->module.'/':'') . $this->controller.'/' . $this->action;
            
            return true;
        } else {
            return false;
        }
    }
}