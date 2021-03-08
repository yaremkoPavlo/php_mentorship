<?php

namespace App\TextAnalyzer;

use InvalidArgumentException;

class FormProcessor implements OptionsInterface
{
    protected const OUTPUT = 'output';

    /**
     * @var array
     */
    protected $options;

    public function __construct(array $options = [])
    {
        if ($this->validateOptions($options)) {
            $this->options = $options;
        }

        $this->applyDefaultOptions();
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param FormView $form
     */
    public function processForm(FormView $form): void
    {
        $method = strstr(strtolower($this->options['method']), 'get') ? $_GET : $_POST;
        $inputName = $this->options['textarea_name'];

        if ($method && array_key_exists($inputName, $method)) {
            $result = $this->prepareOutput($method[$inputName]);

            $this->setOutput($result);
        }

        $form->render($this);
    }

    /**
     * @param array $options
     * @return bool
     * @throws InvalidArgumentException
     */
    protected function validateOptions(array $options = []): bool
    {
        if (empty($options)) {
            return true;
        }

        if (array_key_exists('method', $options) && !preg_match('#post|get#i', $options['method'])) {
            throw new InvalidArgumentException('Option method should be GET or POST');
        }

        return true;
    }

    protected function applyDefaultOptions(): void
    {
        $defaultOptions = [
            'method' => 'POST',
            'action' => 'index.php',
            'textarea_name' => 'textarea',
            'encoding' => 'UTF-8',
        ];

        // Just for example
        $allowedEncoding = [
            'UTF-8',
            'ASCII',
        ];

        // 'output' key in options array will be use to Output the result for task, just filter enter parameters
        $this->options = array_diff(array_merge($defaultOptions, $this->options), [self::OUTPUT]);
        // filter allowed encoding
        $this->options['encoding'] = in_array($this->options['encoding'], $allowedEncoding) ? $this->options['encoding'] : 'UTF-8';
    }

    /**
     * @param string $value
     */
    protected function setOutput(string $value): void
    {
        $this->options[self::OUTPUT] = htmlspecialchars($value);
    }

    /**
     * @param string $input
     * @return string
     */
    protected function prepareOutput(string $input): string
    {
        $startTime = hrtime(true);
        $numberCharacters = mb_strlen($input, $this->options['encoding']);
        $numberWords = $this->calculateWords($input);
        $numberSentences = $this->calculateSentences($input);
        $frequencyCharacters = $this->calculateFrequencyCharacters($input);
        $charactersDistributions = $this->calculateCharactersDistributions($input);
        $averageWordLength = $this->calculateAverageWordLength($input);
        $averageNumberOfWords = $this->calculateAverageNumberOfWords($input);

        $endTime = hrtime(true);
        $timeSpendINms = ($endTime - $startTime) * 1e-6;

        $result = var_dump(mb_split('\w{1}', $input));
        return <<< EOT
Number of characters: $numberCharacters
Number of words: $numberWords
Number of sentences: $numberSentences
Frequency of characters: $frequencyCharacters
Distribution of characters as a percentage of total: $charactersDistributions
Average word length: $averageWordLength
The average number of words in a sentence: $averageNumberOfWords
Top 10 most used words: 
Top 10 longest words: 
Top 10 shortest words: 
Top 10 longest sentences: 
Top 10 shortest sentences: 
Number of palindrome words: 
Top 10 longest palindrome words: 
Is the whole text a palindrome? (Without whitespaces and punctuation marks.)
The time it took to process the text in ms: $timeSpendINms
EOT;
    }

    /**
     * @param string $input
     * @return int
     */
    private function calculateWords(string $input): int
    {
        return count(array_filter(mb_split('[\s\r\n]', $input)));
    }

    /**
     * @param string $input
     * @return int
     */
    private function calculateSentences(string $input): int
    {
        return count(array_filter(mb_split('\.', $input)));
    }

    /**
     * @param string $input
     * @return array
     */
    private function getUniqueCharacters(string $input): array
    {
        $unique = [];
        $length = mb_strlen($input, $this->options['encoding']);

        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($input, $i, 1, $this->options['encoding']);
            if (!array_key_exists($char, $unique))
                $unique[$char] = 0;
            $unique[$char]++;
        }
        return $unique;
    }

    /**
     * @param string $input
     * @return string
     */
    private function calculateFrequencyCharacters(string $input): string
    {
        $unique = $this->getUniqueCharacters($input);

        return implode(
            ', ',
            array_map(
                function ($el1, $el2) {
                    return sprintf('[%s] => %d time(s)', $el1, $el2);
                },
                array_keys($unique),
                $unique
            )
        );
    }

    /**
     * @param string $input
     * @return string
     */
    private function calculateCharactersDistributions(string $input): string
    {
        $unique = $this->getUniqueCharacters($input);
        $length = mb_strlen($input, $this->options['encoding']);

        return implode(
            ', ',
            array_map(
                function ($el1, $el2) use ($length) {
                    return sprintf('[%s] => %.3f %%', $el1, 100 * $el2 / $length);
                },
                array_keys($unique),
                $unique
            )
        );
    }

    /**
     * @param string $input
     * @return int
     */
    private function calculateAverageWordLength(string $input): int
    {
        $wordCount = $this->calculateWords($input);
        $unique = $this->getUniqueCharacters($input);
        $spaceCount = array_key_exists(' ', $unique) ? $unique[' '] : 0;

        return $wordCount ? floor((mb_strlen($input) - $spaceCount - $wordCount + 1) / $wordCount) : 0;
    }

    /**
     * @param string $input
     * @return int
     */
    private function calculateAverageNumberOfWords(string $input): int
    {
        $sentencesCount = $this->calculateSentences($input);

        return $sentencesCount ? floor($this->calculateWords($input) / $sentencesCount) : 0;
    }

    private function calculateSpace(string $input): int
    {
        return count(mb_split('\w', $input));
    }
}
