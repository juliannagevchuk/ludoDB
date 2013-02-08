<?php
/**
 * Created by JetBrains PhpStorm.
 * User: xait0020
 * Date: 08.02.13
 * Time: 21:59
 */

require_once __DIR__."/../autoload.php";
class LudoDBTreeCollectionTest extends TestBase
{

    /**
     * @test
     */
    public function shouldBeAbleToGetTopNodes(){
        // given
        $node = new TestNodes();

        // when
        $values = $node->getValues();

        // then
        $this->assertEquals(2,count($values));

    }
    /**
     * @test
     */
    public function shouldBeAbleToGetChildNodes(){
        // given
        $node = new TestNodes();

        // when
        $values = $node->getValues();

        $children = $values[0]["children"];

        // then
        $this->assertEquals(3,count($children));

    }
    /**
     * @test
     */
    public function shouldBeAbleToGetGrandChildren(){
        // given
        $node = new TestNodes();

        // when
        $values = $node->getValues();

        $children = $values[0]["children"][0]['children'];

        // then
        $this->assertEquals(2,count($children));
    }

    /**
     * @test
     */
    public function shouldGetParserKeys(){
        // given
        $node = new TestNodes();

        // when
        $this->assertEquals('parent', $node->configParser()->getFK());
        $this->assertEquals('id', $node->configParser()->getPK());
        $this->assertEquals('children', $node->configParser()->getChildKey());
    }
}
