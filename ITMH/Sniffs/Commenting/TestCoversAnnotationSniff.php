<?php

/**
 * Class ITMH_Sniffs_Commenting_TestCoversAnnotationSniff
 */
class ITMH_Sniffs_Commenting_TestCoversAnnotationSniff implements \PHP_CodeSniffer_Sniff
{
    const ANNOTATION_COVERS = '@covers';
    const TEST_FUNCTION_PREFIX = 'test';

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array
     */
    public function register()
    {
        return [T_FUNCTION];
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param \PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                   $stackPtr  The position in the stack where the token was found.
     *
     * @return void
     */
    public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $find = PHP_CodeSniffer_Tokens::$methodPrefixes;
        $find[] = T_WHITESPACE;

        $isTagFound = false;
        $functionName = '';
        try {
            $functionName = $phpcsFile->getDeclarationName($stackPtr);
        } catch (PHP_CodeSniffer_Exception $e) {
            error_log($e->getMessage());
        }

        // Process only test* functions
        if (substr($functionName, 0, strlen(self::TEST_FUNCTION_PREFIX)) !== self::TEST_FUNCTION_PREFIX) {
            return;
        }

        $commentEnd = $phpcsFile->findPrevious($find, ($stackPtr - 1), null, true);
        if (array_key_exists('comment_opener', $tokens[$commentEnd])) {
            foreach ($tokens[$tokens[$commentEnd]['comment_opener']]['comment_tags'] as $tag) {
                if ($tokens[$tag]['content'] === self::ANNOTATION_COVERS) {
                    $string = $phpcsFile->findNext(T_DOC_COMMENT_STRING, $tag, $commentEnd);
                    $isTagFound = true;
                    if ($string === false || $tokens[$string]['line'] !== $tokens[$tag]['line']) {
                        $error = sprintf('Content missing for %s tag in test method comment', self::ANNOTATION_COVERS);
                        $phpcsFile->addError($error, $tag, 'EmptyCoversTag');
                    }
                }
            }
        }

        if ($isTagFound === false) {
            $error = sprintf('Missing %s tag in test method comment', self::ANNOTATION_COVERS);
            $phpcsFile->addError($error, $stackPtr, 'MissingCoversTag');
        }
    }
}
