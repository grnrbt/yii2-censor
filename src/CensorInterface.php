<?php

namespace grnrbt\yii2\censor;

interface CensorInterface
{
    /**
     * Check if specified text contains forbidden patterns.
     *
     * @param string $text
     * @return true Return true is specified text is correct.
     */
    public function validate($text);

    /**
     * Replace forbidden patterns in the text to $closeup.
     *
     * @param string $text
     * @param string $closeup = '***'
     * @return string Return processed text.
     */
    public function censor($text, $closeup = '***');

    /**
     * Add a new pattern to forbidden list.
     * @param string $pattern
     */
    public function addForbiddenPattern($pattern);
}