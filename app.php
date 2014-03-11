<?php require "vendor/autoload.php";

use Ciarand\Midterm\GlobalState;
use Ciarand\Midterm\Reporter\PlainTextReporter;
use Ciarand\Midterm\Reporter\DotReporter;
use Ciarand\Midterm\Reporter\TapReporter;

include "spec/Reporter/DotReporterSpec.php";
include "spec/Reporter/TapReporterSpec.php";
include "spec/SuiteHelperSpec.php";
include "spec/SpecSpec.php";
include "spec/Expectation/StrictEqualityMatcherSpec.php";
include "spec/Presenter/PresenterSpec.php";

$midterm = GlobalState::getMidterm();
$midterm->addReporter(new TapReporter);
//$midterm->addReporter(new DotReporter);
exit($midterm->go());
