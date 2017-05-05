Configuration / Paths
=====================

The default layout, templates and partials of the Calendar Widget can be found under
`<EXT:t3calendar>/Resources/Private/`

In order to change a single one of these files you don't have to copy all of them.
Instead configure additional paths. Any file with a matching name and location will then overwrite a single original file.

### Example:

Assuming the extension _t3events_ uses the Calendar Widget and we want to change one template and one partial.

The additional files are located at:
```
 fileadmin
  Resources
   Private
    Extensions
     t3calendar
      Partials
       Calendar
        Day.html
      Templates
       Week.html
```

add the following TypoScript to your setup.
```TypoScript
plugin.tx_t3events.view.widget {
 DWenzel\T3calendar\ViewHelpers\Widget\CalendarViewHelper {
 templateRootPaths {
  10 = fileadmin/Resources/Private/Extensions/t3calendar/Templates
 }
 partialRootPaths {
   10 = fileadmin/Resources/Private/Extensions/t3calendar/Partials
  }
 }
}
```

Make sure to clear the Frontend cache.
