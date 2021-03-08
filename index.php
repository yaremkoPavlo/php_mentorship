<?php
ini_set('display_errors', 1);

require 'vendor/autoload.php';

try {
    $form = new \App\TextAnalyzer\Form('default_form.html.php');
    $form->processForm();
} catch (Throwable $exception) {
    error_log($exception->getMessage());
}

/*

Top 10 most used words
Top 10 longest words
Top 10 shortest words
Top 10 longest sentences
Top 10 shortest sentences
Number of palindrome words
Top 10 longest palindrome words
Is the whole text a palindrome? (Without whitespaces and punctuation marks.)
The time it took to process the text in ms
(Optional) Add any data that you think could be interesting
Date and time when the report was generated.
The reversed text 
“This is the text.” -> ”.txet desrever ehT”
The reversed text but the character order in words kept intact. 
“This is the text.” -> ”.text the is This”
The calculation should work for UTF8 encoded text as well.
*/