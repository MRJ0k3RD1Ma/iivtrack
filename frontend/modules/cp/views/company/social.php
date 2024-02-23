<?php
/* @var $company \common\models\Company*/
?>
<div class="card-body px-0 pt-2">
    <div class="table-responsive px-3" data-simplebar="init" style="max-height: 395px;">
        <div class="simplebar-wrapper" style="margin: 0px -16px;">
            <div class="simplebar-height-auto-observer-wrapper">
                <div class="simplebar-height-auto-observer"></div>
            </div>
            <div class="simplebar-mask">
                <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                    <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                        <div class="simplebar-content" style="padding: 0px 16px;">
                            <table class="table align-middle table-nowrap">
                                <tbody>
                                <?php foreach (\common\models\SocialNetwork::find()->all() as $item):
                                    $social = \common\models\CompanySocial::find()->where(['company_id'=>$company->id,'social_id'=>$item->id])->one();
                                    ?>
                                <tr class="<?= $social ? 'bg-success' : 'bg-danger'?>">
                                    <td style="width: 50px;">
                                        <div class="avatar-md me-4">
                                            <img src="/upload/<?= $item->image?>" class="img-fluid" alt="">
                                        </div>
                                    </td>

                                    <td>
                                        <div>
                                            <h5 class="font-size-15"><a class="text-dark"></a><?= $item->name?></h5>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="mb-1"><a class="text-dark"><?php
                                                if($social){
                                                    echo $social->url;
                                                }else{
                                                    echo "Kiritilmagan";
                                                }
                                                ?></a></p>
                                    </td>
                                    <td>
                                        <p class="mb-1"><a class="text-dark"><?php

                                                $url_del = Yii::$app->urlManager->createUrl(['/cp/company/deletesocial','id'=>$item->id,'company_id'=>$company->id]);
                                                $url_create = Yii::$app->urlManager->createUrl(['/cp/company/createsocial','id'=>$item->id,'company_id'=>$company->id]);
                                                if($social){
                                                    echo "<a class='btn btn-danger' href='{$url_del}' data-confirm='Siz rostdan ham ushbu ijtimoiy tarmoqingiz manzilini o`chirmoqchimisiz?'><span class='fa fa-trash'></span></a>";
                                                }else{
                                                    echo "<button class='btn btn-warning createsocial' value='{$url_create}'><span class='fa fa-plus'></span></button>";
                                                }
                                                ?></a></p>
                                    </td>
                                </tr>
                                <?php endforeach;?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simplebar-placeholder" style="width: auto; height: 454px;"></div>
        </div>
        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
            <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
        </div>
        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
            <div class="simplebar-scrollbar"
                 style="height: 343px; transform: translate3d(0px, 0px, 0px); display: block;"></div>
        </div>
    </div>
</div>


    <!-- right offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="createsocialoff" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Ijtimoiy tarmoq qo`shish</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body createsocialoff-body">

        </div>
    </div>




<?php

$this->registerJs("
    $('.createsocial').click(function(){
        var url = this.value;
        $('#createsocialoff').offcanvas('show').find('.createsocialoff-body.offcanvas-body').load(url); 
               
    });

");