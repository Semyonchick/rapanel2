<?php

namespace app\admin\models;

use Yii;

/**
 * This is the model class for table "{{%user_auth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $source_id
 * @property string $source_attributes
 * @property string $updated_at
 * @property string $created_at
 *
 * @property User $user
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_auth}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id', 'source_attributes'], 'required'],
            [['user_id'], 'integer'],
            [['source_attributes'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['source', 'source_id'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('ra/model', 'ID'),
            'user_id' => Yii::t('ra/model', 'User ID'),
            'source' => Yii::t('ra/model', 'source'),
            'source_id' => Yii::t('ra/model', 'source ID'),
            'source_attributes' => Yii::t('ra/model', 'source Attributes'),
            'updated_at' => Yii::t('ra/model', 'Updated At'),
            'created_at' => Yii::t('ra/model', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
