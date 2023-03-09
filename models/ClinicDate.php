<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "clinic_date".
 *
 * @property int $id
 * @property string $datetime
 * @property int $type_id
 * @property int $patient_id
 *
 * @property Patient $patient
 * @property Type $type
 */
class ClinicDate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_date';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['datetime', 'type_id', 'patient_id'], 'required'],
            [['datetime'], 'safe'],
            [['type_id', 'patient_id'], 'integer'],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
            [['patient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Patient::class, 'targetAttribute' => ['patient_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'type_id' => 'Type ID',
            'patient_id' => 'Patient ID',
        ];
    }

    /**
     * Gets query for [[Patient]].
     *
     * @return \yii\db\ActiveQuery|PatientQuery
     */
    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery|TypeQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    /**
     * {@inheritdoc}
     * @return ClinicDateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClinicDateQuery(get_called_class());
    }
}
