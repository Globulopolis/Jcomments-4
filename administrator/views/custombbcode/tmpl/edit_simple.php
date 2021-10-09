<?php
/**
 * JComments - Joomla Comment System
 *
 * @version       4.0
 * @package       JComments
 * @author        Sergey M. Litvinov (smart@joomlatune.ru) & exstreme (info@protectyoursite.ru) & Vladimir Globulopolis
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license       GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
?>
<div class="col-lg-12">
	<div class="control-group">
		<div class="control-label">
			<?php echo $this->form->getLabel('simple_pattern'); ?>
		</div>
		<div class="controls">
			<?php echo $this->form->getInput('simple_pattern'); ?>
		</div>
		<div class="controls">
			<?php echo HTMLHelper::_('custombbcodes.sample', '[highlight={SIMPLETEXT1}]{SIMPLETEXT2}[/highlight]'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo $this->form->getLabel('simple_replacement_html'); ?>
		</div>
		<div class="controls">
			<?php echo $this->form->getInput('simple_replacement_html'); ?>
		</div>
		<div class="controls">
			<?php echo HTMLHelper::_('custombbcodes.sample', '&lt;span style="color: {SIMPLETEXT1};"&gt;{SIMPLETEXT2}&lt;/span&gt;'); ?>
		</div>
	</div>
	<div class="control-group">
		<div class="control-label">
			<?php echo $this->form->getLabel('simple_replacement_text'); ?>
		</div>
		<div class="controls">
			<?php echo $this->form->getInput('simple_replacement_text'); ?>
		</div>
		<div class="controls">
			<?php echo HTMLHelper::_('custombbcodes.sample', '{SIMPLETEXT2}'); ?>
		</div>
	</div>
</div>
