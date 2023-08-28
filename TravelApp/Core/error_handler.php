<?php

use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\ErrorHandler\ErrorHandler;

Debug::enable();

$errorHandler = new ErrorHandler();

// $errorHandler->setExceptionHandler();
// $errorHandler->setErrorHandler();
// $errorHandler->setFatalErrorHandler();

?>