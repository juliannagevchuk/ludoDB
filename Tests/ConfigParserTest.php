<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Alf Magne
 * Date: 10.01.13
 * Time: 11:45
 * To change this template use File | Settings | File Templates.
 */
require_once(__DIR__ . "/../autoload.php");

class ConfigParserTest extends TestBase
{
    public function setUp(){
        parent::setUp();

    }
    /**
     * @test
     */
    public function shouldFindTableName(){
        // given
        $person = new PersonForConfigParser();

        // when
        $tableName = $person->configParser()->getTableName();

        // then
        $this->assertEquals('Person', $tableName);
    }

    /**
     * @test
     */
    public function shouldGetConstructorFields(){
        // given
        $person = new PersonForConfigParser();

        // when
        $configParams = $person->configParser()->getConstructorParams();
        $expected = array('id');
        // then

        $this->assertEquals($expected, $configParams);
    }

    /**
     * @test
     */
    public function shouldGetColumnProperties(){
        // given
        $person = new PersonForConfigParser();

        // when
        $className = $person->configParser()->externalClassNameFor('city');

        // then
        $this->assertEquals('City', $className);
    }

    /**
     * @test
     */
    public function shouldFindExternalColumns(){
         // given
        $person = new PersonForConfigParser();

        // then
        $this->assertTrue($person->configParser()->isExternalColumn('city'));
        $this->assertFalse($person->configParser()->isExternalColumn('firstname'));
    }

    /**
     * @test
     */
    public function shouldFindIdField(){
         // given
        $person = new PersonForConfigParser();

        // then
        $this->assertEquals('id', $person->configParser()->getIdField());
    }

    /**
     * @test
     */
    public function shouldFindIfIdIsAutoIncremented(){
         // given
        $person = new PersonForConfigParser();

        // then
        $this->assertTrue($person->configParser()->idIsAutoIncremented());
    }

    /**
     * @test
     */
    public function shouldFindSetMethodForAColumn(){
         // given
        $person = new PersonForConfigParser();

        // when
        $method = $person->configParser()->getSetMethod('city');

        // then
        $this->assertEquals('setCity', $method);
    }

    /**
     * @test
     */
    public function shouldGetExternalClassProperties(){
         // given
        $person = new PersonForConfigParser();

        // when
        $foreignKey = $person->configParser()->foreignKeyFor('city');

        // then
        $this->assertEquals('zip', $foreignKey);
    }
}
