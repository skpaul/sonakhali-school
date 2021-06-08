# SwiftDatetime

A php8 library for working with datetime.

Main objective of this library is to take an input and return an output.



## Initialization

```php
require_once("SwiftDatetime.php");

$swiftDatetime = new SwiftDatetime($timezone); //default $timezone = "Asia/Dhaka"
```

## Main Concept

SwiftDatetime works as the following principles

```php
$var = $swiftDatetime->takeInput()->performDateOperations()->returnOutput();

//performDateOperations() is optional.
$var = $swiftDatetime->takeInput()->returnOutput();

//It can be done in multiline (or by method chaining as above) 
$takenInput = $swiftDatetime->takeInput();
$returnValue = $takenInput->returnOutput();
```



## The ways of taking input from outside

##### 1. By using - *now()* method

```php
$myDatetime = $swiftDatetime->now(); 
```

//input- current system datetime

Does not return any value, but internally stores it within the class.

So, **$myDatetime** is now an instance of SwiftDatetime.



##### 2. BY USING *input()* method

```php
$myDatetime = $swiftDatetime->input($value); 
```

$value -

- any php datetime object or any valid php datetime string.
-  if $value is a string, it converts it to php datetime object. 
- If no parameter passed, input will be NULL.

**Output -**   Returns an instance of SwiftDatetime.  Input **$value** internally stores within the class. 

So, **$myDatetime** is now an instance of SwiftDatetime.



## Perform various operations with date

```
addYears($number_of_years_to_add)
addMonths($number_of_months_to_add)
addDays($number_of_days_to_add)
```



## Get current datetime in different format

In order to get a value from swiftdatetime instance, you must use - 

```php
asObject() or  asYmdHis() or  asYmd() or asdmYHis() or asdmY() or ashis()
```



```php
//as php datetime object
$object =  $myDatetime->asObject();
//output - Returns php datetime object for method chaining (i.e. add, sub, etc).  Throws exception on failure.
//So, $myDatetime is now an object of php datetime.

var_dump($object);  
//object(DateTime)#3 (3) { ["date"]=> string(26) "2021-03-31 14:02:47.386842" ["timezone_type"]=> int(3) ["timezone"]=> string(10) "Asia/Dhaka" }


$asYmdHis = $myDatetime->asYmdHis();
echo $asYmdHis;  //"2021-03-31 14:05:17"

$asYmd = $myDatetime->asYmd();
echo $asYmd;  //"2021-03-24"

//Other similar methods are
asdmYHis(),  asdmY(), ashis()

```

