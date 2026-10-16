<?php /* #?ini charset="utf-8"?

[OWSimpleOperatorSettings]
# Display Function Call and Results via ezDebug:writeDebug
# (arguments and results of every call; enable it while developing only)
DebugOutput=disabled

# Names of system functions that
# are usable as template operators.
# Every template can call them with any argument, so list only functions
# without side effects that read nothing outside their arguments: a function
# such as file_get_contents would let a template read any file the web server
# can read.

[PHPFunctions]
PermittedFunctionList[]
PermittedFunctionList[]=time
PermittedFunctionList[]=mktime
PermittedFunctionList[]=getdate
PermittedFunctionList[]=str_replace
PermittedFunctionList[]=str_rot13

# Class file path, Class Name, Class Method
# that are useable as template operators

[ClassOperators]
PermittedClassOperatorList[]
#PermittedClassOperatorList[]=extension/owsimpleoperator/autoloads/exampleoperator.php;ExampleOperator;example_sum

*/ ?>
