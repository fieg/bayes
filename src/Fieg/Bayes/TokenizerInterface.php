<?php

/*
 * @author Jeroen Fiege <jeroen@webcreate.nl>
 * @copyright Webcreate (http://webcreate.nl)
 */

namespace Fieg\Bayes;

interface TokenizerInterface
{
    public function tokenize($string);
} 
