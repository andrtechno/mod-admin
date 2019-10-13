<?php
use yii\helpers\Html;

?>

<?php
foreach ($notifications as $notification) {
    echo Html::tag('div', Html::a($notification->text, $notification->url, ['class' => 'nav-link']), ['class' => 'nav-item']);
}
echo Html::a(Yii::t('app/admin', 'NOTIFICATIONS_BUTTON', ['count' => count($notifications)]), ['/'], ['class' => 'btn btn-block btn-primary']);
?>

