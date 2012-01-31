<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5.3
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Backend
 * @license    LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class CommentsModel
 *
 * Provide methods to find and save content elements.
 * @copyright  Leo Feyer 2005-2012
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Model
 */
class CommentsModel extends \Model
{

	/**
	 * Name of the table
	 * @var string
	 */
	protected static $strTable = 'tl_comments';


	/**
	 * Find the published comments of the current source table and parent ID
	 * @param string
	 * @param integer
	 * @param boolean
	 * @param integer
	 * @param integer
	 * @return Model|null
	 */
	public static function findPublishedBySourceAndParent($strSource, $intParent, $lbnDesc=false, $intLimit=0, $intOffset=0)
	{
		$t = static::$strTable;
		$arrColumns = array("$t.source=? AND $t.parent=?");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published=1";
		}

		return static::findBy($arrColumns, array($strSource, $intParent), ($lbnDesc ? "$t.date DESC" : "$t.date"), $intLimit, $intOffset);
	}


	/**
	 * Count the published comments of the current source table and parent ID
	 * @param string
	 * @param integer
	 * @return Model
	 */
	public static function countPublishedBySourceAndParent($strSource, $intParent)
	{
		$t = static::$strTable;
		$arrColumns = array("$t.source=? AND $t.parent=?");

		if (!BE_USER_LOGGED_IN)
		{
			$arrColumns[] = "$t.published=1";
		}

		return static::countBy($arrColumns, array($strSource, $intParent));
	}


	/**
	 * Find unprotected calendars with feeds
	 * @param array
	 * @return Model|null
	 */
	public static function findUnprotectedWithFeeds()
	{
		$t = static::$strTable;
		return static::findBy(array("$t.makeFeed=1 AND $t.protected=''"), null);
	}
}

?>