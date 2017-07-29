<?php
declare(strict_types=1);

namespace Cadre\Sniffs;

use PHP_CodeSniffer\Files\File;

class StrictTypesDeclarationSniffTest extends \PHPUnit\Framework\TestCase
{
    public function testSuccess()
    {
        $sniff = new StrictTypesDeclarationSniff();

        $phpcsFile = new FileStub('success');
        $stackPtr = 0;

        $sniff->process($phpcsFile, $stackPtr);

        $this->assertEquals(0, $phpcsFile->getWarningCount());
    }

    public function testFailure()
    {
        $sniff = new StrictTypesDeclarationSniff();

        $phpcsFile = new FileStub('failure');
        $stackPtr = 0;

        $sniff->process($phpcsFile, $stackPtr);

        $this->assertEquals(1, $phpcsFile->getWarningCount());
    }

    public function testIgnoreNotFirstLine()
    {
        $sniff = new StrictTypesDeclarationSniff();

        $phpcsFile = new FileStub('html');
        $stackPtr = 2;

        $sniff->process($phpcsFile, $stackPtr);

        $this->assertEquals(0, $phpcsFile->getWarningCount());
    }

    public function testBlankPhpDocument()
    {
        $sniff = new StrictTypesDeclarationSniff();

        $phpcsFile = new FileStub('blank');
        $stackPtr = 0;

        $sniff->process($phpcsFile, $stackPtr);

        $this->assertEquals(1, $phpcsFile->getWarningCount());
    }

    public function testInvalidPlacement()
    {
        $sniff = new StrictTypesDeclarationSniff();

        $phpcsFile = new FileStub('invalid');
        $stackPtr = 0;

        $sniff->process($phpcsFile, $stackPtr);

        $this->assertEquals(1, $phpcsFile->getWarningCount());
    }
}
