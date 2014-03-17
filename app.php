<?php require "vendor/autoload.php";

use Ciarand\Midterm\GlobalState;
use Ciarand\Midterm\Config\FileGlobber;
use Ciarand\Midterm\Reporter\TapReporter;

$globber = new FileGlobber("spec/**/*Spec.php");
foreach ($globber->getIterator() as $file => $info) {
    include $file;
}

$midterm = GlobalState::getMidterm();

//TODO add a default reporter
$midterm->addReporter(new TapReporter);

//TODO add a real console bootstrapper file thing
exit($midterm->go());
