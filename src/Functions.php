<?php

namespace eURL\Functions;

function e(string $url, array $allowedSchemes = ['http', 'https']): string
{

  $parsedUrl = parse_url($url);

  $parsedUrl['path'] = (isset($parsedUrl['path'])) ? encode($parsedUrl['path']) : "";
  $parsedUrl['host'] = (isset($parsedUrl['host'])) ? encode($parsedUrl['host']) : "";
  $parsedUrl['fragment'] = (isset($parsedUrl['fragment'])) ? encode($parsedUrl['fragment']) : "";
  $parsedUrl['scheme'] = (isset($parsedUrl['scheme'])) ? encode($parsedUrl['scheme']) : "";
  if ($parsedUrl['scheme'] && !in_array($parsedUrl['scheme'], $allowedSchemes)) {
    return '';
  }

  $params = [];
  $queryHasTrailingEqual = false;

  if (isset($parsedUrl['query'])) {
    $queryHasTrailingEqual = substr($parsedUrl['query'], -1) === "=";
    parse_str($parsedUrl['query'], $params);
  }
  $query = "";

  if ($params) {
    $query = [];
    foreach ($params as $key => $value) {
      $query[] = encode($key) . "=" . encode($value);
    }
    $query = implode("&", $query);
    if (!$queryHasTrailingEqual) {
      $query = rtrim($query, "=");
    }
  }

  if ($query) {
    $parsedUrl['query'] = $query;
  }

  $url = build($parsedUrl);
  if (!filter_var($url, FILTER_VALIDATE_URL)) {
    return '';
  }
  return $url;
}

function build(array $parsedUrl): string
{
  $scheme = ($parsedUrl['scheme'] ?? '') ? $parsedUrl['scheme'] . '://' : 'http://';
  $host = $parsedUrl['host'] ?? '';
  $query = (!empty($parsedUrl['query'])) ? "?" . $parsedUrl['query'] : "";
  $fragment = (!empty($parsedUrl['fragment'])) ? "#" . $parsedUrl['fragment'] : "";
  return $scheme . $host . $parsedUrl['path'] . $query . $fragment;
}

function encode(string $str): string
{

  $replacements = array('!', '*', "(", ")", ";", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
  $entities = array_map("urlencode", $replacements);
  return str_replace($entities, $replacements, urlencode($str));
}