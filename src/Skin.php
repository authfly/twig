<?php
// Authfly skin: the class recipes of ../react/src/skin/skin.ts (tokens only), merged with the CLI runtime cn.
declare(strict_types=1);

namespace Authfly\Twig;

use UI8Kit\Twig\Rt;

final class Skin
{
    private const CONTROL = 'inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded inset-ring font-medium transition-colors';
    public const TEXT = [
        'title' => 'text-2xl font-bold text-foreground',
        'subtitle' => 'text-sm font-semibold text-foreground',
        'muted' => 'text-sm text-muted-foreground',
        'hint' => 'text-xs text-muted-foreground',
    ];
    public const GAP = ['0' => 'gap-0', '2' => 'gap-2', '4' => 'gap-4', '6' => 'gap-6', '8' => 'gap-8'];
    public const ALIGN = ['start' => 'items-start', 'center' => 'items-center', 'end' => 'items-end', 'stretch' => 'items-stretch'];
    public const JUSTIFY = ['start' => 'justify-start', 'center' => 'justify-center', 'end' => 'justify-end', 'between' => 'justify-between'];

    public static function cn(?string ...$parts): string
    {
        return Rt::cn(array_map(static fn ($p) => $p ?? '', $parts));
    }

    public static function button(string $variant = 'default', ?string $class = null): string
    {
        return self::cn(self::CONTROL, 'h-10 px-4 text-sm disabled:pointer-events-none disabled:opacity-50', 'focus-visible:inset-ring-ring',
            $variant === 'default' ? 'bg-primary text-primary-foreground inset-ring-primary' : '',
            $variant === 'outline' ? 'bg-card text-foreground inset-ring-border hover:bg-accent hover:text-accent-foreground' : '',
            $variant === 'ghost' ? 'bg-transparent text-foreground inset-ring-transparent hover:bg-accent hover:text-accent-foreground' : '',
            $class);
    }

    public static function link(?string $class = null): string
    {
        return self::cn('inline-flex items-center gap-2 font-semibold text-foreground underline-offset-4 hover:underline focus-visible:underline', $class);
    }

    public static function input(?string $class = null): string
    {
        return self::cn('h-10 w-full min-w-0 rounded bg-background px-3 text-base text-foreground inset-ring inset-ring-input outline-none md:text-sm',
            'focus-visible:inset-ring-ring disabled:cursor-not-allowed disabled:opacity-50', $class);
    }

    public static function label(?string $class = null): string
    {
        return self::cn('text-sm font-semibold text-foreground', $class);
    }

    public static function checkbox(?string $class = null): string
    {
        return self::cn('size-4 shrink-0 accent-primary disabled:cursor-not-allowed disabled:opacity-50', $class);
    }

    public static function badge(string $variant = 'default', ?string $class = null): string
    {
        return self::cn('inline-flex h-6 shrink-0 items-center justify-center whitespace-nowrap rounded-full px-2 text-xs font-medium inset-ring',
            $variant === 'default' ? 'bg-primary text-primary-foreground inset-ring-primary' : '',
            $variant === 'secondary' ? 'bg-muted text-foreground inset-ring-transparent' : '',
            $variant === 'outline' ? 'bg-transparent text-foreground inset-ring-border' : '',
            $class);
    }

    /** Alert tones recolour text + ring on the shared bg-muted surface (unknown tone = default). */
    public const ALERT_TONE = [
        'default' => 'text-foreground inset-ring-border',
        'success' => 'text-success inset-ring-success',
        'warning' => 'text-warning inset-ring-warning',
        'destructive' => 'text-destructive inset-ring-destructive',
    ];

    /** tone default|success|warning|destructive. Alert is a block, not a control: 8px layout step, py-2 px-4
     *  (one text-xs line + py-2 = the old min-h-8, so a one-line alert keeps its 32px height). */
    public static function alert(string $tone = 'default', ?string $class = null): string
    {
        return self::cn('flex min-h-8 items-start gap-2 rounded bg-muted px-4 py-2 text-xs font-semibold inset-ring',
            self::ALERT_TONE[$tone] ?? self::ALERT_TONE['default'], $class);
    }

    public static function iconBadge(string $tone = 'default', ?string $class = null): string
    {
        return self::cn('inline-flex size-12 shrink-0 items-center justify-center rounded inset-ring',
            $tone === 'destructive' ? 'bg-muted text-destructive inset-ring-destructive' : 'bg-muted text-muted-foreground inset-ring-transparent', $class);
    }

    /** Card surface only (no width, no centring): consumers place it in their own layout. */
    public static function card(?string $class = null): string
    {
        return self::cn('flex w-full flex-col gap-6 rounded bg-card p-6 text-card-foreground inset-ring inset-ring-border', $class);
    }

    /** Width + centring of the six Authfly widgets, passed to card as its class (account: max-w-lg). */
    public static function widgetCard(?string $class = null): string
    {
        return self::cn('mx-auto max-w-sm', $class);
    }

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
