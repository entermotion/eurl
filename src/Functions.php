<?php

namespace eURL\Functions;

function e(string $url, string $defaultScheme = 'http://', array $allowedSchemes = ['http', 'https']): string
{
<<<<<<< Updated upstream
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
=======
<<<<<<< Updated upstream

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
=======
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
>>>>>>> Stashed changes
}

function parseQuery(array $params, bool $queryHasTrailingEqual): string
{
<<<<<<< Updated upstream
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
=======
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
>>>>>>> Stashed changes
>>>>>>> Stashed changes
}

function build(array $url, $defaultScheme = 'http://'): string
{
<<<<<<< Updated upstream
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
=======
<<<<<<< Updated upstream
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
=======
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
>>>>>>> Stashed changes
>>>>>>> Stashed changes
}

function encode(string $str): string
{
<<<<<<< Updated upstream
	$replacements = array('!', '*', '(', ')', ';', '@', '&', '=', '+', '$', ',', '/', '?', '%', '#', '[', ']');
	$entities = array_map('urlencode', $replacements);

	return str_ireplace($entities, $replacements, urlencode($str));
=======
<<<<<<< Updated upstream
  $replacements = array('!', '*', "(", ")", ";", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
  $entities = array_map("urlencode", $replacements);
  return str_replace($entities, $replacements, urlencode($str));
=======
    $replacements = array('!', '*', '(', ')', ';', '@', '&', '=', '+', '$', ',', '/', '?', '%', '#', '[', ']');
    $entities = array_map('urlencode', $replacements);

    return str_ireplace($entities, $replacements, urlencode($str));
>>>>>>> Stashed changes
>>>>>>> Stashed changes
}
