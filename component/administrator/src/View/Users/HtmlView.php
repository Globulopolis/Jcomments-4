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

namespace Joomla\Component\Jcomments\Administrator\View\Users;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\Component\Jcomments\Administrator\Helper\JcommentsHelper;

class HtmlView extends BaseHtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	public $filterForm;
	public $activeFilters;

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 *
	 * @throws  \Exception
	 * @since   4.0
	 */
	public function display($tpl = null)
	{
		$this->items           = $this->get('Items');
		$this->pagination      = $this->get('Pagination');
		$this->filterForm      = $this->get('FilterForm');
		$this->activeFilters   = $this->get('ActiveFilters');
		$this->state           = $this->get('State');

		$this->addToolbar();

		parent::display($tpl);

	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   4.0
	 *
	 * @throws  \Exception
	 */
	protected function addToolbar()
	{
		$toolbar = Toolbar::getInstance();
		$canDo   = JcommentsHelper::getActions('com_jcomments', 'component');
		$user    = Factory::getApplication()->getIdentity();

		ToolbarHelper::title(Text::_('COM_JCOMMENTS_USERS'));

		if ($canDo->get('core.create'))
		{
			ToolbarHelper::addNew('user.add');
		}

		if ($canDo->get('core.edit'))
		{
			ToolbarHelper::editList('user.edit');
		}

		if ($canDo->get('core.delete'))
		{
			$toolbar->delete('users.delete')
				->text('JACTION_DELETE')
				->message('JGLOBAL_CONFIRM_DELETE')
				->listCheck(true);
		}

		if ($user->authorise('core.admin', 'com_jcomments') || $user->authorise('core.options', 'com_jcomments'))
		{
			$toolbar->preferences('com_jcomments');
		}
	}
}