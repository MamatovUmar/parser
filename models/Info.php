<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "info".
 *
 * @property int $id
 * @property string $nameRu
 * @property int $iinBin
 * @property float $totalArrear
 * @property float $totalTaxArrear
 * @property float $pensionContributionArrear
 * @property float $socialContributionArrear
 * @property float $socialHealthInsuranceArrear
 * @property int|null $sendTime
 * @property string|null $taxOrgInfo
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nameRu', 'iinBin', 'totalArrear', 'totalTaxArrear', 'pensionContributionArrear', 'socialContributionArrear', 'socialHealthInsuranceArrear'], 'required'],
            [['sendTime', 'iinBin'], 'integer'],
            [['totalArrear', 'totalTaxArrear', 'pensionContributionArrear', 'socialContributionArrear', 'socialHealthInsuranceArrear'], 'number'],
            [['taxOrgInfo'], 'string'],
            [['nameRu'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nameRu' => 'ФИО',
            'iinBin' => 'ИИН/БИН',
            'totalArrear' => 'Всего задолженности',
            'totalTaxArrear' => 'Итого задолженности',
            'pensionContributionArrear' => 'Задолженность по обязательным пенсионным взносам, обязательным профессиональным пенсионным взносам',
            'socialContributionArrear' => 'Задолженность по отчислениям и (или) взносам на обязательное социальное медицинское страхование',
            'socialHealthInsuranceArrear' => 'Задолженность по социальным отчислениям',
            'sendTime' => 'Send Time',
            'taxOrgInfo' => 'Tax Org Info',
        ];
    }

    public function saveInfo($info){
        $this->nameRu = $info['nameRu'];
        $this->iinBin = $info['iinBin'];
        $this->totalArrear = $info['totalArrear'];
        $this->totalTaxArrear = $info['totalTaxArrear'];
        $this->pensionContributionArrear = $info['pensionContributionArrear'];
        $this->socialContributionArrear = $info['socialContributionArrear'];
        $this->socialHealthInsuranceArrear = $info['socialHealthInsuranceArrear'];
        $this->sendTime = $info['sendTime'];
        $this->taxOrgInfo = Json::encode($info['taxOrgInfo']);

        return $this->save();
    }
}
