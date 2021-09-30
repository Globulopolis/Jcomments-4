<?php
/**
 * JComments plugin for SermonSpeaker support (http://www.sermonspeaker.net/)
 *
 * @version 2.3
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & exstreme (info@protectyoursite.ru) & Vladimir Globulopolis
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

use Joomla\CMS\Factory;

defined('_JEXEC') or die;

class jc_com_sermonspeaker extends JCommentsPlugin
{
	function getObjectInfo($id, $language = null)
	{
		$info = new JCommentsObjectInfo();

		$db = Factory::getContainer()->get('DatabaseDriver');
		$query = 'SELECT id, sermon_title, created_by '
			. ' FROM #__sermon_sermons'
			. ' WHERE id = '.$id
			;
		$db->setQuery($query);
		$row = $db->loadObject();
			
		if (!empty($row)) {
			$Itemid = self::getItemid('com_sermonspeaker');
			$Itemid = $Itemid > 0 ? '&Itemid='.$Itemid : '';

			$info->title = $row->sermon_title;
			$info->access = 0;
			$info->userid = $row->created_by;
			$info->link = JRoute::_('index.php?option=com_sermonspeaker&view=sermon&id=' . $row->id . $Itemid);
		}

		return $info;
	}
}