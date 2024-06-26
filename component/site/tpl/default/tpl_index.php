<?php
/**
 * JComments - Joomla Comment System
 *
 * @version 4.0
 * @package JComments
 * @author Sergey M. Litvinov (smart@joomlatune.ru) & exstreme (info@protectyoursite.ru) & Vladimir Globulopolis
 * @copyright (C) 2006-2022 by Sergey M. Litvinov (http://www.joomlatune.ru) & exstreme (https://protectyoursite.ru) & Vladimir Globulopolis (https://xn--80aeqbhthr9b.com/ru/)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

/**
 * Main template for JComments. Don't change it without serious reasons ;)
 * Then creating new template you can copy this file to new template's dir without changes
 */
class jtt_tpl_index extends JoomlaTuneTemplate
{
	function render() 
	{
		$object_id = $this->getVar('comment-object_id');
		$object_group = $this->getVar('comment-object_group');

		// comments data is prepared in tpl_list and tpl_comments templates 
		$comments = $this->getVar('comments-list', '');

		// form data is prepared in tpl_form template.
		$form = $this->getVar('comments-form');

		if ($comments != '' || $form != '' || $this->getVar('comments-anticache')) {
			// include comments css (only if we are in administor's panel)
			if ($this->getVar('comments-css', 0) == 1) {
				include_once (JPATH_ROOT . '/components/com_jcomments/helpers/system.php');
?>
<link href="<?php echo JCommentsSystem::getCSS(); ?>" rel="stylesheet" type="text/css" />
<?php
				if ($this->getVar('direction') == 'rtl') {
					$rtlCSS = JCommentsSystem::getCSS(true);
					if ($rtlCSS != '') {
?>
<link href="<?php echo $rtlCSS; ?>" rel="stylesheet" type="text/css" />
<?php
					}
				}
			}

			// include JComments JavaScript initialization
?>
<?php $script="
<!--
var jcomments=new JComments($object_id, '$object_group','".$this->getVar('ajaxurl')."');
jcomments.setList('comments-list');
//-->";
//</script>
            Factory::getDocument()->addScriptDeclaration($script); ?>
<?php
			// IMPORTANT: Do not rename this div's id! Some JavaScript functions references to it!
?>
<div id="jc">
<?php
			if ($this->getVar('comments-form-position', 0) == 1) {
				// Display comments form (or link to show form)
				if (isset($form)) {
					echo $form;
				}
			}
?>
<div id="comments"><?php echo $comments; ?></div>
<?php
			if ($this->getVar('comments-form-position', 0) == 0) {
				// Display comments form (or link to show form)
				if (isset($form)) {
					echo $form;
				}
			}
?>
<?php
			// Some magic like dynamic comments list loader (anticache) and auto go to anchor script
			$aca = (int) ($this->getVar('comments-gotocomment') == 1);
			$acp = (int) ($this->getVar('comments-anticache') == 1);
			$acf = (int) (($this->getVar('comments-form-link') == 1) && ($this->getVar('comments-form-locked', 0) == 0));

			if ($aca || $acp || $acf) {
?>
<?php
      $script="
<!--
jcomments.setAntiCache($aca,$acp,$acf);
//-->
";
Factory::getDocument()->addScriptDeclaration($script); ?>
<?php
			}
?>
</div>
<?php
		}
	}
}