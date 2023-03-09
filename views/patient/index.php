<?php

use app\models\Patient;
use app\models\Type;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

\yii\web\JqueryAsset::register($this);

/**@var Patient $patientModel */
/**@var Type $typeModel */

if (empty($typeModel)) {
  $typeModel = new Type();
}


$form = ActiveForm::begin([
    'layout' => 'horizontal',
    'action' => '/record'
]);

echo $form->field($patientModel, 'name');

echo $form->field($patientModel, 'NID');

echo $form->field($patientModel, 'email');

echo $form->field($patientModel, 'phone');

echo $form->field($typeModel, 'name');


?>
<div class="form-group mar-top">
    <div class="col-sm-10 offset-sm-2">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-labeled btn-success icon-lg fa fa-save']) ?>    
      </div>
</div>

<?php

$form::end();

?>

<script>

    window.addEventListener("load", function(event) {

      $("#patient-id").keyup(function(event) {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
          console.log("dale");
        }, 1000)
      });

      let timeout = null;
      var nidInput = document.getElementById('patient-nid');
      nidInput.addEventListener('keyup', function(event){
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          var call = ajaxCall("POST", "/check", nidInput.value);
        }, 1000);
      });

      var emailInput = document.getElementById('patient-email');
      emailInput.addEventListener('keyup', function(event){
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          var call = validateEmail(emailInput.value);
          if (!call) {
            alert("Correo electrónico no válido")
          }
        }, 1000);
      });
    });

    function ajaxCall(method, url, value){
      var settings = {
        "url": "check",
        "method": "POST",
        "timeout": 0,
        "headers": {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        "data": {
          "nid": value
      }
    };
    
    $.ajax(settings).done(function(response){
      $("#type-name").val(response);
      console.log(response);
    });
  }

  function validateEmail(email) {
    var filter = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
    return String(email).search (filter) != -1;
    }
  
</script>

