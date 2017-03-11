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
     * unix time stamps indicating the date of CalendarItems.
     * The value at each key is an ObjectStorage containing only objects
     * which implement the CalendarItemInterface.
     * @var array
     */
    protected $dateStorage = [];

    /**
     * Adds an object in the storage, and optionally associate it to some data.
     * Objects which do not implement the CalendarItemInterface are ignored.
     *
     * @param CalendarItemInterface|object $object The object to add.
     * @param mixed $information The data to associate with the object.
     * @return void
     */
    public function attach($object, $information = null)
    {
        if (!$this->isValidObject($object)) {
            return;
        }
        $this->offsetSet($object, $information);

        $date = $object->getDate();
        $endDate = clone $date;
        if (
            method_exists($object, 'getEndDate')
        && $object->getEndDate() instanceof \DateTime
            && $object->getEndDate() >= $date
        ) {
            $endDate = $object->getEndDate();
        }

        $current = clone $date;
        while ($current <= $endDate) {
            $interval = new \DateInterval('P1D');
            $itemsForDate = $this->getByDate($current);
            $itemsForDate->attach($object, $information);
            $this->dateStorage[$current->getTimestamp()] = $itemsForDate;
            $current->add($interval);
        }
    }

    /**
     * Removes an object from the storage.
     * Objects which do not implement the CalendarItemInterface are ignored.
     *
     * @param CalendarItemInterface|object $object The object to remove.
     */
    public function detach($object)
    {
        if (!$this->isValidObject($object)) {
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
     * Tells if any calendar item for a given date exist in storage
     *
     * @param \DateTime $dateTime
     * @return bool
     */
    public function hasItemsForDate(\DateTime $dateTime)
    {
        return isset($this->dateStorage[$dateTime->getTimestamp()]);
    }

    /**
     * Get all calendar items for a given date.
     * If any exist an ObjectStorage containing the items
     * is returned otherwise an empty ObjectStorage
     *
     * @param \DateTime $dateTime
     * @return ObjectStorage
     */
    public function getByDate(\DateTime $dateTime)
    {
        if ($this->hasItemsForDate($dateTime)) {
            return $this->dateStorage[$dateTime->getTimestamp()];
        }

        return new ObjectStorage();
    }

    /**
     * Tells if an object is valid. It must be an instance of
     * CalendarItemInterface and its method getDate must return an
     * instance of \DateTime
     *
     * @param $object
     * @return bool
     */
    protected function isValidObject($object)
    {
        return ($object instanceof CalendarItemInterface
            && $object->getDate() instanceof \DateTime);
    }
}
