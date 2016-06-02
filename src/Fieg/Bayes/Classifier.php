<?php

/*
 * Naive Bayes Classifier based on article by Burak Kanber
 * @see http://burakkanber.com/blog/machine-learning-naive-bayes-1/
 *
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\Bayes;

class Classifier
{
    /**
     * @var TokenizerInterface
     */
    protected $tokenizer;

    /**
     * @var array
     */
    protected $labels = array();

    /**
     * @var array
     */
    protected $docs = array();

    /**
     * @var array
     */
    protected $tokens = array();

    /**
     * @var array
     */
    protected $data = array();

    /**
     * Constructor.
     *
     * @param TokenizerInterface $tokenizer
     */
    public function __construct(TokenizerInterface $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    /**
     * Trains the classifier one text+label combination a time
     *
     * @param string $label
     * @param string $text
     */
    public function train($label, $text)
    {
        $tokens = $this->tokenizer->tokenize($text);

        if (!isset($this->labels[$label])) {
            $this->labels[$label] = 0;
            $this->data[$label] = [];
            $this->docs[$label] = 0;
        }

        foreach ($tokens as $token) {
            if (!isset($this->tokens[$token])) {
                $this->tokens[$token] = 0;
            }
            if (!isset($this->data[$label][$token])) {
                $this->data[$label][$token] = 0;
            }

            $this->labels[$label]++;
            $this->tokens[$token]++;
            $this->data[$label][$token]++;
        }

        $this->docs[$label]++;
    }

    /**
     * Classifies a text and returns the probability (score) per label
     *
     * @param  string $text
     * @return array
     */
    public function classify($text)
    {
        $totalDocCount = array_sum($this->docs);

        $tokens = $this->tokenizer->tokenize($text);

        $scores = array();

        foreach ($this->labels as $label => $labelCount) {
            $logSum = 0;

            $docCount = $this->docs[$label];
            $inversedDocCount = $totalDocCount - $docCount;

            if (0 === $inversedDocCount) {
                continue;
            }

            foreach ($tokens as $token) {
                $totalTokenCount = isset($this->tokens[$token]) ? $this->tokens[$token] : 0;

                if (0 === $totalTokenCount) {
                    continue;
                }

                $tokenCount         = isset($this->data[$label][$token]) ? $this->data[$label][$token] : 0;
                $inversedTokenCount = $this->inversedTokenCount($token, $label);

                $tokenProbabilityPositive = $tokenCount / $docCount;
                $tokenProbabilityNegative = $inversedTokenCount / $inversedDocCount;

                $probability = $tokenProbabilityPositive / ($tokenProbabilityPositive + $tokenProbabilityNegative);

                $probability = ((1 * 0.5) + ($totalTokenCount * $probability)) / (1 + $totalTokenCount);

                if (0 === $probability) {
                    $probability = 0.01;
                } elseif (1 === $probability) {
                    $probability = 0.99;
                }

                $logSum += log(1 - $probability) - log($probability);
            }

            $scores[$label] = 1 / (1 + exp($logSum));
        }

        arsort($scores, SORT_NUMERIC);

        return $scores;
    }

    /**
     * Resets the classifier
     */
    public function reset()
    {
        $this->labels = array();
        $this->docs = array();
        $this->tokens = array();
        $this->data = array();
    }

    /**
     * @param  string $token
     * @param  string $label
     * @return int
     */
    protected function inversedTokenCount($token, $label)
    {
        $data = $this->data;

        $totalTokenCount = $this->tokens[$token];

        $totalLabelTokenCount = isset($data[$label][$token]) ? $data[$label][$token] : 0;

        $retval = $totalTokenCount - $totalLabelTokenCount;

        return $retval;
    }

    /**
     * @param  string $label
     * @return number
     */
    protected function inversedDocCount($label)
    {
        $data = $this->docs;

        unset($data[$label]);

        return array_sum($data);
    }
}
