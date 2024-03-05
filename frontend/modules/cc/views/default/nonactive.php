<?php
/* @var $model \common\models\User[]*/
$this->title = "Hozrda offline bo`lgan hodimlar";
?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>FIO</th>
                    <th>Tel</th>
                    <th>So'ngi aktivlik</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($model as $key=>$item): ?>
                    <tr>
                        <td><?= $key+1?></td>
                        <td><?= $item->name ?></td>
                        <td><?= $item->username ?></td>
                        <td><?= $item->active_date ?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>

        </div>
    </div>
</div>