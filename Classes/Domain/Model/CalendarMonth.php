<?php
namespace DWenzel\T3calendar\Domain\Model;

/**
 * This file is part of the TYPO3 CMS project.
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class CalendarMonth
 * @package DWenzel\T3calendar\Domain\Model
 */
class CalendarMonth {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3calendar\Domain\Model\CalendarWeek>
	 */
	protected $weeks;

	/**
	 * @var \DateTime
	 */
	protected $startDate;

	/**
	 * __construct
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->weeks = new ObjectStorage();
	}

	/**
	 * Gets the weeks
	 *
	 * @return ObjectStorage
	 */
	public function getWeeks() {
		return $this->weeks;
	}

	/**
	 * Sets the weeks
	 *
	 * @param ObjectStorage $weeks
	 */
	public function setWeeks(ObjectStorage $weeks) {
		$this->weeks = $weeks;
	}

	/**
	 * Adds a week
	 *
	 * @param CalendarWeek $week
	 */
	public function addWeek(CalendarWeek $week) {
		$this->weeks->attach($week);
	}

	/**
	 * Removes a week
	 *
	 * @param CalendarWeek $week
	 */
	public function removeWeek(CalendarWeek $week) {
		$this->weeks->detach($week);
	}

	/**
	 * Gets the start date
	 *
	 * @return \DateTime
	 */
	public function getStartDate() {
		return $this->startDate;
	}

	/**
	 * Sets the start date
	 *
	 * @param \DateTime $startDate
	 */
	public function setStartDate($startDate) {
		$this->startDate = $startDate;
	}

	/**
	 * Gets the month
	 *
	 * @param string $format A format as understood by date(). Default 'n'
	 * @return null|string
	 */
	public function getMonth($format = 'n') {
		if ($this->startDate !== NULL) {
			return $this->startDate->format($format);
		}

		return NULL;
	}
}
