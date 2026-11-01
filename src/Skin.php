<?php
// Authfly skin: the class recipes of packages/shared/src/skin/recipes.ts (tokens only), merged with the CLI runtime cn.
declare(strict_types=1);

namespace Authfly\Twig;

use UI8Kit\Twig\Rt;

final class Skin
{
    // Class recipes of packages/shared/src/skin/recipes.ts (tables generated into SkinRecipes.php by tools/gen-shared.ts).
    public const TEXT = SkinRecipes::TEXT;
    public const GAP = SkinRecipes::GAP;
    public const ALIGN = SkinRecipes::ALIGN;
    public const JUSTIFY = SkinRecipes::JUSTIFY;

    public static function cn(?string ...$parts): string
    {
        return Rt::cn(array_map(static fn ($p) => $p ?? '', $parts));
    }

    /** Recipe name + variant (unknown variant: the recipe's fallback, else none) + consumer classes. */
    private static function skin(string $name, string $variant, ?string $class): string
    {
        $r = SkinRecipes::RECIPES[$name];
        $v = $r['variants'][$variant] ?? ($r['fallback'] !== null ? $r['variants'][$r['fallback']] : '');
        return self::cn(...[...$r['base'], $v, $class]);
    }

    public static function button(string $variant = 'default', ?string $class = null): string { return self::skin('button', $variant, $class); }
    public static function link(?string $class = null): string { return self::skin('link', '', $class); }
    public static function input(?string $class = null): string { return self::skin('input', '', $class); }
    public static function label(?string $class = null): string { return self::skin('label', '', $class); }
    public static function checkbox(?string $class = null): string { return self::skin('checkbox', '', $class); }
    public static function badge(string $variant = 'default', ?string $class = null): string { return self::skin('badge', $variant, $class); }
    /** tone default|success|warning|destructive. */
    public static function alert(string $tone = 'default', ?string $class = null): string { return self::skin('alert', $tone, $class); }
    public static function iconBadge(string $tone = 'default', ?string $class = null): string { return self::skin('iconBadge', $tone, $class); }
    /** Card surface only (no width, no centring): consumers place it in their own layout. */
    public static function card(?string $class = null): string { return self::skin('card', '', $class); }
    /** Width + centring of the six Authfly widgets, passed to card as its class (account: max-w-lg). */
    public static function widgetCard(?string $class = null): string { return self::skin('widgetCard', '', $class); }

    /** Lucide glyph inner SVG markup (static, trusted data); unknown names fall back to "circle". */
    public static function lucide(string $name): string
    {
        static $icons = null;
        $icons ??= require __DIR__ . '/lucide-icons.php';
        return $icons[$name] ?? $icons['circle'];
    }

    /** Attribute map without null / '' values (React drops undefined props). */
    public static function attrs(array $a): array
    {
        return array_filter($a, static fn ($v) => $v !== null && $v !== '');
    }

    /** aria-describedby value from ids, null when empty. */
    public static function describe(?string ...$ids): ?string
    {
        $s = implode(' ', array_filter($ids, static fn ($v) => $v !== null && $v !== ''));
        return $s === '' ? null : $s;
    }
}
