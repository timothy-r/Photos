<?php

 $I= new WebGuy($scenario);
 $I->wantTo('Check the home page for a welcome message');
 $I->amOnPage('/');
 $I->see('Photos');

