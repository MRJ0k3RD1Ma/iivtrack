<?php

/* @var $this \yii\web\View*/
/* @var $model \common\models\Company*/
?>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>FIO</th>
                <th>Telefon</th>
                <th>Roli</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                    $user = \common\models\User::find()->where('id in (select user_id from user_company where company_id='.$model->id.')')->andWhere(['<>','status','-1'])->all();
                    foreach ($user as $key=>$item):
                ?>
                <tr>
                    <td><?=$key+1?></td>
                    <td><?=$item->name?></td>
                    <td><?=$item->username?></td>
                    <td><?=$item->role->name?></td>
                    <td>
                        <button class="btn btn-warning updateuserbtn" type="button" value="<?= Yii::$app->urlManager->createUrl(['/cp/company/updateuser','id'=>$item->id])?>"><span class="fa fa-pencil-alt"></span></button>
                        <a href="<?= Yii::$app->urlManager->createUrl(['/cp/company/deleteuser','id'=>$item->id])?>" data-confirm="Siz rostdan ham ushbu foydalanuvchini o`chirmoqchimisiz?" class="btn btn-danger"><span class="fa fa-trash"></span></a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tr>
        </tbody>
    </table>
</div>


    <!-- right offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="updateuser" aria-labelledby="updateuser">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Foydalanuvchi ma`lumotlarini yangilash</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="updateuserbody offcanvas-body">

        </div>
    </div>



<?php
$this->registerJs("
     $('.updateuserbtn').click(function(){
        var url = this.value;
        $('#updateuser').offcanvas('show').find('.updateuserbody.offcanvas-body').load(url); 
    });
");