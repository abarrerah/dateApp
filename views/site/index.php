<?php

/** @var yii\web\View $this */
?>
<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <button onclick="redirect()" class="btn btn-primary"><?= Yii::t('app', 'Pedir cita')?></button>
            </div>
        </div>
    </div>
</main>

<script>
    function redirect() {
        window.location.replace("./date");
    }
</script>