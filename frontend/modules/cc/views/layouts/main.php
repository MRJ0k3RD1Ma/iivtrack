<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use frontend\assets\MapAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);
MapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-theme-mode="default"  class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body data-topbar="dark" class="pace-done sidebar-enable" data-layout-mode="light" data-layout="horizantal" data-sidebar="brand">

<?php $this->beginBody() ?>





<!-- <body data-layout="horizontal"> -->

<!-- Begin page -->
<div id="layout-wrapper">

    <?= $this->render('_header')?>

    <?= $this->render('_menu')?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div >

        <div class="page-content" style="min-height: 100vh">

            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18"><?= $this->title ?></h4>

                            <div class="page-title-right">
                                <?php
                                echo Breadcrumbs::widget([
                                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->



                <?= $content ?>


            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © iTrack.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by <a href="" class="text-decoration-underline">Dilmurod Allabergenov</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->
<?php
if(Yii::$app->session->hasFlash('error')){
    $txt = Yii::$app->session->getFlash('error');
    $this->registerJs("
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: '{$txt}',
        })
    ");
}
if(Yii::$app->session->hasFlash('success')){
    $txt = Yii::$app->session->getFlash('success');
    $this->registerJs("
        Swal.fire({
          icon: 'success',
          title: 'Good job!',
          text: '{$txt}',
        })
    ");
}

?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
