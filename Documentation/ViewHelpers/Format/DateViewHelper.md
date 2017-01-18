Format / DateViewHelper
=======================

Formats DateTime objects and strings to dates.

This is an extended version which allows to add a time value (timestamp integer) to a date. Thus a given time can be formatted according to the date (day light saving, time zone etc.)
## Examples

**Convert a DateTime object to string**
```xml
<t3c:format.date>{dateTimeObject}</t3c:format.date>
```
**Output**
```
1980-12-13
```
(depending on date and default date format)

**Custom date format**
```xml
<t3c:format.date format="H:i">{dateObject}</t3c:format.date>
```
**Output** 
```
01:23
```
(depending on the current time)

**strtotime string**
```xml
<t3c:format.date format="d.m.Y - H:i:s">+1 week 2 days 4 hours 2 seconds</t3c:format.date>
```
**Output** 
```
13.12.1980 - 21:03:42
```
(depending on the current time, see http://www.php.net/manual/en/function.strtotime.php)

**Localized dates using strftime date format**
```xml
<t3c:format.date format="%d. %B %Y">{dateObject}</t3c:format.date>
```
**Output** 
```
13. Dezember 1980
```
(depending on the current date and defined locale. In the example you see the 1980-12-13 in a german locale)

**Inline notation**
```
{t3c:format.date(date: dateObject)}
```
**Output** 
```
1980-12-13
```
(depending on the value of {dateObject})

**Inline notation (2nd variant)**
```
{dateObject -> t3c:format.date()}
```
**Output** 
```
1980-12-13
```
(depending on the value of {dateObject})

## Arguments

| Argument | Type   | Description                       | Default |
| -------- | -------| --------------------------------- | ------- |

@todo time, base, arguments
