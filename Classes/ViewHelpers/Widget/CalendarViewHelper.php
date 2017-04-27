<?php

namespace DWenzel\T3calendar\ViewHelpers\Widget;

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

use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;
use DWenzel\T3calendar\Persistence\CalendarItemStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;

/**
 * This ViewHelper renders a Calendar.
 * = Examples =
 * <code title="required arguments">
 * <t3c:widget.calendar objects="{events}" configuration="{calendarConfiguration}" />
 * </code>
 */
class CalendarViewHelper extends AbstractWidgetViewHelper
{

    /**
     * @var \DWenzel\T3calendar\ViewHelpers\Widget\Controller\CalendarController
     * @inject
     */
    protected $controller;

    /**
     * @var bool
     */
    protected $ajaxWidget = false;

    /**
     * Initialize the arguments of the ViewHelper, and call the render() method of the ViewHelper.
     *
     * @return string the rendered ViewHelper.
     */
    public function initialize()
    {
        if ($this->hasArgument('configuration') &&
            $this->arguments['configuration'] instanceof CalendarConfiguration
        ) {
            /** @var CalendarConfiguration $configuration */
            $configuration = $this->arguments['configuration'];
            $this->ajaxWidget = $configuration->getAjaxEnabled();
        }
    }

    /**
     * initialize arguments
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('objects', 'mixed', 'Required: Array or instance of \Iterator or \TYPO3\CMS\Extbase\Persistence\QueryResultInterface or \DWenzel\T3calendar\Persistence\CalendarItemStorage', true)
            ->registerArgument('configuration', 'mixed', 'Required: Instance of \DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration or array')
            ->registerArgument('id', 'string', 'Optional: String, identifier for widget');
    }

    /**
     * @return string
     */
    public function render()
    {

        $objects = $this->arguments['objects'];

        if ($this->hasArgument('configuration')) {
            $configuration = $this->arguments['configuration'];
        }

        if (!($objects instanceof QueryResultInterface || $objects instanceof CalendarItemStorage || is_array($objects))) {
            $objectType = '';
            if (is_object($objects)) {
                $objectType = get_class($objects) . ' ';
            }

            throw new \UnexpectedValueException('Supplied object type ' . $objectType . 'must be QueryResultInterface or CalendarItemStorage or be an array.', 1493322353);
        }

        if (!empty($configuration) && !($configuration instanceof CalendarConfiguration || is_array($configuration))) {
            $configurationType = '';
            if (is_object($configuration)) {
                $configurationType = get_class($configuration) . ' ';
            }

            throw new \UnexpectedValueException('Supplied configuration type ' . $configurationType . 'must be CalendarConfiguration or be an array.', 1493322353);
        }

        return $this->initiateSubRequest();
    }

}
