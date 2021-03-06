<?php
/**
 * PHP version 5
 *
 * @package    generalDriver
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\Condition\Property;

use ContaoCommunityAlliance\DcGeneral\Data\ModelInterface;
use ContaoCommunityAlliance\DcGeneral\Data\PropertyValueBag;
use ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\LegendInterface;
use ContaoCommunityAlliance\DcGeneral\DataDefinition\Palette\PropertyInterface;

/**
 * Only for debugging purpose. Call the match() method on the wrapped condition and
 * dump the result with a backtrace.
 */
class DumpingPropertyCondition implements PropertyConditionInterface
{

    /**
     * The condition to dump.
     *
     * @var PropertyConditionInterface
     */
    protected $propertyCondition;

    /**
     * Create a new instance.
     *
     * @param PropertyConditionInterface $propertyCondition The condition to debug.
     */
    public function __construct($propertyCondition)
    {
        $this->propertyCondition = $propertyCondition;
    }

    /**
     * {@inheritdoc}
     */
    public function match(
        ModelInterface $model = null,
        PropertyValueBag $input = null,
        PropertyInterface $property = null,
        LegendInterface $legend = null
    ) {
        $result = $this->propertyCondition->match($model, $input, $property, $legend);

        // @codingStandardsIgnoreStart - We explicitely allow var_dump() here for debugging purposes.
        echo '<pre>$condition: </pre>';
        var_dump($this->propertyCondition);
        echo '<pre>$model: </pre>';
        var_dump($model);
        echo '<pre>$input: </pre>';
        var_dump($input);
        echo '<pre>$condition->match() result: </pre>';
        var_dump($result);
        echo '<pre>';
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        echo '</pre>';
        // @codingStandardsIgnoreEnd

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
        $this->propertyCondition = clone $this->propertyCondition;
    }
}
