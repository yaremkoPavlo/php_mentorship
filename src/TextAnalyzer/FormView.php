<?php

namespace App\TextAnalyzer;

use InvalidArgumentException;

class FormView
{
    /**
     * @const string Path to resource folder
     */
    protected const RESOURCE_DIR = __DIR__ . DIRECTORY_SEPARATOR . 'resource' . DIRECTORY_SEPARATOR;
    /**
     * @var string
     */
    protected $form;

    public function __construct(string $form)
    {
        $form = $this->validateForm($form);

        if ($form) {
            $this->form = $form;
        }
    }

    /**
     * @param OptionsInterface $iOptions
     * @param string $form
     */
    public function render(OptionsInterface $iOptions, string $form = ''): void
    {
        $options = $iOptions->getOptions();

        if (strlen($form) > 0 && $this->validateForm($form)) {

            require_once $form;

            return;
        }

        require_once $this->form;
    }

    /**
     * @param string $form
     * @return void
     */
    public function setForm(string $form): void
    {
        $form = $this->validateForm($form);

        if ($form) {
            $this->form = $form;
        }
    }

    /**
     * @return string
     */
    public function getForm(): string
    {
        return $this->form;
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
}
