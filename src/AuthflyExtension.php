<?php
declare(strict_types=1);

namespace Authfly\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Markup;
use Twig\TwigFunction;

/** Registers the Authfly skin helpers (af_*) next to the CLI-owned UI8Kit\Twig\TwigExtension. */
final class AuthflyExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('af_skin', static fn (string $name, mixed ...$args): string => Skin::$name(...$args)),
            new TwigFunction('af_text', static fn (string $k): string => Skin::TEXT[$k]),
            new TwigFunction('af_cn', [Skin::class, 'cn']),
            new TwigFunction('af_gap', static fn (?string $k, string $d): string => Skin::GAP[$k ?: $d]),
            new TwigFunction('af_align', static fn (?string $k, string $d): string => Skin::ALIGN[$k ?: $d]),
            new TwigFunction('af_justify', static fn (?string $k): string => $k ? Skin::JUSTIFY[$k] : ''),
            new TwigFunction('af_lucide', [Skin::class, 'lucide'], ['is_safe' => ['html']]),
            new TwigFunction('af_attrs', [Skin::class, 'attrs']),
            new TwigFunction('af_esc', static fn (mixed $v): Markup => new Markup(htmlspecialchars((string) ($v ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'), 'UTF-8')),
            new TwigFunction('af_describe', [Skin::class, 'describe']),
        ];
    }
}
