# Authfly widgets — Twig (UI8Kit 3)

> **Read-only mirror:** [authfly/twig](https://github.com/authfly/twig) is a read-only mirror of `packages/ui/twig`; develop in [authfly/authkit](https://github.com/authfly/authkit) (`tools/split.sh`).

Composer package `authfly/twig`. Primitives from `npx ui8kit@3` (CLI 3.2.1, registry 3.2.0):

    npx ui8kit@3 init --yes --framework twig --runtime twig --dir . --registry-version 3.2.0
    npx ui8kit@3 add --all --runtime twig --registry-version 3.2.0
    composer require "twig/twig:^3.0" && composer dump-autoload

`ui/` (templates) and `runtime/` (`UI8Kit\Twig\*`) are CLI-owned — never edit; `npx ui8kit@3 check`.
Authfly layer: `src/Skin.php` + `src/AuthflyExtension.php` (`af_*` functions), `authfly/components.html.twig`
(macros: card, stack, group, form, hidden, title, alert, badge, icon_badge, field, icon, head, messages),
`blocks/authfly-*.html.twig` (same `p` props as the React widgets).

    $twig->addExtension(new UI8Kit\Twig\TwigExtension());
    $twig->addExtension(new Authfly\Twig\AuthflyExtension());
    echo $twig->render('blocks/authfly-sign-in.html.twig', ['p' => $props]);

Text is passed via props and escaped; children HTML is only built by the macros. Tests: `php tests/widgets_test.php`;
parity HTML: `php tools/render.php ../react/tests/states.json /tmp/out`.
