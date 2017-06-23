<?php

namespace DWenzel\T3calendar\Domain\Model\Dto;

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

use DWenzel\T3calendar\Domain\Factory\ObjectManagerTrait;
use TYPO3\CMS\Core\SingletonInterface;

/**
 * Class CalendarConfigurationFactory
 * @package DWenzel\T3calendar\Domain\Model\Dto
 */
class CalendarConfigurationFactory implements CalendarConfigurationFactoryInterface, SingletonInterface
{
    use ObjectManagerTrait;

    /**
     * Creates a CalendarConfiguration object
     * @param array $settings
     * @return CalendarConfiguration
     */
    public function create(array $settings)
    {
        /** @var CalendarConfiguration $configuration */
        $configuration = $this->objectManager->get(CalendarConfiguration::class);

        $displayPeriod = CalendarConfiguration::PERIOD_MONTH;

        if (isset($settings['displayPeriod'])) {
            $displayPeriod = (int)$settings['displayPeriod'];
        }
        $configuration->setDisplayPeriod($displayPeriod);

        $dateString = 'today';
        /** @var \DateTimeZone $timeZone */
        $timeZone = new \DateTimeZone(date_default_timezone_get());
        /** @var \DateTime $startDate */
        $startDate = new \DateTime($dateString, $timeZone);

        $currentDate = new \DateTime($dateString, $timeZone);
        $configuration->setCurrentDate($currentDate);

        switch ($configuration->getDisplayPeriod()) {
            case CalendarConfiguration::PERIOD_WEEK:
                $dateString = 'monday this week';
                break;
            case CalendarConfiguration::PERIOD_YEAR:
                $dateString = 'first day of january ' . $currentDate->format('Y');
                break;
            default:
                $dateString = 'first day of this month';
        }

        if (!empty($settings['startDate'])) {
            $dateString = $settings['startDate'];
        }

        $startDate->modify($dateString);
        $configuration->setStartDate($startDate);

        $viewMode = CalendarConfiguration::VIEW_MODE_COMBO_PANE;
        if (!empty($settings['viewMode'])) {
            $viewMode = (int)$settings['viewMode'];
        }

        if (isset($settings['ajaxEnabled'])) {
            $configuration->setAjaxEnabled((bool)$settings['ajaxEnabled']);
        }

        if (isset($settings['showCalendarNavigation'])) {
            $configuration->setShowNavigation((bool)$settings['showCalendarNavigation']);
        }

        $configuration->setViewMode($viewMode);

        return $configuration;
    }
}
