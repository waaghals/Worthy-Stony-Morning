<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Aggressiveswallow\Helpers;

/**
 * Description of b
 *
 * @author Patrick
 */
class B extends A{
    
    function test($caller) {
        printf("B::Test() from %s", $caller);
        parent::test("B");
    }
}
