<?php
namespace Altair\Http\Configuration;

use Altair\Configuration\Contracts\ConfigurationInterface;
use Altair\Configuration\Traits\EnvAwareTrait;
use Altair\Container\Container;
use Altair\Container\Definition;
use Altair\Http\Formatter\PhpViewFormatter;
use Altair\Http\Responder\FormattedResponder;

class PhpViewConfiguration implements ConfigurationInterface
{
    use EnvAwareTrait;

    /**
     * @inheritdoc
     */
    public function apply(Container $container)
    {
        $definition = new Definition([
            ':templatePath' => $this->env->get('HTTP_PHP_VIEW_TEMPLATE_PATH'),
            ':layout' => $this->env->get('HTTP_PHP_VIEW_LAYOUT')
        ]);

        $container
            ->define(PhpViewFormatter::class, $definition)
            ->prepare(FormattedResponder::class, function (FormattedResponder $responder): FormattedResponder {
                return $responder->withFormatter(PhpViewFormatter::class, 1.0);
            });
    }
}
