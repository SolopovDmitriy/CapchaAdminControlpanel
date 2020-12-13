<?php


namespace MyApp;


class View
{
    public static function Render($templateView, $contentView = null, $data = null) {
        require $templateView;
    }
}