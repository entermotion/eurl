<?php

namespace eURL\Functions;

function e(string $url, string $defaultScheme = "http://", array $allowedSchemes = ['http', 'https']): string
{

  $parsedUrl = parse_url(trim($url));
  if ($parsedUrl === false) {
    return "";
  }

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

  $url = build($parsedUrl, $defaultScheme);
  return $url;
}

function build(array $parsedUrl, $defaultScheme = "http://"): string
{
  $host = $parsedUrl['host'] ?? '';
  $scheme = (!empty($parsedUrl['scheme'])) ? $parsedUrl['scheme'] . '://' : "";
  $path = $parsedUrl['path'];
  if(!$scheme && !$host && $defaultScheme) {
    //check if the first part of the path looks like a domain, if so we set the missing scheme to the default one.
    $possibleDomain = explode("/",$path)[0];
    if(preg_match('/^(([-A-z0-9]+)\.)?(([-A-z0-9]+)\.)?([-A-z0-9]+)\.([-A-z]{2,4})$/',$possibleDomain)){
      $scheme = $defaultScheme;
    }
  }
  $query = (!empty($parsedUrl['query'])) ? "?" . $parsedUrl['query'] : "";
  $fragment = (!empty($parsedUrl['fragment'])) ? "#" . $parsedUrl['fragment'] : "";
  return $scheme . $host . $path . $query . $fragment;
}

function encode(string $str): string
{
  $replacements = array('!', '*', "(", ")", ";", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
  $entities = array_map("urlencode", $replacements);
  return str_replace($entities, $replacements, urlencode($str));
}
