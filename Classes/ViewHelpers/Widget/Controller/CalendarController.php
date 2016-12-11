<?php
namespace DWenzel\T3calendar\ViewHelpers\Widget\Controller;

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
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetController;

/**
 * Class CalendarController
 * @package DWenzel\T3calendar\ViewHelpers\Widget\Controller
 */
class CalendarController extends AbstractWidgetController
{
    /**
     * @var CalendarConfiguration
     */
    protected $configuration;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array|\Iterator
     */
    protected $objects;

    /**
     * @var string
     */
    protected $id;

    /**
     * @return void
     */
    public function initializeAction()
    {
        $this->objects = $this->widgetConfiguration['objects'];
        $this->configuration = $this->widgetConfiguration['configuration'];
        $this->id = $this->widgetConfiguration['id'];
    }
}