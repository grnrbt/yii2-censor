<?php

namespace grnrbt\tests\unit;

use grnrbt\yii2\censor\Censor;

class CensorTest extends DbTestCase
{
    public function testCanAddPattern()
    {
        $censor = new Censor(true);
        $this->assertEquals(count($censor->getForbiddenPatterns()), 0);
        $censor->addForbiddenPattern('test');
        $this->assertEquals(count($censor->getForbiddenPatterns()), 1);
    }

    public function testCanFindPatternInTextBegin()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertFalse($censor->validate('слова всякие'));
    }

    public function testCanFindPatternInTextEnd()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertFalse($censor->validate('всякие слова'));
    }

    public function testCanFindPatternInTextCenter()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertFalse($censor->validate('всякие слова разные'));
    }

    public function testCanCensorPatternInTextBeing()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertEquals($censor->censor('слова всякие'), '*** всякие');
    }

    public function testCanCensorPatternInTextEnd()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertEquals($censor->censor('всякие слова'), 'всякие ***');
    }

    public function testCanCensorPatternInTextCenter()
    {
        $censor = new Censor(true);
        $censor->addForbiddenPattern('\bслов.*\b');
        $this->assertEquals($censor->censor('всякие слова разные'), 'всякие *** разные');
    }
}