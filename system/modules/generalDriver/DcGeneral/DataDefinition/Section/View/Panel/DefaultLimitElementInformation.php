<?php
/**
 * PHP version 5
 * @package    generalDriver
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace DcGeneral\DataDefinition\Section\View\Panel;

class DefaultLimitElementInformation implements LimitElementInformationInterface
{
	protected $properties;

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return 'limit';
	}
}