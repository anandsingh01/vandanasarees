<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class HtmlMinifier
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $contentType = $response->headers->get('Content-Type');

        if (strpos($contentType, 'text/html') !== false) {
            $response->setContent($this->minifyHtml($response->getContent()));
        } elseif (strpos($contentType, 'text/css') !== false) {
            $response->setContent($this->minifyCss($response->getContent()));
        } elseif (strpos($contentType, 'application/javascript') !== false) {
            $response->setContent($this->minifyJs($response->getContent()));
        }

        return $response;
    }

    protected function minifyHtml($input)
    {
        $search = [
            '/\>\s+/s',
            '/\s+</s',
        ];

        $replace = [
            '> ',
            ' <',
        ];

        return preg_replace($search, $replace, $input);
    }

    protected function minifyCss($input)
    {
        // Minify CSS logic goes here
        // For example, you can remove comments and whitespace
        $minifiedCss = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $input);
        $minifiedCss = str_replace(': ', ':', $minifiedCss);
        $minifiedCss = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $minifiedCss);
        return $minifiedCss;
    }

    protected function minifyJs($input)
    {
        // Minify JS logic goes here
        // For example, you can remove comments and whitespace
        $minifiedJs = preg_replace('/\s*([{}:;,])\s+/', '$1', $input);
        $minifiedJs = preg_replace('/\s+/', ' ', $minifiedJs);
        return $minifiedJs;
    }
}
