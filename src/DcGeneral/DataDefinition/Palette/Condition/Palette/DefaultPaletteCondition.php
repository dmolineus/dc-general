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

namespace DcGeneral\DataDefinition\Palette\Condition\Palette;

use DcGeneral\Data\ModelInterface;
use DcGeneral\Data\PropertyValueBag;

/**
 * Condition for the default palette.
 */
class DefaultPaletteCondition implements PaletteConditionInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function getMatchCount(ModelInterface $model = null, PropertyValueBag $input = null)
	{
		return 0;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __clone()
	{
	}
}