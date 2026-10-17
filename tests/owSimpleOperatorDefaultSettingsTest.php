<?php
/**
 * The default settings of OW Simple Operator expose only harmless PHP functions as template operators. Reads the
 * settings file only, without a kernel or a database:
 *
 *   php vendor/bin/phpunit extension/owsimpleoperator/tests/owSimpleOperatorDefaultSettingsTest.php
 *
 *  SO-01 - PermittedFunctionList[] lists no function that reads files, runs commands or evaluates code
 *  SO-02 - Every listed function exists in the running PHP (ereg_replace is gone since PHP 7)
 *  SO-03 - DebugOutput is disabled, and the settings file closes its PHP comment
 *
 * @copyright Copyright (C) 1998 - 2026 7x & Exponential Foundation. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @package tests
 */

use PHPUnit\Framework\TestCase;

class owSimpleOperatorDefaultSettingsTest extends TestCase
{
    const UNSAFE = array( 'file_get_contents', 'file', 'readfile', 'fopen', 'file_put_contents', 'unlink', 'exec',
                          'shell_exec', 'system', 'passthru', 'popen', 'proc_open', 'eval', 'assert', 'include',
                          'require', 'call_user_func', 'call_user_func_array', 'create_function', 'getenv',
                          'phpinfo', 'ini_get', 'ini_set', 'glob', 'scandir', 'simplexml_load_file' );

    private static function source(): string
    {
        return (string)file_get_contents( dirname( __DIR__ ) . '/settings/owsimpleoperator.ini.append.php' );
    }

    private static function permittedFunctions(): array
    {
        preg_match_all( '/^PermittedFunctionList\[\]=(\S+)\s*$/m', self::source(), $matches );
        return $matches[1];
    }

    /** SO-01 */
    public function testNoUnsafeFunctionIsPermitted()
    {
        $functions = self::permittedFunctions();
        $this->assertNotEmpty( $functions );
        foreach ( $functions as $function )
        {
            $this->assertNotContains( strtolower( $function ), self::UNSAFE, $function );
        }
    }

    /** SO-02 */
    public function testEveryPermittedFunctionExists()
    {
        foreach ( self::permittedFunctions() as $function )
        {
            $this->assertTrue( function_exists( $function ), $function );
        }
    }

    /** SO-03 */
    public function testDebugOutputIsDisabledAndTheCommentIsClosed()
    {
        $source = self::source();
        $this->assertMatchesRegularExpression( '/^DebugOutput=disabled\s*$/m', $source );
        $this->assertStringStartsWith( '<?php /*', $source );
        $this->assertMatchesRegularExpression( '/\*\/ \?>\s*$/', $source );
    }
}
