<?php

namespace grnrbt\yii2\censor;

use yii\base\Exception;
use yii\validators\Validator;

class CensorValidator extends Validator
{
    /**
     * @var CensorInterface
     */
    public $censor;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = '{attribute} contains forbidden words.';
        }
        if ($this->censor === null) {
            throw  new Exception("'censor' field must contains a CensorInterface instance.");
        }
    }

    /**
     * @inheritdoc
     */
    public function validateValue($value)
    {
        if (!$this->censor->validate($value)) {
            return [$this->message, []];
        }
        return null;
    }
}