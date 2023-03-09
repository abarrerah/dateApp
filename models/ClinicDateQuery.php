<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ClinicDate]].
 *
 * @see ClinicDate
 */
class ClinicDateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClinicDate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClinicDate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
