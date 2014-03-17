<?php require "vendor/autoload.php";

use Ciarand\Midterm\GlobalState;
use Ciarand\Midterm\Reporter\PlainTextReporter;
use Ciarand\Midterm\Reporter\DotReporter;
use Ciarand\Midterm\Reporter\TapReporter;

include "spec/Reporter/DotReporterSpec.php";
include "spec/Reporter/TapReporterSpec.php";
include "spec/SuiteHelperSpec.php";
include "spec/SpecSpec.php";
include "spec/Presenter/PresenterSpec.php";
include "spec/MidtermSpec.php";
include "spec/ContainerSpec.php";

include "spec/Collection/SuiteCollectionSpec.php";

include "spec/CallbackGeneratorSpec.php";
include "spec/Expectation/AmorphousExpectationSpec.php";
include "spec/Expectation/PendingExpectationSpec.php";
include "spec/Expectation/CallbackExpectationSpec.php";
include "spec/Expectation/IdentityExpectationSpec.php";
include "spec/Expectation/AttributeExpectationSpec.php";
include "spec/Expectation/TypeExpectationSpec.php";
include "spec/Expectation/StringExpectationSpec.php";

$midterm = GlobalState::getMidterm();
$midterm->addReporter(new TapReporter);
//$midterm->addReporter(new DotReporter);
exit($midterm->go());
