<?php

namespace grnrbt\yii2\censor;

use yii\db\Query;

class Censor implements CensorInterface
{
    /**
     * @var string
     */
    private $tableName = 'grnrbt_censored';
    /**
     * @var boolean
     */
    private $inMemory;
    /**
     * @var array
     */
    private $forbiddenPatterns = [];

    /**
     * @param bool $inMemory = true Do not store forbidden patterns in a database if true.
     * Patterns list will be destroyed with the censor object.
     * @param string $tableName = null Name of table in database.
     */
    public function __construct($inMemory = false, $tableName = null)
    {
        if ($inMemory !== null) {
            $this->inMemory = $inMemory;
        }
        if ($tableName !== null) {
            $this->tableName = $tableName;
        }
    }

    /**
     * @inheritdoc
     */
    public function validate($text)
    {
        preg_replace($this->getForbiddenPatterns(), '', $text, 1, $count);
        return $count == 0;
    }

    /**
     * @inheritdoc
     */
    public function censor($text, $closeup = '***')
    {
        return preg_replace($this->getForbiddenPatterns(), $closeup, $text);
    }

    /**
     * @inheritdoc
     */
    public function addForbiddenPattern($pattern)
    {
        if (!$this->validatePattern($pattern)) {
            throw  new \InvalidArgumentException("Pattern '{$pattern}' is invalid");
        }
        if ($this->forbiddenPatterns !== null) {
            $this->forbiddenPatterns[] = $pattern;
        }
        if (!$this->inMemory) {
            \Yii::$app->getDb()->createCommand()->insert($this->tableName, ['pattern' => $pattern])->execute();
        }
    }

    /**
     * @return array Return the list of exist forbidden patterns.
     */
    public function getForbiddenPatterns()
    {
        if ($this->forbiddenPatterns === null) {
            $this->forbiddenPatterns = $this->inMemory
                ? []
                : (new Query())
                    ->select('pattern')
                    ->from($this->tableName)
                    ->column();
        }
        $result = [];
        foreach ($this->forbiddenPatterns as $pattern) {
            $result[] = $this->preparePattern($pattern);
        }
        return $result;
    }

    protected function preparePattern($pattern)
    {
        return "/{$pattern}/iUu";
    }

    protected function validatePattern($pattern)
    {
        return @preg_match($this->preparePattern($pattern), '') !== false;
    }
}