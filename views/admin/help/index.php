<?php
use panix\engine\Html;

?>
<div class="row">

    <div class="col-sm-12">

        <div class="pt-3 pb-3">
            <h3>Для вас</h3>
            Смотрите ниже, чтобы получить помощь, необходимую для вашего проекта<br/>
            Более подробную информацию вы найдете на сайте <?= Html::a('pixelion.com.ua/support', 'pixelion.com.ua/support'); ?> или по телефону +38 (068) 293 7379
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card p-3 text-center">
            <div class="card-body">
                <a href="">
                    <i class="icon-comments icon-x3"></i>
                    <h5 class="card-title">Форум</h5>
                    <h6 class="mb-2 text-muted">Бесплатная помощь от Сообщества</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card p-3 text-center">
            <div class="card-body">
                <a href="">
                    <i class="icon-books icon-x3"></i>
                    <h5 class="card-title">Документация</h5>
                    <h6 class="mb-2 text-muted">Прочитайте официальные руководства</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card p-3 text-center">
            <div class="card-body">
                <a href="">
                    <i class="icon-bug icon-x3"></i>
                    <h5 class="card-title">Баг трекер</h5>
                    <h6 class="mb-2 text-muted">Нашли проблему? Дайте нам знать!</h6>
                </a>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-3">
        <div class="card p-3 text-center">
            <div class="card-body">
                <a href="">
                    <i class="icon-creditcard icon-x3"></i>
                    <h5 class="card-title">Коммерческая поддержка</h5>
                    <h6 class="mb-2 text-muted">Приоритетная поддержка от источника</h6>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="row">

    <div class="col-sm-6">
        <div class="card p-3">
            <div class="card-body">


                <h3>Будьте в курсе с Pixelion</h3>
                <p class="mb-2 text-muted">Подпишитесь на новостную рассылку Pixelion, чтобы получать все важные новости
                    о Pixelion. Просто введите свой адрес электронной почты ниже — мы обещаем никогда не рассылать
                    спам.</p>


                Вы также можете следить за нами на этих каналах.
                <ul class="list-unstyled">
                    <li><?= Html::a('<i class="icon-twitter icon-x2"></i>', '', ['target' => '_blank']); ?></li>
                    <li><?= Html::a('<i class="icon-facebook icon-x2"></i>', '', ['target' => '_blank']); ?></li>
                    <li><?= Html::a('<i class="icon-youtube-play icon-x2"></i>', '', ['target' => '_blank']); ?></li>
                    <li><?= Html::a('<i class="icon-instagram icon-x2"></i> instagram.com/pixeliongroup', '//instagram.com/pixeliongroup', ['target' => '_blank']); ?></li>

                </ul>


            </div>
        </div>
    </div>
</div>
