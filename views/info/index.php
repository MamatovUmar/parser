<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сохраненные информации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="info-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'nameRu',
            'iinBin',
            'totalArrear',
            'totalTaxArrear',
            //'pensionContributionArrear',
            //'socialContributionArrear',
            //'socialHealthInsuranceArrear',
            //'sendTime:datetime',
            //'taxOrgInfo:ntext',

            ['class' => 'yii\grid\ActionColumn', 'template'=>'{view}  {delete}',],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
