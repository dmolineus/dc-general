<?php

namespace DcGeneral\Contao\Event;

use DcGeneral\Contao\BackendBindings;
use DcGeneral\DataDefinition\Definition\View\ListingConfigInterface;
use DcGeneral\View\Event\RenderReadablePropertyValueEvent;
use DcGeneral\Contao\View\Contao2BackendView\Event\GetBreadcrumbEvent;
use DcGeneral\View\Widget\Event\ResolveWidgetErrorMessageEvent;
use DcGeneral\Contao\View\Contao2BackendView\Event\GetPropertyOptionsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DcGeneral\Contao\View\Contao2BackendView\Event\GetGroupHeaderEvent;
use DcGeneral\Contao\View\Contao2BackendView\Event\GetParentHeaderEvent;

/**
 * Class Subscriber - gateway to the legacy Contao HOOK style callbacks.
 *
 * @package DcGeneral\Event
 */
class Subscriber
	implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return array
		(
			GetBreadcrumbEvent::NAME         => 'GetBreadcrumb',

			ResolveWidgetErrorMessageEvent::NAME => array('resolveWidgetErrorMessage', -1),

			RenderReadablePropertyValueEvent::NAME => 'renderReadablePropertyValue',
		);
	}

	public function GetBreadcrumb(GetBreadcrumbEvent $event)
	{
		$arrReturn = $event->getEnvironment()
			->getCallbackHandler()->generateBreadcrumb();

		$event->setElements($arrReturn);
	}

	public function resolveWidgetErrorMessage(ResolveWidgetErrorMessageEvent $event)
	{
		$error = $event->getError();

		if ($error instanceof \Exception)
		{
			$event->setError($error->getMessage());
		}
		else if (is_object($error))
		{
			if (method_exists($error, '__toString'))
			{
				$event->setError((string) $error);
			}
			else
			{
				$event->setError(sprintf('[%s]', get_class($error)));
			}
		}
		else if (!is_string($error))
		{
			$event->setError(sprintf('[%s]', gettype($error)));
		}
	}

	public function renderReadablePropertyValue(RenderReadablePropertyValueEvent $event)
	{
		if ($event->getRendered() !== null) {
			return;
		}

		$property = $event->getProperty();
		$value    = $event->getValue();

		$extra = $property->getExtra();

		/*
		 * TODO refactor
		if (isset($arrFieldConfig['foreignKey']))
		{
			$temp = array();
			$chunks = explode('.', $arrFieldConfig['foreignKey'], 2);


			foreach ((array) $value as $v)
			{
//                    $objKey = $this->Database->prepare("SELECT " . $chunks[1] . " AS value FROM " . $chunks[0] . " WHERE id=?")
//                            ->limit(1)
//                            ->execute($v);
//
//                    if ($objKey->numRows)
//                    {
//                        $temp[] = $objKey->value;
//                    }
			}

//                $row[$i] = implode(', ', $temp);
		}
		// Decode array
		else
		 */
		if (is_array($value))
		{
			foreach ($value as $kk => $vv)
			{
				if (is_array($vv))
				{
					$vals = array_values($vv);
					$value[$kk] = $vals[0] . ' (' . $vals[1] . ')';
				}
			}

			$event->setRendered(implode(', ', $value));
		}
		// Date Formate
		else if ($extra['rgxp'] == 'date')
		{
			$event->setRendered(BackendBindings::parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $value));
		}
		// Date Formate
		else if ($extra['rgxp'] == 'time')
		{
			$event->setRendered(BackendBindings::parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $value));
		}
		// Date Formate
		else if (
			$extra['rgxp'] == 'datim' ||
			in_array($property->getGroupingMode(), array(ListingConfigInterface::GROUP_DAY, ListingConfigInterface::GROUP_MONTH, ListingConfigInterface::GROUP_YEAR)) ||
			$property->getName() == 'tstamp'
		) {
			$event->setRendered(BackendBindings::parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $value));
		}
		else if ($property->getWidgetType() == 'checkbox' && !$extra['multiple'])
		{
			$event->setRendered(strlen($value) ? $GLOBALS['TL_LANG']['MSC']['yes'] : $GLOBALS['TL_LANG']['MSC']['no']);
		}
		else if ($property->getWidgetType() == 'textarea' && ($extra['allowHtml'] || $extra['preserveTags']))
		{
			$event->setRendered(nl2br_html5(specialchars($value)));
		}
		/**
		 * TODO refactor
		else if (is_array($arrFieldConfig['reference']))
		{
			return isset($arrFieldConfig['reference'][$mixModelField]) ?
				((is_array($arrFieldConfig['reference'][$mixModelField])) ?
					$arrFieldConfig['reference'][$mixModelField][0] :
					$arrFieldConfig['reference'][$mixModelField]) :
				$mixModelField;
		}
		 */
		else if (array_is_assoc($property->getOptions()))
		{
			$options = $property->getOptions();
			$event->setRendered($options[$value]);
		}
		else if ($value instanceof \DateTime) {
			$event->setRendered(BackendBindings::parseDate($GLOBALS['TL_CONFIG']['datimFormat'], $value->getTimestamp()));
		}
	}
}
