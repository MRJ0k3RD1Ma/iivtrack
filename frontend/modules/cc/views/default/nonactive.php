<?php
/* @var $model \common\models\User[]*/

    $this->title = "Barcha hodimlar ro`yhati";
?>
<div class="card">
    <div class="card-body">
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
                    <th>So'ngi aktivlik</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $key=>$item): ?>
                    <tr class="<?php if($item->active != 2){?><?= $item->active == 1 ? 'bg-success' : 'bg-warning'?><?php }?>">
                        <td><?= $key+1?></td>
                        <td><img src="/upload/<?= $item->image ?>" alt="rasm" style="width: 100px; height: auto"></td>
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
</div>