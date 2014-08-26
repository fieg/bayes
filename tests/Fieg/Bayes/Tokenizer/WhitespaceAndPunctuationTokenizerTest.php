<?php

class WhitespaceAndPunctuationTokenizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider tokenizeDataProvider
     * @param $string
     * @param $expected
     */
    public function testTokenize($string, $expected)
    {
        $tokenizer = new \Fieg\Bayes\Tokenizer\WhitespaceAndPunctuationTokenizer();

        $result = $tokenizer->tokenize($string);

        $this->assertEquals($expected, $result);
    }

    public function tokenizeDataProvider()
    {
        return array(
            array('Hello, how are you?', array('hello', 'how', 'are', 'you')),
            array("Hello\n\nHow are you?!", array('hello', 'how', 'are', 'you')),
            array("Un importante punto de inflexión en la historia de la ciencia filosófica primitiva", array('un','importante','punto','de','inflexión','en','la','historia','de','la','ciencia','filosófica','primitiva')),
        );
    }
}
