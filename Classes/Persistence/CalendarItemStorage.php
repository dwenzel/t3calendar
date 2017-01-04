<?php

namespace DWenzel\T3calendar\Persistence;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use DWenzel\T3calendar\Domain\Model\CalendarItemInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
/**
 * Class CalendarItemStorage
 * Transient storage for calendar items. Items must implement the CalendarItemInterface.
 *
 * @package DWenzel\T3calendarDomain\Storage
 */
class CalendarItemStorage extends ObjectStorage
{

    /**
     * An array holding the objects. The key of the array items are
     * @var array
     */
    protected $dateStorage = [];

    /**
     * Adds an object in the storage, and optionally associate it to some data.
     *
     * @param CalendarItemInterface|object $object The object to add.
     * @param mixed $information The data to associate with the object.
     * @return void
     */
    public function attach($object, $information = null)
    {
        if (!$this->isValidObject($object))
        {
            return;
        }
        $date = $object->getDate();
        $this->offsetSet($object, $information);
        $itemsForDate = $this->getByDate($date);
        $itemsForDate->attach($object, $information);
        $this->dateStorage[$date->getTimestamp()] = $itemsForDate;
    }

    /**
     * Removes an object from the storage.
     *
     * @param CalendarItemInterface|object $object The object to remove.
     */
    public function detach($object)
    {
        if (!$this->isValidObject($object))
        {
            return;
        }
        $date = $object->getDate();
        $this->offsetUnset($object);
        $itemsForDate = $this->getByDate($date);
        $itemsForDate->detach($object);
        if ($itemsForDate->count()) {
            $this->dateStorage[$date->getTimestamp()] = $itemsForDate;
        } else {
            unset($this->dateStorage[$date->getTimestamp()]);
        }
    }

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    public function hasItemsForDate(\DateTime $dateTime)
    {
        return isset($this->dateStorage[$dateTime->getTimestamp()]);
    }

    /**
     * Gets all objects for given date
     *
     * @param \DateTime $dateTime
     * @return ObjectStorage
     */
    public function getByDate(\DateTime $dateTime)
    {
        if ($this->hasItemsForDate($dateTime))
        {
            return $this->dateStorage[$dateTime->getTimestamp()];
        }

        return new ObjectStorage();
    }

    /**
     * @param $object
     * @return bool
     */
    protected function isValidObject($object)
    {
        return ($object instanceof CalendarItemInterface
        && $object->getDate() instanceof \DateTime);
    }
}