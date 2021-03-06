<?php

namespace ra\admin\models;

use Yii;

/**
 * This is the model class for table "{{%page_comments}}".
 *
 * @property string $id
 * @property string $page_id
 * @property integer $user_id
 * @property string $parent_id
 * @property integer $rating
 * @property string $text
 * @property string $created_at
 *
 * @property Page $page
 * @property User $user
 */
class PageComments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%page_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['page_id', 'user_id', 'parent_id', 'rating', 'text'], 'required'],
            [['page_id', 'user_id', 'parent_id', 'rating'], 'integer'],
            [['text'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ra', 'ID'),
            'page_id' => Yii::t('ra', 'Page ID'),
            'user_id' => Yii::t('ra', 'User ID'),
            'parent_id' => Yii::t('ra', 'Parent ID'),
            'rating' => Yii::t('ra', 'Rating'),
            'text' => Yii::t('ra', 'Text'),
            'created_at' => Yii::t('ra', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
