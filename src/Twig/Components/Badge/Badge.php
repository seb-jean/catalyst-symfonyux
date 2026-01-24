<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig\Components\Badge;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

/**
 * @phpstan-ignore-next-line symfonyUX.twigComponent.classMustBeFinal
 */
#[AsTwigComponent(
    name: 'Badge',
    template: 'components/Badge.html.twig',
    exposePublicProps: false,
)]
class Badge
{
    public string $label;

    public string $value;

    public string $icon;

    public string $url;

    /**
     * @return array{icon: ?string, label: string, value: string, url: ?string}
     */
    #[ExposeInTemplate(destruct: true)]
    public function getBadge(): array
    {
        return [
            'icon' => $this->getIcon(),
            'label' => $this->getLabel(),
            'value' => $this->getValue(),
            'url' => $this->getUrl(),
        ];
    }

    private function getLabel(): string
    {
        return $this->label;
    }

    private function getValue(): string
    {
        return $this->value ?? '';
    }

    private function getIcon(): string
    {
        return $this->icon;
    }

    private function getUrl(): string
    {
        return $this->url ?? '';
    }
}
