<?php

namespace app\models;
//use yii\behaviors\TimestampBehavior;
use yii;
use yii\db\ActiveRecord;
use app\admin\models\User;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $name
 * @property integer $population
 */
class Role extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['code', 'name'], 'required'],
            // [['population'], 'integer'],
            // [['code'], 'string', 'max' => 2],
            // [['name'], 'string', 'max' => 52]
            ['name', 'required'],
            ['name', 'string', 'max' => 10],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '输入一个角色名',
        ];
    }

    public function getUsers()
    {
        return $this->hasMany(User::className(), ['role_id', 'id']);
    }
    
}
