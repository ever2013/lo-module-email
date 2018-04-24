<?php

namespace lo\modules\email\models;

use lo\core\db\ActiveRecord;
use lo\modules\email\models\meta\EmailItemMeta;

/**
 * This is the model class for table "email__item".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $email
 * @property string $session_id
 * @property string $date_send
 * @property string $date_subscribe
 * @property string $date_unsubscribe
 * @property integer $status
 * @property integer $hash
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property integer $sp_bounce_class
 * @property integer $sp_error_code
 * @property string $sp_raw_reason
 * @property string $sp_transmission_id
 * @property string $sp_timestamp
 * @property string $sp_type
 */
class EmailItem extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    const CATEGORY_SUBSCRIBE = 8;
    const CATEGORY_CONTACT = 17;
    const CATEGORY_COMMENT = 18;
    const CATEGORY_MINISITE = 20;
    const CATEGORY_ORDER = 24;
    const CATEGORY_AUTO_UNSUBSCRIBE = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email__item}}';
    }

    /**
     * @inheritdoc
     */
    public function metaClass()
    {
        return EmailItemMeta::class;
    }

    /**
     * @return \lo\core\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(EmailCat::class, ['id' => 'cat_id']);
    }

}