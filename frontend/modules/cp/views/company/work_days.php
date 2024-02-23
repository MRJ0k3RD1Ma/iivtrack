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
                                <?php foreach (\common\models\WorkDay::find()->all() as $item):
                                    $social = \common\models\CompanyDay::find()->where(['company_id'=>$company->id,'day_id'=>$item->id])->one();
                                    ?>
                                    <tr class="<?= $social ? 'bg-success' : 'bg-danger'?> workdays-<?= $item->id?>" data-key="<?= $item->id?>" >


                                        <td>
                                            <div>
                                                <h5 class="font-size-15"><a class="text-dark"></a><?= $item->name?></h5>
                                            </div>
                                        </td>

                                        <td>
                                            <p class="mb-1"><a class="text-dark workdaytype-<?= $item->id?>"><?php
                                                    if($social){
                                                        echo "Ish kuni";
                                                    }else{
                                                        echo "Dam olish kuni";
                                                    }
                                                    ?></a></p>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-3" dir="ltr">
                                                <input type="checkbox" class="form-check-input workdayscheckbox" value="<?= $item->id ?>" <?= $social ? 'checked' : ''?>>
                                            </div>
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

<?php
$cid = $company->id;
$url = Yii::$app->urlManager->createUrl(['/cp/company/workdaychange']);
$this->registerJs("
    $('.workdayscheckbox').change(function(){
        if($(this).is(':checked')){
            $.get('{$url}?company_id={$cid}&id='+$(this).val()+'&code=create').done(function(data){
                $('.workdays-'+data).removeClass('bg-danger');
                $('.workdays-'+data).addClass('bg-success');
                $('.workdaytype-'+data).empty();
                $('.workdaytype-'+data).append('Ish kuni');
            });
        }else{
            $.get('{$url}?company_id={$cid}&id='+$(this).val()+'&code=delete').done(function(data){
                $('.workdays-'+data).removeClass('bg-success');
                $('.workdays-'+data).addClass('bg-danger');
                $('.workdaytype-'+data).empty();
                $('.workdaytype-'+data).append('Dam olish kuni');
            });
        }
    })
")
?>