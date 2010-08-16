<?php
/**
 * PHP53Compat_Sniffs_PHP_DeprecatedIniDirectivesSniff.
 *
 * PHP version 5.3
 *
 * @category  PHP
 * @package   PHP53Compat
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2010 Cu.be Solutions bvba
 */

/**
 * PHP53Compat_Sniffs_PHP_DeprecatedIniDirectivesSniff.
 *
 * Discourages the use of ini directives through ini_set or
 * in php.ini (searches only for the current running one, so it should be run on a php.ini
 * identical to the one running on your production server)
 *
 * @category  PHP
 * @package   PHP53Compat
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2010 Cu.be Solutions bvba
 */
class PHP53Compat_Sniffs_PHP_DeprecatedIniDirectivesSniff implements PHP_CodeSniffer_Sniff
{
    /**
     * Variable keeps status of php.ini check
     *
     * @var bool
     */
    protected $checkedIniFile = false;

    /**
     * A list of deprecated INI directives
     *
     * @var array(string)
     */
    protected $deprecatedIniDirectives = array(
        'define_syslog_variables',
        'register_globals',
        'register_long_arrays',
        'safe_mode',
        'magic_quotes_gpc',
        'magic_quotes_runtime',
        'magic_quotes_sybase',
    );

    /**
     * Checks if deprecated php.ini directives are present in the currently loaded php.ini
     *
     * @param PHP_CodeSniffer_File $phpcsFile The currently loaded file
     */
    protected function checkLoadedIniFile($phpcsFile)
    {
        $this->checkedIniFile = true;
        foreach ($this->deprecatedIniDirectives as $directive) {
            if (ini_get($directive) != '') {
                $error = "The use of directive " . $directive . " in your php.ini file is discouraged";
                $phpcsFile->addWarning($error, 0);
            }
        }
    }

    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        return array(T_STRING);

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token in the
     *                                        stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if ($this->checkedIniFile === false) {
            $this->checkLoadedIniFile($phpcsFile);
        }

        $tokens = $phpcsFile->getTokens();

        $ignore = array(
                   T_DOUBLE_COLON,
                   T_OBJECT_OPERATOR,
                   T_FUNCTION,
                   T_CONST,
                  );

        $prevToken = $phpcsFile->findPrevious(T_WHITESPACE, ($stackPtr - 1), null, true);
        if (in_array($tokens[$prevToken]['code'], $ignore) === true) {
            // Not a call to a PHP function.
            return;
        }

        $function = strtolower($tokens[$stackPtr]['content']);
        if ($function != 'ini_set') {
            return;
        }
        $iniToken = $phpcsFile->findNext(T_CONSTANT_ENCAPSED_STRING, $stackPtr, null);
        if (in_array(str_replace("'", "", $tokens[$iniToken]['content']), $this->deprecatedIniDirectives) === false) {
            return;
        }
        $error = "The use of ini directive " . $tokens[$iniToken]['content'] . " is discouraged";

        $phpcsFile->addWarning($error, $stackPtr);

    }//end process()


}//end class
