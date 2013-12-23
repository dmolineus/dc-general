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

namespace DcGeneral\Event;

/**
 * This event is emitted just before a model is deleted.
 *
 * @package DcGeneral\Event
 */
class PreDeleteModelEvent extends AbstractModelAwareEvent
{
	const NAME = 'dc-general.model.pre-delete';
}
