
<?php
Yii::app()->tpl->openWidget(array(
    'title' => $this->pageName
));
echo $model->getForm();
Yii::app()->tpl->closeWidget();
?>


<script>
    $(document).ready(function(){
        $('#BlocksModel_widget').change(function(){
            $('#payment_configuration').load('/admin/app/blocks/configurationForm/system/'+$(this).val());
        });
        $('#BlocksModel_widget').change();
    });
</script>