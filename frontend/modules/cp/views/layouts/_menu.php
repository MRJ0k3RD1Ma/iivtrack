<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Menu</li>



                <li>
                    <a href="#" class="arrow-down">
                        <i data-feather="grid"></i>
                        <span data-key="t-ecommerce">Ma'lumotlar</span>
                    </a>
                    <ul class="sub-menu">


                        <li>
                            <a href="<?= Yii::$app->urlManager->createUrl(['/cp/user'])?>">
                                <i data-feather="users"></i>
                                <span data-key="t-chat">Faydalunchilar</span>
                            </a>
                        </li>


                    </ul>
                </li>


            </ul>


        </div>
        <!-- Sidebar -->
    </div>
</div>
