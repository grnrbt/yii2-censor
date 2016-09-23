<?php

namespace grnrbt\tests\unit;

use grnrbt\yii2\censor\Censor;
use grnrbt\yii2\censor\CensorValidator;

class CensorValidatorTest extends DbTestCase
{
    public function testCanValidateValue()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслово\b');
        $validator = new CensorValidator(['censor' => $censor]);
        $this->assertNull($validator->validateValue('некий текст'));
        $this->assertTrue(is_array($validator->validateValue('некий слово текст')));
    }
}