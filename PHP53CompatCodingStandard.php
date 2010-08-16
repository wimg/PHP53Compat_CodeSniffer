<?php
/**
 * PHP53Compat PHP_CodeSniffer Coding Standard.
 *
 * PHP version 5.3
 *
 * @category  PHP
 * @package   PHP53Compat
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2010 Cu.be Solutions bvba
 * @license   http://www.linfo.org/bsdlicense.html BSD Licence
 * @version   1.0
 */

if (class_exists('PHP_CodeSniffer_Standards_CodingStandard', true) === false) {
    throw new PHP_CodeSniffer_Exception('Class PHP_CodeSniffer_Standards_CodingStandard not found');
}

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
    throw new PHP_CodeSniffer_Exception('PHP 5.3 is required to use the PHP53Compat codesniffer standard');
}

/**
 * PHP53Compat PHP_CodeSniffer Coding Standard.
 *
 * @category  PHP
 * @package   PHP53Compat
 * @author    Wim Godden <wim.godden@cu.be>
 * @copyright 2010 Cu.be Solutions bvba
 * @license   http://www.linfo.org/bsdlicense.html BSD Licence
 * @version   1.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class PHP_CodeSniffer_Standards_PHP53Compat_PHP53CompatCodingStandard extends PHP_CodeSniffer_Standards_CodingStandard
{


    /**
     * Return a list of external sniffs to include with this standard.
     *
     * This standard is limited to just the PHP 5.3 compatibility tests
     *
     * @return array
     */
    public function getIncludedSniffs()
    {
        return array();

    }//end getIncludedSniffs()

}//end class
