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

 use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

 /**
 * Class ObjectManagerTrait
 *
 * @package DWenzel\T3calendar\Domain\Factory
 */
trait ObjectManagerTrait
{
    /**
     * Object manager
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }
}
