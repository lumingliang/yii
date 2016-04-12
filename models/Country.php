<?php

namespace app\models;
use yii\behaviors\TimestampBehavior;
use yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $name
 * @property integer $population
 */
class Country extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                // 'class' => TimestampBehavior::className(),
                // 'attributes' => [
                    // ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    // ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                // ],
                // if you're using datetime instead of UNIX timestamp:
                // 'value' => new Expression('NOW()'),
              'class' => TimestampBehavior::className(),
              'createdAtAttribute' => 'created_at',
              'updatedAtAttribute' => 'updated_at',
              'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['population'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 52]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'Name',
            'population' => 'Population',
            'created_at' => 'Created_at',
            'updated_at' => 'Updated_at',
        ];
    }
}
