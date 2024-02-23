

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="/" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="/default/assets/images/logo-sm.svg" alt="" height="30">
                                </span>
                    <span class="logo-lg">
                                    <img src="/default/assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">iTrack</span>
                                </span>
                </a>

                <a href="/" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="/default/assets/images/logo-sm.svg" alt="" height="30">
                                </span>
                    <span class="logo-lg">
                                    <img src="/default/assets/images/logo-sm.svg" alt="" height="24"> <span class="logo-txt">iTrack</span>
                                </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>


        </div>

        <div class="d-flex">


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item bg-soft-light border-start border-end" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium"><?= Yii::$app->user->isGuest ? "Guest" : Yii::$app->user->identity->name ?></span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['/cp/default/profile'])?>"><i class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="<?= Yii::$app->urlManager->createUrl(['/site/logout'])?>" data-method="post"><i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Chiqish</a>
                </div>
            </div>

        </div>
    </div>
</header>