<?php

$classOperatorIniSettings = (array)eZINI::instance('owsimpleoperator.ini')->variable( 'ClassOperators', 'PermittedClassOperatorList' );
$eZTemplateOperatorArray = array(
    // This operator is added in owsimpleoperator.ini
     /*array(
        'script' => 'extension/owsimpleoperator/autoloads/exampleoperator.php',
        'class' => 'ExampleOperator',
        'operator_names' => array(
            'example_sum'
        ) ),*/
     array(
        'script' => 'extension/owsimpleoperator/autoloads/phpfunctionoperator.php',
        'class' => 'PHPFunctionOperator',
        'operator_names' => (array)eZINI::instance('owsimpleoperator.ini')->variable( 'PHPFunctions', 'PermittedFunctionList' )
        )
);
$classMethods = array();

foreach( $classOperatorIniSettings as $settingEntryItems )
{
    // "file;class;operator"; the empty PermittedClassOperatorList[] that clears the list in the settings is skipped
    $settingEntry = explode( ';', (string)$settingEntryItems );
    if ( count( $settingEntry ) < 3 )
    {
        continue;
    }
    $classFileName = $settingEntry[0];
    $className = $settingEntry[1];
    $classMethod = $settingEntry[2];

    if( !in_array( $className, $classMethods ) )
    {
        $classMethods[ $className ]['script'] = $classFileName;
        $classMethods[ $className ]['operator_names'][] = $classMethod;
    }
}

foreach( $classMethods as $className => $classParameters )
{
      $classFileName = $classParameters['script'];
      $classMethods = $classParameters['operator_names'];
      $eZTemplateOperatorArray[] = array( 'script' => $classFileName, 'class' => $className, 'operator_names' => $classMethods );
}
