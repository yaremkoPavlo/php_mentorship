<?php

namespace App\TextAnalyzer;

use InvalidArgumentException;

class Form
{
    /**
     * @const string Path to resource folder
     */
    protected const RESOURCE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR;
    protected const OUTPUT = 'output';

    /**
     * @var string
     */
    protected $form;

    /**
     * @var array
     */
    protected $options;

    /**
     * Form constructor.
     * @param string $form
     * @param array $options
     * @throws InvalidArgumentException
     */
    public function __construct(string $form, $options = [])
    {
        $form = $this->validateForm($form);

        if ($form) {
            $this->form = $form;
        }

        if ($this->validateOptions($options)) {
            $this->options = $options;
        }

        $this->applyDefaultOptions();
    }

    /**
     * @param string $form
     * @param array|null $options
     */
    public function render(string $form = '', ?array $options = null): void
    {
        if (isset($options)) {
            $this->validateOptions($options);
        }

        $options = $options ?? $this->options;

        if (strlen($form) > 0 && $this->validateForm($form)) {

            require_once $form;

            return;
        }

        require_once $this->form;
    }

    public function processForm(): void
    {
        $method = strstr(strtolower($this->options['method']), 'get') ? $_GET : $_POST;
        $inputName = $this->options['textarea_name'];

        if ($method && array_key_exists($inputName, $method)) {
            $result = $this->prepareOutput($method[$inputName]);

            $this->setOutput($result);
        }

        $this->render($this->form);
    }

    /**
     * @param string $form
     */
    public function setForm(string $form): void
    {
        $form = $this->validateForm($form);

        if ($form) {
            $this->form = $form;
        }
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): void
    {
        if ($this->validateOptions($options)) {
            $this->options = $options;
        }
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    protected function applyDefaultOptions(): void
    {
        $defaultOptions = [
            'method' => 'POST',
            'action' => 'index.php',
            'textarea_name' => 'textarea',
            'encoding' => 'UTF-8',
        ];

        // Simple realization
        $allowedEncoding = TextProcessor::ALLOWED_ENCODING;

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
        $textProcessor = new TextProcessor($this->options['encoding']);

        // Start time
        $startTime = hrtime(true);

        $output = <<< EOT
Number of characters: {$textProcessor->calculateLength($input)}
Number of words: {$textProcessor->calculateWords($input)}
Number of sentences: {$textProcessor->calculateSentences($input)}
Frequency of characters: {$textProcessor->calculateFrequencyCharacters($input)}
Distribution of characters as a percentage of total: {$textProcessor->calculateCharactersDistributions($input)}
Average word length: {$textProcessor->calculateAverageWordLength($input)}
The average number of words in a sentence: {$textProcessor->calculateAverageNumberOfWords($input)}
Top 10 most used words: {$textProcessor->calculateMostUsageWords($input)}
Top 10 longest words: {$textProcessor->getLongestWords($input)}
Top 10 shortest words: {$textProcessor->getShortestWords($input)}
Top 10 longest sentences: {$textProcessor->getLongestSentences($input)}
Top 10 shortest sentences: {$textProcessor->getShortestSentences($input)}
Number of palindrome words: {$textProcessor->calculatePalindromeWords($input)}
Top 10 longest palindrome words: {$textProcessor->getLongestPalindromesWords($input)}
Is the whole text a palindrome? (Without whitespaces and punctuation marks.) {$textProcessor->isWholeTextPalindromes($input)}

EOT;

        $endTime = hrtime(true);
        $timeSpendINms = ($endTime - $startTime) * 1e-6;

        $output .= "The time it took to process the text in ms: $timeSpendINms";

        return $output;
    }

    /**
     * @param string $form
     * @return string
     * @throws InvalidArgumentException
     */
    protected function validateForm(string $form = ''): string
    {
        if (strlen($form) === 0) {
            throw new InvalidArgumentException('Form can\'t be empty');
        }

        if (!preg_match('#[\\\/]#', $form)) {
            $form = self::RESOURCE_DIR . $form;
        }

        if (!file_exists($form)) {
            throw new InvalidArgumentException("File $form not found");
        }

        if (!is_file($form)) {
            throw new InvalidArgumentException("$form is not a file");
        }

        return $form;
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
}
