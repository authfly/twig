<?php
// Generic invariants on the 20 shared parity states (same set as the other runtimes) + escaping. Run: php tests/widgets_test.php
declare(strict_types=1);
require __DIR__ . '/../tools/render.php';

$twig = authfly_twig();
$fail = 0; $pass = 0;
$check = function (string $name, bool $ok, string $msg = '') use (&$fail, &$pass) {
    if ($ok) { $pass++; return; }
    $fail++; fwrite(STDERR, "FAIL $name $msg\n");
};
$file = fn (string $w) => 'blocks/authfly-' . strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', substr($w, 7))) . '.html.twig';

foreach (json_decode(file_get_contents(__DIR__ . '/../../react/tests/states.json'), true) as $s) {
    $h = $twig->render($file($s['widget']), ['p' => $s['props']]);
    preg_match_all('/ id="([^"]+)"/', $h, $m);
    $ids = array_count_values($m[1]);
    $ok = max($ids ?: [1]) === 1;
    foreach (['aria-describedby', 'aria-labelledby', 'for'] as $a) {
        preg_match_all('/ ' . $a . '="([^"]+)"/', $h, $r);
        foreach ($r[1] as $refs) foreach (explode(' ', $refs) as $ref) $ok = $ok && isset($ids[$ref]);
    }
    $ok = $ok && str_contains($h, 'aria-label');
    $hasErr = str_contains($h, 'data-testid="authfly-error"');
    preg_match_all('/<input[^>]*data-testid="field"[^>]*>/', $h, $ins);
    foreach ($ins[0] as $in) {
        $ok = $ok && ($hasErr ? (str_contains($in, 'aria-invalid="true"') && str_contains($in, '-error')) : !str_contains($in, 'aria-invalid'));
    }
    $check($s['name'], $ok, 'invariants');
}
$h = $twig->render($file('AuthflySignIn'), ['p' => ['id' => 'x', 'title' => '<b>t</b>', 'error' => '<img src=x onerror=alert(1)>', 'labels' => ['submit' => 'Go', 'forgot' => '<i>']]]);
$check('escape', !str_contains($h, '<img') && !str_contains($h, '<b>') && !str_contains($h, '<i>'));
echo "$pass passed, $fail failed\n";
exit($fail ? 1 : 0);
