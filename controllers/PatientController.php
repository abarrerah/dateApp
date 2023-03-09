<?php

namespace app\controllers;

use app\helpers\PatientHelper;
use app\models\ClinicDate;
use app\models\Patient;
use app\models\Type;
use Exception;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class PatientController extends Controller {

    public function actionIndex()
    {
        try {
            Url::remember();
            $patientModel = new Patient();
            return $this->render('index', [
                'patientModel' => $patientModel
            ]);
        } catch(Exception $e) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ha ocurrido un error. ' . $e->getFile() . " " . $e->getMessage()));
        }
    }


    public function actionCheck()
    {
        Url::remember();
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        try {
            $params = Yii::$app->request->post();
            $nid = ArrayHelper::getValue($params, "nid");
            
            $patientExist = Patient::find()->where(["NID" => $nid])->exists();
            $patientModel = ($patientExist) ?  Patient::findOne(["NID" => $nid]) : new Patient();
            $clinicDate = (!empty($patientModel->getAttributes())) ? ClinicDate::find()->where(['patient_id' => $patientModel->id])->exists() : false;

            $typemodel = ($clinicDate) ? Type::findOne(["name" => "EN REVISION"]) :  Type::findOne(['name' => "PRIMERA CONSULTA"]);
            return $typemodel->name;
        } catch(Exception $e) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ha ocurrido un error. ' . $e->getMessage()));
        }
    }

    public function actionCreateOrUpdate()
    {
        Url::remember();
        try {
            $params = Yii::$app->request->post();
            PatientHelper::uploadModels($params);
            
            return $this->render('view');
        
        } catch(Exception $e) {
            Yii::$app->session->setFlash('error', Yii::t('app', 'Ha ocurrido un error. ' . $e->getMessage() ));
        }
    }
}
?>