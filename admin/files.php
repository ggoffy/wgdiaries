<?php

declare(strict_types=1);

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * WFH Diaries module for xoops
 *
 * @copyright      2020 XOOPS Project (https://xooops.org)
 * @license        GPL 2.0 or later
 * @package        wgwfhdiaries
 * @since          1.0
 * @min_xoops      2.5.9
 * @author         wedega - Email:<webmaster@wedega.com> - Website:<https://xoops.wedega.com>
 */

use Xmf\Request;
use XoopsModules\Wgwfhdiaries;
use XoopsModules\Wgwfhdiaries\Constants;
use XoopsModules\Wgwfhdiaries\Common;

require __DIR__ . '/header.php';
// It recovered the value of argument op in URL$
$op = Request::getCmd('op', 'list');
// Request file_id
$fileId = Request::getInt('file_id');
switch ($op) {
	case 'list':
	default:
		// Define Stylesheet
		$GLOBALS['xoTheme']->addStylesheet($style, null);
		$start = Request::getInt('start', 0);
		$limit = Request::getInt('limit', $helper->getConfig('adminpager'));
		$templateMain = 'wgwfhdiaries_admin_files.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
		$adminObject->addItemButton(_AM_WGWFHDIARIES_ADD_FILE, 'files.php?op=new', 'add');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		$filesCount = $filesHandler->getCountFiles();
		$filesAll = $filesHandler->getAllFiles($start, $limit);
		$GLOBALS['xoopsTpl']->assign('files_count', $filesCount);
		$GLOBALS['xoopsTpl']->assign('wgwfhdiaries_url', WGWFHDIARIES_URL);
		$GLOBALS['xoopsTpl']->assign('wgwfhdiaries_upload_url', WGWFHDIARIES_UPLOAD_URL);
		// Table view files
		if ($filesCount > 0) {
			foreach (\array_keys($filesAll) as $i) {
				$file = $filesAll[$i]->getValuesFiles();
				$GLOBALS['xoopsTpl']->append('files_list', $file);
				unset($file);
			}
			// Display Navigation
			if ($filesCount > $limit) {
				include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
				$pagenav = new \XoopsPageNav($filesCount, $limit, $start, 'start', 'op=list&limit=' . $limit);
				$GLOBALS['xoopsTpl']->assign('pagenav', $pagenav->renderNav(4));
			}
		} else {
			$GLOBALS['xoopsTpl']->assign('error', _AM_WGWFHDIARIES_THEREARENT_FILES);
		}
		break;
	case 'new':
		$templateMain = 'wgwfhdiaries_admin_files.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
		$adminObject->addItemButton(_AM_WGWFHDIARIES_FILES_LIST, 'files.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Form Create
		$filesObj = $filesHandler->create();
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'save':
		// Security Check
		if (!$GLOBALS['xoopsSecurity']->check()) {
			\redirect_header('files.php', 3, \implode(',', $GLOBALS['xoopsSecurity']->getErrors()));
		}
		if ($fileId > 0) {
			$filesObj = $filesHandler->get($fileId);
		} else {
			$filesObj = $filesHandler->create();
		}
		// Set Vars
		$filesObj->setVar('file_itemid', Request::getInt('file_itemid', 0));
		$filesObj->setVar('file_desc', Request::getString('file_desc', ''));
		// Set Var file_name
		include_once XOOPS_ROOT_PATH . '/class/uploader.php';
		$filename       = $_FILES['file_name']['name'];
		$imgNameDef     = Request::getString('file_itemid');
		$uploader = new \XoopsMediaUploader(WGWFHDIARIES_UPLOAD_FILES_PATH . '/files/', 
													$helper->getConfig('mimetypes_file'), 
													$helper->getConfig('maxsize_file'), null, null);
		if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
			$extension = \preg_replace('/^.+\.([^.]+)$/sU', '', $filename);
			$imgName = \str_replace(' ', '', $imgNameDef) . '.' . $extension;
			$uploader->setPrefix($imgName);
			$uploader->fetchMedia($_POST['xoops_upload_file'][0]);
			if (!$uploader->upload()) {
				$errors = $uploader->getErrors();
			} else {
				$filesObj->setVar('file_name', $uploader->getSavedFileName());
			}
		} else {
			if ($filename > '') {
				$uploaderErrors = $uploader->getErrors();
			}
			$filesObj->setVar('file_name', Request::getString('file_name'));
		}
		$fileDatecreatedArr = Request::getArray('file_datecreated');
		$fileDatecreatedObj = \DateTime::createFromFormat(_SHORTDATESTRING, $fileDatecreatedArr['date']);
		$fileDatecreatedObj->setTime(0, 0, 0);
		$fileDatecreated = $fileDatecreatedObj->getTimestamp() + (int)$fileDatecreatedArr['time'];
		$filesObj->setVar('file_datecreated', $fileDatecreated);
		$filesObj->setVar('file_submitter', Request::getInt('file_submitter', 0));
		// Insert Data
		if ($filesHandler->insert($filesObj)) {
			if ('' !== $uploaderErrors) {
				\redirect_header('files.php?op=edit&file_id=' . $fileId, 5, $uploaderErrors);
			} else {
				\redirect_header('files.php?op=list', 2, _AM_WGWFHDIARIES_FORM_OK);
			}
		}
		// Get Form
		$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'edit':
		$templateMain = 'wgwfhdiaries_admin_files.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
		$adminObject->addItemButton(_AM_WGWFHDIARIES_ADD_FILE, 'files.php?op=new', 'add');
		$adminObject->addItemButton(_AM_WGWFHDIARIES_FILES_LIST, 'files.php', 'list');
		$GLOBALS['xoopsTpl']->assign('buttons', $adminObject->displayButton('left'));
		// Get Form
		$filesObj = $filesHandler->get($fileId);
		$form = $filesObj->getFormFiles();
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		break;
	case 'delete':
		$templateMain = 'wgwfhdiaries_admin_files.tpl';
		$GLOBALS['xoopsTpl']->assign('navigation', $adminObject->displayNavigation('files.php'));
		$filesObj = $filesHandler->get($fileId);
		$fileItemid = $filesObj->getVar('file_itemid');
		if (isset($_REQUEST['ok']) && 1 == $_REQUEST['ok']) {
			if (!$GLOBALS['xoopsSecurity']->check()) {
				\redirect_header('files.php', 3, \implode(', ', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			if ($filesHandler->delete($filesObj)) {
				\redirect_header('files.php', 3, _AM_WGWFHDIARIES_FORM_DELETE_OK);
			} else {
				$GLOBALS['xoopsTpl']->assign('error', $filesObj->getHtmlErrors());
			}
		} else {
			$xoopsconfirm = new Common\XoopsConfirm(
				['ok' => 1, 'file_id' => $fileId, 'op' => 'delete'],
				$_SERVER['REQUEST_URI'],
				\sprintf(_AM_WGWFHDIARIES_FORM_SURE_DELETE, $filesObj->getVar('file_itemid')));
			$form = $xoopsconfirm->getFormXoopsConfirm();
			$GLOBALS['xoopsTpl']->assign('form', $form->render());
		}
		break;
}
require __DIR__ . '/footer.php';
