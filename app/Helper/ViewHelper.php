<?php

namespace App\Helper;

use Illuminate\Support\Facades\Session;

class ViewHelper
{
	private static function buildPaginationQueryString($parameters, $includeEmptyValues=false)
	{
		$queryParameters=[];

		foreach($parameters as $key => $value)
		{
			if($includeEmptyValues || ($value!==null && $value!==''))
			{
				$queryParameters[$key]=$value;
			}
		}

		return empty($queryParameters) ? '' : '?'.http_build_query($queryParameters);
	}

	public static function renderPaginationFrontExams($urlPage, $quantityPage, $currentPage, $filtersData)
	{
		$type=$filtersData->type ?? 'all';
		$grade=$filtersData->grade ?? 'all';
		$subject=$filtersData->subject ?? 'all';
		$year=$filtersData->year ?? 'all';

		$queryString=self::buildPaginationQueryString([
			'searchParameter' => $filtersData->searchParameter ?? '',
			'type' => ($type != '' && $type != null) ? $type : 'all',
			'grade' => ($grade != '' && $grade != null) ? $grade : 'all',
			'subject' => ($subject != '' && $subject != null) ? $subject : 'all',
			'year' => ($year != '' && $year != null) ? $year : 'all'
		], true);

		$paginationSection = ''
			. '<div class="divPagination">'
			. '<span><a class="divPaginationJump" onclick="_globalFunction.clickLink(\'' . url($urlPage . '/' . (($currentPage - 1) <= 0 ? 1 : ($currentPage - 1))) . $queryString . '\');"></a></span>'
			. '<a onclick="_globalFunction.clickLink(\'' . url($urlPage . '/1') . $queryString . '\');" class="divPaginationPageNumber" ' . (1 == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '') . '>1</a>';
		if ($currentPage - 2 > 1) {
			$paginationSection .= '..';
		}

		for ($i = ($currentPage - 2 <= 1 ? 2 : $currentPage - 2); $i <= ($quantityPage < ($currentPage + 2) ? $quantityPage : $currentPage + 2); $i++) {
			$paginationSection .= '<a onclick="_globalFunction.clickLink(\'' . url($urlPage . '/' . $i) . $queryString . '\');" class="divPaginationPageNumber" ' . ($i == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '') . '>' . $i . '</a>';
		}
		if ($quantityPage > ($currentPage + 2)) {
			$paginationSection .= '..'
				. '<a onclick="_globalFunction.clickLink(\'' . url($urlPage . '/' . $quantityPage) . $queryString . '\');" class="divPaginationPageNumber" ' . ($quantityPage == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : '') . '>' . $quantityPage . '</a>';
		}

		$paginationSection .= '<span><a class="divPaginationJump" onclick="_globalFunction.clickLink(\'' . url($urlPage . '/' . (($currentPage + 1) > $quantityPage ? $quantityPage : ($currentPage + 1))) . $queryString . '\');"></a></span>'
			. '</div>';

		return $paginationSection;
	}

	public static function renderPagination($urlPage, $quantityPage, $currentPage, $searchParameter, $ajaxMode=false)
	{
		$queryString=self::buildPaginationQueryString(['searchParameter' => $searchParameter]);
		$renderLink=function($page, $class, $content='', $extraAttribute='') use ($urlPage, $queryString, $ajaxMode)
		{
			$url=url($urlPage.'/'.$page).$queryString;

			if($ajaxMode)
			{
				return '<a href="'.$url.'" class="'.$class.'" '.$extraAttribute.'>'.$content.'</a>';
			}

			return '<a onclick="_globalFunction.clickLink(\''.$url.'\');" class="'.$class.'" '.$extraAttribute.'>'.$content.'</a>';
		};

		$paginationSection = ''
			. '<div class="divPagination">'
			. '<span>'.$renderLink((($currentPage - 1) <= 0 ? 1 : ($currentPage - 1)), 'divPaginationJump').'</span>'
			. $renderLink(1, 'divPaginationPageNumber', '1', (1 == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : ''));
		if ($currentPage - 2 > 1) {
			$paginationSection .= '..';
		}

		for ($i = ($currentPage - 2 <= 1 ? 2 : $currentPage - 2); $i <= ($quantityPage < ($currentPage + 2) ? $quantityPage : $currentPage + 2); $i++) {
			$paginationSection .= $renderLink($i, 'divPaginationPageNumber', $i, ($i == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : ''));
		}
		if ($quantityPage > ($currentPage + 2)) {
			$paginationSection .= '..'
				. $renderLink($quantityPage, 'divPaginationPageNumber', $quantityPage, ($quantityPage == $currentPage ? 'style="background-color: #6195ce;color: #ffffff;"' : ''));
		}

		$paginationSection .= '<span>'.$renderLink((($currentPage + 1) > $quantityPage ? $quantityPage : ($currentPage + 1)), 'divPaginationJump').'</span>'
			. '</div>';

		return $paginationSection;
	}

	public static function hasMainRole($role)
	{
		return Session::has('mainRole') ? in_array($role, explode(',', Session::get('mainRole'))) : false;
	}

	public static function hasSecondaryRole($role, $columnSession, $columnValue)
	{
		if (Session::has('arrayCompanyRole')) {
			foreach (Session::get('arrayCompanyRole') as $value) {
				if (($columnSession == null && $columnValue == null && in_array($role, explode(',', $value->role))) || ($value->$columnSession == $columnValue && in_array($role, explode(',', $value->role)))) {
					return true;
				}
			}
		}

		return false;
	}

	public static function addToDate($dateHour, $type, $quantity)
	{
		/*+7 year, +7 month, +7 day, +7 hour, +7 minute, +7 second*/
		$newDateHour = strtotime('+' . $quantity . ' ' . $type, strtotime($dateHour));
		$newDateHour = date('Y-m-d H:i:s', $newDateHour);

		return $newDateHour;
	}

	public static function dateToCache($date)
	{
		return str_replace(':', '-', str_replace(' ', '_', $date));
	}

	public static function getDateFormat($date, $formatOut = 'd-m-Y')
	{
		return date($formatOut, strtotime($date));
	}

	public static function findValueOnObjectsArray($array, $column, $valueFind)
	{
		foreach ($array as $value) {
			if ($value->{$column} == $valueFind) {
				return true;
			}
		}

		return false;
	}
}
