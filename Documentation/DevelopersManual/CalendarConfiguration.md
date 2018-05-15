CalendarConfiguration
=====================

Instances of `DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration` should be created by the CalendarConfigurationFactory singleton.
CalendarConfigurationFactoryTrait provides it.

Configuration options for the factory method can be gained, e.g. from a flex form plugin or any array.
See [Configuration/Calendar](../Configuration/Calendar.md) for options.
### Example

```PHP
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfigurationFactoryTrait;

class MyController {
 use  CalendarConfigurationFactoryTrait;
 /**
  * Foo action
  * @return void
  */
  public function fooAction()
 {
    $calendarConfiguration = $this->calendarConfigurationFactory->create($this->settings);
 }
```
