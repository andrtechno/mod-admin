<?php
/**
 * @var $this \yii\web\View
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\admin\models\SettingsForm
 */

use yii\helpers\Html;

?>
<?= $form->field($model, 'mailer_transport_smtp_enabled')->checkbox(); ?>
<?= $form->field($model, 'mailer_transport_smtp_username'); ?>
<?= $form->field($model, 'mailer_transport_smtp_password'); ?>
<?= $form->field($model, 'mailer_transport_smtp_host')->hint('Например: localhost'); ?>
<?= $form->field($model, 'mailer_transport_smtp_port')->hint('Например: 465'); ?>
<?= $form->field($model, 'mailer_transport_smtp_encryption')->dropDownList([
    'ssl' => 'SSL',
    'tls' => 'TLS'
]) ?>
<?= $form->field($model, 'mailer_sender_name'); ?>

<div class="form-group row">
    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2">
        Send a test email to <strong><?= Yii::$app->settings->get('app', 'email'); ?></strong>
    </div>
    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10">
        <?= Html::a(Yii::t('app/default','SEND'), ['/admin/admin/settings/send-email'], ['class' => 'btn btn-outline-secondary mail-test']); ?>
    </div>
</div>


<?php
$this->registerJs("
$(document).on('click','.mail-test',function(){
    $.get($(this).attr('href'), function( data ) {
        if(data.success){
            common.notify(data.message,'success');
        }else{
            common.notify(data.message,'error');
        }
    });
    return false;
});
");
?>
