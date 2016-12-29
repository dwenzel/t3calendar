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
 * Class CalendarYear
 * @package DWenzel\T3calendar\Domain\Model
 */
class CalendarYear {

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DWenzel\T3calendar\Domain\Model\CalendarMonth>
	 */
	protected $months;

	/**
	 * @var \DateTime
	 */
	protected $startDate;

	/**
	 * __construct
	 */
	public function __construct() {
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \TYPO3\CMS\Extbase\Persistence\ObjectStorage properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		$this->months = new ObjectStorage();
	}

	/**
	 * Gets the months
	 *
	 * @return ObjectStorage
	 */
	public function getMonths() {
		return $this->months;
	}

	/**
	 * Sets the months
	 *
	 * @param ObjectStorage $months
	 */
	public function setMonths(ObjectStorage $months) {
		$this->months = $months;
	}

	/**
	 * Adds a month
	 *
	 * @param CalendarMonth $month
	 */
	public function addMonth(CalendarMonth $month) {
		$this->months->attach($month);
	}

	/**
	 * Removes a month
	 *
	 * @param CalendarMonth $month
	 */
	public function removeMonth(CalendarMonth $month) {
		$this->months->detach($month);
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
	 * Gets the year
	 *
	 * @param string $format A format as understood by date(). Default 'y'
	 * @return null|string
	 */
	public function getYear($format = 'Y') {
		if ($this->startDate !== NULL) {
			return $this->startDate->format($format);
		}

		return NULL;
	}
}
