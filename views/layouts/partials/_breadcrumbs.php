<?php if (isset($this->breadcrumbs)) { ?>
    <div id="page-nav">

        <?php
        $bc = array();
        if (!empty($this->breadcrumbs)) {
            $bc = $this->breadcrumbs;
        } else {
            $action = $this->action->id;
            $mod = $this->module->id;
            if (isset($this->module->name)) {
                $name = $this->module->name;
            } else {
                $name = Yii::t($mod . 'Module.admin', 'MODULE_NAME');
            }
            if ($action == 'index') {
                $bc = array($name);
            } elseif ($action == 'create') {
                $bc = array(
                    $name => array('index'),
                    Yii::t('app', 'CREATE', 1),
                );
            } elseif ($action == 'update') {
                $bc = array(
                    $name => array('index'),
                    Yii::t('app', 'UPDATE', 1),
                );
            }
        }
        $this->widget('Breadcrumbs', array(
            'homeLink' => '<li>' . Html::link('<i class="icon-home"></i> '.Yii::t('zii', 'Home'), $this->createUrl('/admin'), array()) . '</li>',
            'links' => $bc,
            'htmlOptions' => array('class' => 'breadcrumbs float-left pdd d-none d-lg-block'),
            'tagName' => 'ul',
            'scheme'=>false,
            'activeLinkTemplate' => '<li><a href="{url}">{label}</a></li>',
            'inactiveLinkTemplate' => '<li class="active">{label}</li>',
            'separator' => false
        ));
        ?>
        <?php $this->widget('ext.admin.addonsMenu.AddonsMenuWidget'); ?>
    </div>
<?php } ?>