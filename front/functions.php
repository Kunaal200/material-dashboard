<?php

function render_view($template, $layout, $params = [])
{
    $view = __DIR__ . '/templates/' . $template;
    $layout = __DIR__ . '/layout/' . $layout . '.php';
    require_once($layout);
}
?>