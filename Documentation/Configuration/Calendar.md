Configuration / Calendar
========================

Calendar Widget can be configured by either passing an instance of `DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration` or an array.

## Options
None of the options below is required (But an empty array at least).
      
| name                 | type      | default       | description                                                          |
|----------------------|-----------|---------------|----------------------------------------------------------------------|
| displayPeriod        | *integer* | 2 (month)     | Determines the initial display period.                               |
|                      |           |               | one of the CalendarConfiguration constants                           |                                             
|                      |           |               | PERIOD_DAY = 0                                                       |
|                      |           |               | PERIOD_WEEK = 1                                                      |
|                      |           |               | PERIOD_MONTH = 2                                                     |
|                      |           |               | PERIOD_QUARTER = 3 (three months)                                    |
|                      |           |               | PERIOD_SEMESTER = 5 (six months)                                     |
|                      |           |               | PERIOD_YEAR = 6                                                      |
| startDate            | *string*  | today         | A string as understood by \DateTime->modify() method.                |
| viewMode             | *integer* | 2 (combo view)| Determines the view mode.                                            |
|                      |           |               | one of the CalendarConfiguration constants                           |                                             
|                      |           |               | VIEW_MODE_COMBO_PANE = 1 - allows switching between display periods. |
|                      |           |               | VIEW_MODE_MINI_MONTH = 2 - Small month only.                         |
| ajaxEnabled          | *boolean* | false         | Enables navigation by Ajax.                                          |
|                      |           |               | Required JavaScript is **not** included automatically.               |
|showCalendarNavigation| *boolean* | false         | Displays navigation elements.                                        |

For developers see: [CalendarConfiguration](../DevelopersManual/CalendarConfiguration.md).
 
