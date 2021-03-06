<?php

namespace ra\admin\models;

use Yii;

/**
 * This is the model class for table "{{%character_show}}".
 *
 * @property string $character_id
 * @property string $module_id
 * @property string $page_id
 * @property string $filter
 *
 * @property Character $character
 * @property Module $module
 * @property Page $page
 */
class CharacterShow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%character_show}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['character_id', 'module_id', 'page_id', 'filter'], 'required'],
            [['character_id', 'module_id', 'page_id', 'filter'], 'integer'],
            [['filter'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'character_id' => Yii::t('ra', 'Character ID'),
            'module_id' => Yii::t('ra', 'Module ID'),
            'page_id' => Yii::t('ra', 'Page ID'),
            'filter' => Yii::t('ra', 'Filter'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCharacter()
    {
        return $this->hasOne(Character::className(), ['id' => 'character_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModule()
    {
        return $this->hasOne(Module::className(), ['id' => 'module_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
