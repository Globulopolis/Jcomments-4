<?php
/**
 * JComments plugin for EasyBlog posts support
 *
 * @version 2.3
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & exstreme (info@protectyoursite.ru) & Vladimir Globulopolis
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

class jc_com_easyblog extends JCommentsPlugin
{
	function getObjectInfo($id, $language = null)
	{
		$info = new JCommentsObjectInfo();

		$routerHelper = JPATH_ROOT.'/components/com_easyblog/helpers/router.php';
		if (is_file($routerHelper)) {
			require_once($routerHelper);

			$db = Factory::getContainer()->get('DatabaseDriver');
			$db->setQuery('SELECT id, title, created_by, category_id FROM #__easyblog_post WHERE id = ' . $id);
			$row = $db->loadObject();

			if (!empty($row)) {
				$info->category_id = $row->category_id;
				$info->title = $row->title;
				$info->userid = $row->created_by;
				$info->link = EasyBlogRouter::_('index.php?option=com_easyblog&view=entry&id=' . $id);
			}
		}

		return $info;
	}
}