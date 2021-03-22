<?php

namespace App\TextAnalyzer;

class TextProcessor
{
    public const ALLOWED_ENCODING = [
        'UTF-8',
        'ASCII',
    ];

    /**
     * @var string
     */
    private $encoding;

    public function __construct($encoding)
    {
        $this->encoding = $encoding;
    }

    /**
     * @param string $input
     * @return int
     */
    public function calculateLength(string $input): int
    {
        return mb_strlen($input, $this->encoding);
    }

    /**
     * @param string $input
     * @return int
     */
    public function calculateWords(string $input): int
    {
        return count($this->getWordsArray($input));
    }

    /**
     * @param string $input
     * @return int
     */
    public function calculateSentences(string $input): int
    {
        return count($this->getSentencesArray($input));
    }

    /**
     * @param string $input
     * @return string
     */
    public function calculateFrequencyCharacters(string $input): string
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
    public function calculateCharactersDistributions(string $input): string
    {
        $unique = $this->getUniqueCharacters($input);
        $length = $this->calculateLength($input);

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
    public function calculateAverageWordLength(string $input): int
    {
        $wordCount = $this->calculateWords($input);
        $spaceCount = $this->getSpaceCount($input);

        return $wordCount ? floor(($this->calculateLength($input) - $spaceCount) / $wordCount) : 0;
    }

    /**
     * @param string $input
     * @return int
     */
    public function calculateAverageNumberOfWords(string $input): int
    {
        $sentencesCount = $this->calculateSentences($input);

        return $sentencesCount ? floor($this->calculateWords($input) / $sentencesCount) : 0;
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function calculateMostUsageWords(string $input, $count = 10): string
    {
        $words = $this->getWordsCountArray($input);

        arsort($words);

        $words = array_slice($words, 0, $count);

        return implode(
            ', ',
            array_map(
                function ($item_1, $item_2) {
                    return sprintf('[%s] => %d time(s)', $item_1, $item_2);
                },
                array_keys($words),
                $words
            )
        );
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function getLongestWords(string $input, $count = 10): string
    {
        $words = array_keys($this->getWordsCountArray($input));
        usort($words, function ($word_1, $word_2) {
            return $this->calculateLength($word_2) <=> $this->calculateLength($word_1);
        });

        $words = array_slice($words, 0, $count);

        return implode(', ', $words);
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function getShortestWords(string $input, $count = 10): string
    {
        $words = array_keys($this->getWordsCountArray($input));
        usort($words, function ($word_1, $word_2) {
            return $this->calculateLength($word_1) <=> $this->calculateLength($word_2);
        });

        $words = array_slice($words, 0, $count);

        return implode(', ', $words);
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function getLongestSentences(string $input, $count = 10): string
    {
        $sentences = $this->getSentencesArray($input);
        usort($sentences, function ($sentence_1, $sentence_2) {
            return $this->calculateLength($sentence_2) <=> $this->calculateLength($sentence_1);
        });

        $sentences = array_slice($sentences, 0, $count);

        return implode(', ', $sentences);
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function getShortestSentences(string $input, $count = 10): string
    {
        $sentences = $this->getSentencesArray($input);
        usort($sentences, function ($sentence_1, $sentence_2) {
            return $this->calculateLength($sentence_1) <=> $this->calculateLength($sentence_2);
        });

        $sentences = array_slice($sentences, 0, $count);

        return implode(', ', $sentences);
    }

    /**
     * @param string $input
     * @return int
     */
    public function calculatePalindromeWords(string $input): int
    {
        $words = $this->getWordsCountArray($input);
        $uniqueWords = array_keys($words);
        $result = 0;

        foreach ($uniqueWords as $word) {
            if ($this->isPalindrome($word)) {
                $result += $words[$word];
            }
        }

        return $result;
    }

    /**
     * @param string $input
     * @param int $count
     * @return string
     */
    public function getLongestPalindromesWords(string $input, $count = 10): string
    {
        $words = $this->getWordsCountArray($input);
        $uniqueWords = array_keys($words);
        $palindromes = [];

        foreach ($uniqueWords as $word) {
            if ($this->isPalindrome($word)) {
                $palindromes[] = $word;
            }
        }

        usort($palindromes, function ($word_1, $word_2) {
            return $this->calculateLength($word_2) <=> $this->calculateLength($word_1);
        });

        $palindromes = array_slice($palindromes, 0, $count);

        return implode(', ', $palindromes);
    }

    public function isWholeTextPalindromes(string $input): string
    {
        $words = $this->getWordsArray($input);

        return $this->isPalindrome(implode('', $words)) ? 'yes' : 'no';
    }

    /**
     * @param string $input
     * @return array
     */
    private function getUniqueCharacters(string $input): array
    {
        $unique = [];
        $length = $this->calculateLength($input);

        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($input, $i, 1, $this->encoding);

            if ($char === ' ') {
                $char = 'space';
            }

            if ($char === "\r") {
                $char = 'carriage_return';
            }

            if ($char === "\n") {
                $char = 'new_line';
            }

            if (!array_key_exists($char, $unique)) {
                $unique[$char] = 0;
            }

            $unique[$char]++;
        }
        return $unique;
    }

    /**
     * @param string $input
     * @return int
     */
    private function getSpaceCount(string $input): int
    {
        $unique = $this->getUniqueCharacters($input);

        return ($unique['space'] ?? 0) + ($unique['carriage_return'] ?? 0) + ($unique['new_line'] ?? 0);
    }

    /**
     * @param string $input
     * @return array
     */
    private function getWordsCountArray(string $input): array
    {
        $uniqueWord = [];
        $words = $this->getWordsArray($input);

        foreach ($words as $word) {
            if (!array_key_exists($word, $uniqueWord)) {
                $uniqueWord[$word] = 0;
            }

            $uniqueWord[$word]++;
        }

        return $uniqueWord;
    }

    /**
     * @param string $input
     * @return array
     */
    private function getWordsArray(string $input): array
    {
        return array_map(
            function ($item) {
                return rtrim($item, ',.');
            },
            array_filter(mb_split('[\s\r\n]', $input))
        );
    }

    /**
     * @param string $input
     * @return array
     */
    private function getSentencesArray(string $input): array
    {
        return array_filter(mb_split('\.', $input));
    }

    /**
     * @param string $input
     * @return bool
     */
    private function isPalindrome(string $input): bool
    {
        $characters = [];
        $length = $this->calculateLength($input);

        for ($i = 0; $i < $length; $i++) {
            $characters[] = mb_substr($input, $i, 1, $this->encoding);
        }

        $reverse = implode('', array_reverse($characters));

        return mb_strtolower($input) === mb_strtolower($reverse);
    }
}
