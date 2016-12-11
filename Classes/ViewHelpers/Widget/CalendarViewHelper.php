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

use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration;

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
     * @param \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array|\Iterator $objects
     * @param \DWenzel\T3calendar\Domain\Model\Dto\CalendarConfiguration $configuration
     * @param string $id
     * @return string
     */
    public function render($objects, CalendarConfiguration $configuration = null, $id = null)
    {
        return $this->initiateSubRequest();
    }
}
