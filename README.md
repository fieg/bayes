Naive Bayes Classifier
======================

Implementation of Naive Bayes Classifier algorithm.

Installation / Usage
--------------------

1. Download the [`composer.phar`](https://getcomposer.org/composer.phar)
executable or use the installer.

    ``` sh
    $ curl -s https://getcomposer.org/installer | php
    ```

2. Create a composer.json defining your dependencies.

    ``` json
    {
        "require": {
            "fieg/bayes": "dev-master"
        }
    }
    ```

3. Run Composer: `php composer.phar install`

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
