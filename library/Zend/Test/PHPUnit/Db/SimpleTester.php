<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id$
 */

/**
 * Simple Tester for Database Tests when the Abstract Test Case cannot be used.
 *
 * @uses       PHPUnit\DbUnit\DefaultTester
 * @category   Zend
 * @package    Zend_Test
 * @subpackage PHPUnit
 * @copyright  Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Test_PHPUnit_Db_SimpleTester extends PHPUnit\DbUnit\DefaultTester
{
    /**
     * Creates a new default database tester using the given connection.
     *
     * @param PHPUnit\DbUnit\Database\Connection $connection
     */
    public function __construct(PHPUnit\DbUnit\Database\Connection $connection)
    {
        if(!($connection instanceof Zend_Test_PHPUnit_Db_Connection)) {
            throw new Zend_Test_PHPUnit_Db_Exception("Not a valid Zend_Test_PHPUnit_Db_Connection instance, ".get_class($connection)." given!");
        }

        $this->connection = $connection;
        $this->setUpOperation = new PHPUnit\DbUnit\Operation\Composite(array(
            new Zend_Test_PHPUnit_Db_Operation_Truncate(),
            new Zend_Test_PHPUnit_Db_Operation_Insert(),
        ));
        $this->tearDownOperation = PHPUnit\DbUnit\Operation\Factory::NONE();
    }

    /**
     * Set Up the database using the given Dataset and the SetUp strategy "Truncate, then Insert"
     *
     * @param PHPUnit\DbUnit\DataSet\IDataSet $dataSet
     */
    public function setUpDatabase(PHPUnit\DbUnit\DataSet\IDataSet $dataSet)
    {
        $this->setDataSet($dataSet);
        $this->onSetUp();
    }
}
