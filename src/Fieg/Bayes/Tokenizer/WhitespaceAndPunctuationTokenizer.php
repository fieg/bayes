<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\Bayes\Tokenizer;

use Fieg\Bayes\TokenizerInterface;

class WhitespaceAndPunctuationTokenizer implements TokenizerInterface
{
    protected $pattern = "/[ ,.?!-:;\\n\\r\\t…_]/u";

    public function tokenize($string)
    {
        $retval = preg_split($this->pattern, mb_strtolower($string));
        $retval = array_filter($retval, 'trim');
        $retval = array_values($retval);

        return $retval;
    }
}
