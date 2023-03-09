<?php

namespace app\helpers;

use app\models\ClinicDate;
use app\models\Patient;
use app\models\Type;
use DateTime;
use Exception;
use Yiisoft\Arrays\ArrayHelper;

class PatientHelper {
    
    public static function uploadModels(array $params)
    {
        try {
            $patientModel = PatientHelper::patientExists($params);
            $typeModel = PatientHelper::getType($params);
            $patientModel->save();
            $clinicDate = PatientHelper::generateClinicDate($patientModel, $typeModel);
            $clinicDate->save();
            
            return [
                'patient' => $patientModel,
                'clinicDate' => $clinicDate,
                'type' => $typeModel
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private static function patientExists(array $params)
    {
        try {
            $patientModel = new Patient();
            $patientModel->load($params);
            $patientExists = Patient::find()->where(['NID' => $patientModel->NID])->exists();
            
            return ($patientExists) ? Patient::findOne(['NID' => $patientModel->NID]) : $patientModel;
        } catch (Exception $e) {
            throw $e;
        }
    }

    private static function getType(array $params)
    {
        try {
            $type = ArrayHelper::getValue($params, 'Type');
            $typeName = ArrayHelper::getValue($type, 'name');
            $typeModel = Type::findOne(['name' => $typeName]);
            return $typeModel;
        } catch(Exception $e) {
            throw $e;
        }
    }

    private static function generateClinicDate(Patient $patientModel, Type $typeModel)
    {
        try {
            $clinicDate = new ClinicDate();
            $date = PatientHelper::getDate();
            if (gettype($date) === "string") {
                $clinicDate->datetime = $date;
            } else {
                $clinicDate->datetime = date ('Y-m-d h:i:s', $date);
            }
            $clinicDate->type_id = $typeModel->id;
            $clinicDate->patient_id = $patientModel->id;
            return $clinicDate;
        } catch (Exception $e) {
            throw $e;
        }
    }


    private static function getDate()
    {
        $clinicDateModel = ClinicDate::find()
                            ->where(['id' => ClinicDate::find()->max('id')])
                            ->one();                   
        $openDatetime = strtotime(date('Y-m-d H:i',strtotime(date('Y-m-d').' 10am')));
        $closeDatetime = strtotime(date('Y-m-d H:i',strtotime(date('Y-m-d').' 9pm')));
        $output = (!empty($clinicDateModel)) ? DateTime::createFromFormat('Y-m-d h:i:s', $clinicDateModel->datetime)->format('Y-m-d h') : $openDatetime;
        $dateReturn = '';

        if (empty($clinicDateModel)) {
            $dateReturn = $openDatetime;
        } elseif ($output >= $openDatetime || $output <= $closeDatetime) {
            $outputNextHour = date('Y-m-d H', strtotime($output .'+1 hour'));
            if ($outputNextHour > $closeDatetime) {
                $dateReturn = date('Y-m-d H', strtotime($openDatetime .'+1 day'));
            } else {
                $dateReturn = $outputNextHour;
            }
        }
       return $dateReturn;              
    }
}
?>