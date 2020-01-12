<?php

/**
 * Check if URL exists or not.
 *
 * @param string $url
 * @return bool
 */
function urlExists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ($httpCode >= 200 && $httpCode < 300);
}

/**
 * Get protocol by URL.
 *
 * @param string $url
 * @return string array
 */
function getProtocol($url)
{
    return explode('//', $url)[0] . '//';
}

/**
 * Get site name from URL.
 *
 * @param string $url
 * @return string
 */
function getSiteName($url)
{
    $siteName = str_replace(getProtocol($url), '', $url);
    $siteName = str_replace('www.', '', $siteName);
    $siteName = explode('.', $siteName)[0];

    return $siteName;
}

/**
 * Get domen name from URL.
 *
 * @param string $url
 * @return string
 */
function getDomenName($url)
{
    $protocol = getProtocol($url);
    $domenName = str_replace($protocol, '', $url);
    $domenName = explode('/', $domenName)[0];
    $domenName = $protocol . $domenName;

    return $domenName;
}

/**
 * Get URL part by its position from the end.
 *
 * @param string $url
 * @param int $backPartNum
 * @return string
 */
function getUrlBackPart($url, $backPartNum = 1)
{
    if ($url{strlen($url) - 1} === '/') {
        $url = substr($url, 0, -1);
    }
    $url = explode('/', $url);
    $part = $url[count($url) - $backPartNum];

    return $part;
}
