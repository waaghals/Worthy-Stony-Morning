<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Aggressiveswallow\Helpers;

/**
 * Description of A
 *
 * @author Patrick
 */
class A {
    function test($caller){
        printf("A::Test() from %s", $caller);
        self::test("A");    
    }
}
