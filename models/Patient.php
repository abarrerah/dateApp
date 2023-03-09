<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "patient".
 *
 * @property int $id
 * @property string $NID
 * @property int $phone
 * @property string $email
 * @property string $name
 *
 * @property ClinicDate[] $clinicDates
 */
class Patient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'patient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NID', 'phone', 'email', 'name'], 'required'],
            [['phone'], 'integer'],
            [['NID', 'email', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'NID' => 'Nid',
            'phone' => 'Phone',
            'email' => 'Email',
            'name' => 'Name'
        ];
    }

    /**
     * Gets query for [[ClinicDates]].
     *
     * @return \yii\db\ActiveQuery|ClinicDateQuery
     */
    public function getClinicDates()
    {
        return $this->hasMany(ClinicDate::class, ['patient_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PatientQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PatientQuery(get_called_class());
    }
}
