<?php

try {
    $form = new \App\TextAnalyzer\Form('default_form.html.php');
    $form->processForm();
} catch (Throwable $exception) {
    error_log($exception->getMessage());
}
