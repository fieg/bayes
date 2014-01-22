Naive Bayes Classifier
======================

Implementation of Naive Bayes Classifier algorithm in PHP.

Getting started
---------------

```php
use Fieg\Bayes\Classifier;
use Fieg\Bayes\Tokenizer\WhitespaceAndPunctuationTokenizer;

$tokenizer = new WhitespaceAndPunctuationTokenizer();
$classifier = new Classifier($tokenizer);

$classifier->train('en', 'This is english');
$classifier->train('fr', 'Je suis Hollandais');

$result = $classifier->classify('This is a naive bayes classifier');
```

Which would result in:

```
array(2) {
  'en' =>
  double(0.9)
  'fr' =>
  double(0.1)
}
```
