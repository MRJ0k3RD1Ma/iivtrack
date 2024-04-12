<?php
/* @var $model \common\models\User[]*/

    $this->title = "Tungi guruh ro`yhati";
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <input type="date" value="<?= $date?>" class="form-control" id="date">
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Rasm</th>
                            <th>FIO</th>
                            <th>Tel</th>
                            <th>Hudud</th>
                            <th>Позивной</th>
                            <?php if($date == date('Y-m-d')){?><th></th><?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $key=>$item): ?>
                            <tr>
                                <td><?= $key+1?></td>
                                <td><img src="/upload/<?= $item->image ?>" alt="rasm" style="width: 100px; height: auto"></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['/cc/default/view','id'=>$item->id])?>"><?= $item->name ?></a></td>
                                <td><?= $item->username ?></td>
                                <td><?= $item->hudud ?></td>
                                <td><?= $item->pozivnoy ?></td>
                                <?php if($date == date('Y-m-d')){?><td><a class="btn btn-danger"
                                            href="<?= Yii::$app->urlManager->createUrl(['/cc/default/shiftremove', 'user_id' => $item->id, 'shift_id' => 2]) ?>"><span class="fa fa-trash"></span></a></td><?php }?>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="col-md-3">
                <h4>Tezkor tergov guruhiga hodim qo`shish</h4>
                <?php $form = \yii\widgets\ActiveForm::begin()?>

                <p>Sana: <?= date('d.m.Y')?></p>

                <?= $form->field($model,'user_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\User::find()->where('id not in (select user_id from shift where shift_id = 2 and date = "'.date('Y-m-d').'")')->all(),'id','name')) ?>


                <button class="btn btn-success" type="submit">Saqlash</button>


                <?php \yii\widgets\ActiveForm::end()?>
            </div>
        </div>
    </div>
</div>


<?php
    $url = Yii::$app->urlManager->createUrl(['/cc/default/shifttwo']);
    $this->registerJs("
        $('#date').change(function(){
            location.href = '{$url}?date='+$('#date').val()
        })
    ")
?>