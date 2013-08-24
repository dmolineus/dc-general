<?php
/**
 * PHP version 5
 * @package    generalDriver
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace DcGeneral\DataDefinition\Interfaces;

use DcGeneral\DataDefinition\Interfaces\Condition;
use DcGeneral\Data\ModelInterface;

abstract class BaseCondition implements Condition
{
	public static function checkCondition(ModelInterface $objParentModel, $arrFilter)
	{
		switch ($arrFilter['operation'])
		{
			case 'AND':
			case 'OR':
				// FIXME: backwardscompat - remove when done
				if (!is_array($arrFilter['children']))
				{
					$arrFilter['children'] = $arrFilter['childs'];
				}
				// End of b.c. code.

				if ($arrFilter['operation'] == 'AND')
				{
					foreach ($arrFilter['children'] as $arrChild)
					{
						// AND => first false means false
						if (!self::checkCondition($objParentModel, $arrChild))
						{
							return false;
						}
					}
					return true;
				}
				else
				{
					foreach ($arrFilter['children'] as $arrChild)
					{
						// OR => first true means true
						if (self::checkCondition($objParentModel, $arrChild))
						{
							return true;
						}
					}
					return false;
				}
				break;

			case '=':
				return ($objParentModel->getProperty($arrFilter['property']) == $arrFilter['value']);
				break;
			case '>':
				return ($objParentModel->getProperty($arrFilter['property']) > $arrFilter['value']);
				break;
			case '<':
				return ($objParentModel->getProperty($arrFilter['property']) < $arrFilter['value']);
				break;

			case 'IN':
				return in_array($objParentModel->getProperty($arrFilter['property']), $arrFilter['value']);
				break;

			default:
				throw new \RuntimeException('Error processing filter array - unknown operation ' . var_export($arrFilter, true), 1);
		}
	}
}
