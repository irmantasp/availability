<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class MonthExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                name: 'month',
                callable: $this->renderMonth(...),
                options: [
                    'is_safe' => ['html'],
                    'needs_environment' => true,
                    'needs_context' => true,
                ]
            ),
        ];
    }

    public function renderMonth(int $year, int $month, array $days): array
    {
    }
}
