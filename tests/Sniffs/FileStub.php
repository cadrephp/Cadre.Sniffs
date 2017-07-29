<?php
declare(strict_types=1);

namespace Cadre\Sniffs;

use PHP_CodeSniffer\Files\File;

class FileStub extends File
{
    private $filename;

    protected $tokens;
    protected $warnings = [];
    protected $warningCount = 0;

    public $numTokens;

    public function __construct($filename)
    {
        $this->filename = __DIR__ . '/samples/' . $filename . '.php';
        if (!defined('PHP_CODESNIFFER_VERBOSITY')) {
            define('PHP_CODESNIFFER_VERBOSITY', 0);
        }
    }

    public function getTokens()
    {
        $this->tokens = [];
        $this->numTokens = 0;

        if (class_exists('PHP_CodeSniffer\Util\Tokens')) {
            $config = (object) [
                'tabWidth' => 0,
                'encoding' => 'utf-8',
                'annotations' => false,
            ];

            $tokenizer = new \PHP_CodeSniffer\Tokenizers\PHP(
                file_get_contents($this->filename),
                $config,
                "\n"
            );

            $this->tokens = $tokenizer->getTokens();
            $this->numTokens = count($this->tokens);
        }

        return $this->tokens;
    }

    public function getTokensAsString($start, $length)
    {
        $str = '';
        $end = ($start + $length);

        if ($end > $this->numTokens) {
            $end = $this->numTokens;
        }

        for ($i = $start; $i < $end; $i++) {
            $str .= $this->tokens[$i]['content'];
        }

        return $str;
    }

    public function addWarningOnLine(
        $warning,
        $line,
        $code,
        $data = [],
        $severity = 0
    ) {
        $this->warningCount++;
        $this->warnings[] = [
            'warning' => $warning,
            'line' => $line,
            'code' => $code,
            'data' => $data,
            'severity' => $severity,
        ];

        return true;
    }
}
