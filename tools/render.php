<?php
// Renders the shared parity states (argv[1] = states.json) to argv[2]/<name>.html.
declare(strict_types=1);
require __DIR__ . '/../vendor/autoload.php';

function authfly_twig(): Twig\Environment
{
    $twig = new Twig\Environment(new Twig\Loader\FilesystemLoader(dirname(__DIR__)), ['autoescape' => 'html', 'strict_variables' => false]);
    $twig->addExtension(new UI8Kit\Twig\TwigExtension());
    $twig->addExtension(new Authfly\Twig\AuthflyExtension());
    return $twig;
}

if (realpath($argv[0] ?? '') === __FILE__) {
    $twig = authfly_twig();
    $states = json_decode(file_get_contents($argv[1]), true, 512, JSON_THROW_ON_ERROR);
    @mkdir($argv[2], 0o755, true);
    foreach ($states as $s) {
        $file = 'blocks/authfly-' . strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', substr($s['widget'], 7))) . '.html.twig';
        file_put_contents($argv[2] . '/' . $s['name'] . '.html', $twig->render($file, ['p' => $s['props']]));
    }
}
