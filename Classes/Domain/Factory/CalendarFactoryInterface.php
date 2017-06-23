<?php
namespace DWenzel\T3calendar\Domain\Factory;

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

use DWenzel\T3calendar\Domain\Model\Calendar;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class CalendarFactory
 * @package DWenzel\T3calendar\Domain\Factory
 */
interface CalendarFactoryInterface
{
    /**
     * Creates a Calendar from configuration.
     * Items will be added to matching CalendarDays
     *
     * @param CalendarConfiguration $configuration
     * @param QueryResultInterface|array|\Iterator $items Array holding CalendarItemInterface objects
     * @return Calendar
     */
    public function create(CalendarConfiguration $configuration, $items);
}
