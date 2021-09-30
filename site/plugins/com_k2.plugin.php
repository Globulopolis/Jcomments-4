<?php
/**
 * JComments plugin for k2 (k2.joomlaworks.gr) objects support
 *
 * @version 2.3
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & exstreme (info@protectyoursite.ru) & Vladimir Globulopolis
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

class jc_com_k2 extends JCommentsPlugin
{
	function getObjectInfo($id, $language = null)
	{
		$info = new JCommentsObjectInfo();

		$routerHelper = JPATH_SITE.'/components/com_k2/helpers/route.php';
		if (is_file($routerHelper)) {
			if (!class_exists('K2HelperRoute')) {
				require_once($routerHelper);
			}

			$db = Factory::getContainer()->get('DatabaseDriver');
			$query = "SELECT i.id, i.title, i.catid, i.alias, i.access, i.created_by, c.alias as catalias"
				. " FROM #__k2_items as i"
				. " LEFT JOIN #__k2_categories as c ON c.id=i.catid"
				. " WHERE i.id = " . $id;
			$db->setQuery($query);
			$row = $db->loadObject();
			
			if (!empty($row)) {
				$info->category_id = $row->catid;
				$info->title = $row->title;
				$info->access = $row->access;
				$info->userid = $row->created_by;
				$info->link = JRoute::_(K2HelperRoute::getItemRoute($row->id.':'.urlencode($row->alias), $row->catid.':'.urlencode($row->catalias)));
			}
		}

		return $info;
	}
}