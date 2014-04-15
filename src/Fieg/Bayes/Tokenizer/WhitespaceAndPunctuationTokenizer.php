<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\Bayes\Tokenizer;

use Fieg\Bayes\TokenizerInterface;

class WhitespaceAndPunctuationTokenizer implements TokenizerInterface
{
    public function tokenize($string)
    {
        $retval = preg_split("/[ ,.?!-:\n\t]/i", mb_strtolower($string));
        $retval = array_filter($retval, 'trim');
        $retval = array_values($retval);

        return $retval;
    }
}
