<?php

namespace Tests\Tools;

use Aggressiveswallow\Tools\Template;

/**
 * Description of TemplateTest
 *
 * @author Patrick
 */
class TemplateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @expectedException \Exception
     */
    public function testInvalidViewFile() {
        new Template("NonExistingViewFile");
    }

    public function testTemplateMagicMethods() {
        $value = "schaap";
        $t = new Template("errors/Fatal");
        $t->blaat = $value;

        $this->assertEquals($t->blaat, $value);
    }

}
