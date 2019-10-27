<?php

namespace eURL\Functions;

function e(string $url, string $defaultScheme = 'http://', array $allowedSchemes = ['http', 'https']): string
{
    $parsedUrl = parse_url(trim($url));

    if ($parsedUrl === false) return '';

    $parsedUrlSkeleton = array(
        'scheme'   => '',
        'host'     => '',
        'path'     => '',
        'query'    => '',
        'fragment' => '',
    );

    $parsedUrl = array_merge($parsedUrlSkeleton, $parsedUrl);

    $parsedUrl['scheme']   = encode($parsedUrl['scheme']);
    $parsedUrl['host']     = encode($parsedUrl['host']);
    $parsedUrl['path']     = encode($parsedUrl['path']);
    $parsedUrl['fragment'] = encode($parsedUrl['fragment']);

    if ($parsedUrl['scheme'] !== '' && !in_array($parsedUrl['scheme'], $allowedSchemes)) return '';

    $params = array();
    $queryHasTrailingEqual = false;

    if ($parsedUrl['query'] !== '') {

        $queryHasTrailingEqual = substr($parsedUrl['query'], -1) === '=';
        
        parse_str($parsedUrl['query'], $params);

    }
    
    $parsedUrl['query'] = parseQuery($params, $queryHasTrailingEqual);

    return build($parsedUrl, $defaultScheme);
}

function parseQuery(array $params, bool $queryHasTrailingEqual): string
{
    if (count($params) > 0) {

        $query = array();

        foreach ($params as $key => $value) {

            $query[] = encode($key) . '=' . encode($value);

        }

        $query = implode('&', $query);

        if ($queryHasTrailingEqual === false) $query = rtrim($query, '=');

        return $query;

    }

    return '';
}

function build(array $url, $defaultScheme = 'http://'): string
{
    $query    = ($url['query']     !== '') ? '?' . $url['query']    : '';
    $fragment = ($url['fragment']  !== '') ? '#' . $url['fragment'] : '';

    $result = $url['host'] . $url['path'] . $query . $fragment;

    if ($url['scheme'] === '' && $url['host'] === '') {

        //check if the first part of the path looks like a domain, if so we set the missing scheme to the default one.
        $possibleDomain = explode('/', $url['path'], 2)[0];

        if (preg_match('/^(([-A-z0-9]+)\.)?(([-A-z0-9]+)\.)?([-A-z0-9]+)\.([-A-z]{2,4})$/', $possibleDomain)) {
            
            return $defaultScheme . $result;

        }

    }

    if ($url['scheme'] !== '') $url['scheme'] .= '://';

    return $url['scheme'] . $result;
}

function encode(string $str): string
{
    $replacements = array('!', '*', '(', ')', ';', '@', '&', '=', '+', '$', ',', '/', '?', '%', '#', '[', ']');
    $entities = array_map('urlencode', $replacements);

    return str_ireplace($entities, $replacements, urlencode($str));
}