<?php
require 'Ice.php';
require 'if.php';
 
$ic = null;
try
{
    $ic = Ice_initialize();
    $base = $ic->stringToProxy("SimplePrinter:default -h 10.104.21.105 -p 10000");
    $printer = Demo_PrinterPrxHelper::checkedCast($base);
    if(!$printer)
        throw new RuntimeException("Invalid proxy");
 
    $printer->printString("Hello World!");
}
catch(Exception $ex)
{
    echo $ex;
}
 
if($ic)
{
    // Clean up
    try
    {
        $ic->destroy();
    }
    catch(Exception $ex)
    {
        echo $ex;
    }
}
?>