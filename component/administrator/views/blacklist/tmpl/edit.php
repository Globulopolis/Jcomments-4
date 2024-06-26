<?php
/**
 * JComments - Joomla Comment System
 *
 * @version       3.0
 * @package       JComments
 * @author        Sergey M. Litvinov (smart@joomlatune.ru)
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license       GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->document->getWebAssetManager();
$wa->useScript('keepalive')
	->useScript('form.validate');
?>
<form action="<?php echo Route::_('index.php?option=com_jcomments&view=blacklist&layout=edit&id=' . (int) $this->item->id); ?>"
	  method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="main-card">
		<div class="row">
			<div class="col-12">
				<fieldset id="fieldset-edit" class="options-form">
					<legend><?php echo Text::_('A_BLACKLIST_EDIT'); ?></legend>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('ip'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('ip'); ?>
						</div>
					</div>

					<?php echo $this->form->renderField('reason'); ?>

					<?php echo $this->form->renderField('notes'); ?>

					<?php echo $this->form->renderField('created'); ?>

					<div class="control-group">
						<div class="control-label">
							<?php echo $this->form->getLabel('id'); ?>
						</div>
						<div class="controls">
							<?php echo $this->form->getInput('id'); ?>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
		<input type="hidden" name="task" value=""/>
		<?php echo HTMLHelper::_('form.token'); ?>
	</div>
</form>
