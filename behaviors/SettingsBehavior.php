<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 02.09.2015
 * Time: 20:58
 *
 * @property \yii\db\ActiveRecord $owner
 */

namespace app\admin\behaviors;


use yii\base\Behavior;
use yii\base\Object;
use yii\helpers\ArrayHelper;

class SettingsBehavior extends Behavior
{
    public $getter = 'settings';
    public $relationName = '';
    private $_settings = false;

    public function __get($name)
    {
        if (isset($this->settings[$name]))
            return $this->settings[$name];

        return parent::__get($name);
    }

    public function __isset($name)
    {
        return isset($this->settings[$name]) ?: parent::__isset($name);
    }

    public function getSettings()
    {
        if ($this->_settings === false)
            $this->_settings = ArrayHelper::map($this->owner->{$this->relationName}, 'url', 'value');

        return $this->_settings;
    }

    public function setSettings($value)
    {
        /** @var \yii\db\ActiveRecord $owner */
        $owner = $this->owner;
        $relation = $this->relationName;
        $relationName = 'get' . ucfirst($relation);
        /** @var \yii\db\ActiveRecord $moduleClass */
        $moduleClassName = $owner->{$relationName}()->modelClass;
        $moduleClass = new $moduleClassName;


        if (!empty($data))
            $owner->on($owner::EVENT_AFTER_INSERT, function ($event) use ($moduleClass) {
                $module_id = $event->sender->id;
                foreach ($event->data as $url => $value) {
                    $model = clone $moduleClass;
                    $model->setAttributes(compact('module_id', 'url', 'value'), false);
                    var_dump($model->attributes);
                    $model->save(false);
                }
            }, $value);

        $owner->on($owner::EVENT_AFTER_UPDATE, function ($event) use ($moduleClass, $relation) {
            $module_id = $event->sender->id;

            /** @var \yii\db\ActiveRecord $row */
            foreach ($event->sender->{$relation} as $row) {
                if (isset($event->data[$row['url']])) {
                    $row->value = $event->data[$row['url']];
                    $row->save(false, ['value']);
                    unset($event->data[$row['url']]);
                } else
                    $row->delete();
            }

            if (!empty($event->data))
                foreach ($event->data as $url => $value) {
                    $model = clone $moduleClass;
//                    if(is_array($value) || is_object($value)) $value = serialize($value);
                    $model->setAttributes(compact('module_id', 'url', 'value'), false);
                    $model->save(false);
                }
        }, $value);
    }
}