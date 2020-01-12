<?php

/**
 * Get page dom by its URL.
 * The dom is built by Zend lib.
 *
 * @param string $pageUrl
 * @return Zend_Dom_Query
 */
function getPageDom($pageUrl)
{
    $pageHtml = file_get_contents($pageUrl);
    $pageDom = new Zend_Dom_Query($pageHtml);

    return $pageDom;
}

/**
 * Validate if current page exists & can be rendered or not.
 *
 * @param string $pageUrl
 * @param string $listDivXpath
 * @param array $skipDivXpaths
 * @return bool
 */
function isPageValidForRendering($pageUrl, $listDivXpath, array $skipDivXpaths)
{
    if (!urlExists($pageUrl)) {
        return false;
    }
    if (getExt(getUrlBackPart($pageUrl, 1)) === 'gif') {
        return true;
    }

    $pageDom = getPageDom($pageUrl);
    
    $content = $pageDom->queryXpath($listDivXpath);
    $contentIsInvalid = !$content->valid() || $content->count() === 0;
    if ($contentIsInvalid) {
        return false;
    }

    foreach ($skipDivXpaths as $xpath) {
        $skipDiv = $pageDom->queryXpath($xpath);
        if ($skipDiv->valid() && $contentIsInvalid) {
            return false;
        }
    }

    return true;
}

/**
 * Get text content by dom element xpath.
 *
 * @param Zend_Dom_Query $pageDom
 * @param string $divXpath
 * @return string
 */
function getTextByXpath($pageDom, $divXpath)
{
    $div = $pageDom->queryXpath($divXpath);
    return $div->current()->textContent;
}

/**
 * Get attribute by its name & correspondent dom element xpath.
 *
 * @param Zend_Dom_Query $pageDom
 * @param string $divXpath
 * @param string $attribute
 * @return string|null
 */
function getAttributeByXpath($pageDom, $divXpath, $attribute)
{
    $div = $pageDom->queryXpath($divXpath);
    return $div->current()->getAttribute($attribute);
}
