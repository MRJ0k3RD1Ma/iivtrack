<?php
/* @var $model \common\models\User[]*/

    $this->title = "Tungi guruh ro`yhati";
?>
<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-9">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>FIO</th>
                            <th>Tel</th>
                            <th>Hudud</th>
                            <th>Позивной</th>
                            <th>So'ngi aktivlik</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($data as $key=>$item): ?>
                            <tr class="<?= $item->active == 1 ? 'bg-success' : 'bg-warning'?>">
                                <td><?= $key+1?></td>
                                <td><a href="<?= Yii::$app->urlManager->createUrl(['/cc/default/view','id'=>$item->id])?>"><?= $item->name ?></a></td>
                                <td><?= $item->username ?></td>
                                <td><?= $item->hudud ?></td>
                                <td><?= $item->pozivnoy ?></td>
                                <td><?= $item->active_date ?></td>
                                <td><?= Yii::$app->params['active'][$item->active] ?></td>

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