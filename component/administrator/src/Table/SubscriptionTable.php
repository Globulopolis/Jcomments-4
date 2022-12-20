<?php
/**
 * JComments - Joomla Comment System
 *
 * @package           JComments
 * @author            JComments team
 * @copyright     (C) 2006-2016 Sergey M. Litvinov (http://www.joomlatune.ru)
 *                (C) 2016-2022 exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license           GNU General Public License version 2 or later; GNU/GPL: https://www.gnu.org/copyleft/gpl.html
 *
 **/

namespace Joomla\Component\Jcomments\Administrator\Table;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Table\Table;
use Joomla\Database\DatabaseDriver;
use Joomla\Database\ParameterType;

/**
 * JComments subscriptions table
 *
 * @since  1.5
 */
class SubscriptionTable extends Table
{
	/**
	 * Indicates that columns fully support the NULL value in the database
	 *
	 * @var    boolean
	 * @since  4.0.0
	 */
	protected $_supportNullValue = true;

	/**
	 * Constructor
	 *
	 * @param   DatabaseDriver  $db  A database connector object
	 *
	 * @since   1.5
	 */
	public function __construct($db)
	{
		parent::__construct('#__jcomments_subscriptions', 'id', $db);
	}

	/**
	 * Overrides Table::store to set modified data.
	 *
	 * @param   boolean  $updateNulls  True to update fields even if they are null.
	 *
	 * @return  boolean  True on success.
	 *
	 * @since   1.6
	 */
	public function store($updateNulls = true)
	{
		$app = Factory::getApplication();
		$db  = $this->getDbo();

		if ($this->userid != 0 && empty($this->email))
		{
			/** @var \Joomla\CMS\User\UserFactory $userFactory */
			$userFactory = Factory::getContainer()->get('user.factory');
			$user        = $userFactory->loadUserById($this->userid);
			$this->email = $user->email;
		}

		if ($this->userid == 0 && !empty($this->email))
		{
			$query = $db->getQuery(true)
				->select('*')
				->from($db->quoteName('#__users'))
				->where($db->quoteName('email') . ' = :email')
				->bind(':email', $this->email);

			$db->setQuery($query);
			$users = $db->loadObjectList();

			if (count($users))
			{
				$this->userid = $users[0]->id;
				$this->name   = $users[0]->name;
			}
		}

		// Adjust lang field for batch operation.
		if ($app->input->post->get('task', '') == 'subscription.batch')
		{
			$this->lang = $this->language;
		}

		if (empty($this->lang))
		{
			$this->lang = $app->getLanguage()->getTag();
		}
		// Update 'lang' in #__jcomments_objects, #__jcomments tables. If you do not change the value, this will lead
		// to a loss of connection in the tables.
		else
		{
			$query = $db->getQuery(true)
				->update($db->quoteName('#__jcomments'))
				->set($db->quoteName('lang') . ' = ' . $db->quote($this->lang))
				->where($db->quoteName('object_id') . ' = :oid')
				->where($db->quoteName('object_group') . ' = :ogroup')
				->bind(':oid', $this->object_id, ParameterType::INTEGER)
				->bind(':ogroup', $this->object_group);

			$db->setQuery($query);
			$db->execute();

			$query = $db->getQuery(true)
				->update($db->quoteName('#__jcomments_objects'))
				->set($db->quoteName('lang') . ' = ' . $db->quote($this->lang))
				->where($db->quoteName('object_id') . ' = :oid')
				->where($db->quoteName('object_group') . ' = :ogroup')
				->bind(':oid', $this->object_id, ParameterType::INTEGER)
				->bind(':ogroup', $this->object_group);

			$db->setQuery($query);
			$db->execute();
		}

		$this->hash = $this->getHash();

		return parent::store($updateNulls);
	}

	public function getHash()
	{
		return md5($this->object_id . $this->object_group . $this->userid . $this->email . $this->lang);
	}
}