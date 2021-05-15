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

include_once 'common.php';

// ---------------- Admin Main ----------------
\define('_MI_WGWFHDIARIES_NAME', 'WFH Diaries');
\define('_MI_WGWFHDIARIES_DESC', 'Simple module for a diary for work from home');
// ---------------- Admin Menu ----------------
\define('_MI_WGWFHDIARIES_ADMENU1', 'Dashboard');
\define('_MI_WGWFHDIARIES_ADMENU2', 'Items');
\define('_MI_WGWFHDIARIES_ADMENU3', 'Files');
\define('_MI_WGWFHDIARIES_ADMENU4', 'Feedback');
\define('_MI_WGWFHDIARIES_ABOUT', 'About');
// ---------------- Admin Nav ----------------
\define('_MI_WGWFHDIARIES_ADMIN_PAGER', 'Admin pager');
\define('_MI_WGWFHDIARIES_ADMIN_PAGER_DESC', 'Admin per page list');
// User
\define('_MI_WGWFHDIARIES_USER_PAGER', 'User pager');
\define('_MI_WGWFHDIARIES_USER_PAGER_DESC', 'User per page list');
// Submenu
\define('_MI_WGWFHDIARIES_SMNAME1', 'Index page');
\define('_MI_WGWFHDIARIES_SMNAME2', 'Items');
\define('_MI_WGWFHDIARIES_SMNAME3', 'Submit Items');
\define('_MI_WGWFHDIARIES_SMNAME5', 'Submit Files');
// Config
\define('_MI_WGWFHDIARIES_EDITOR_ADMIN', 'Editor admin');
\define('_MI_WGWFHDIARIES_EDITOR_ADMIN_DESC', 'Select the editor which should be used in admin area for text area fields');
\define('_MI_WGWFHDIARIES_EDITOR_USER', 'Editor user');
\define('_MI_WGWFHDIARIES_EDITOR_USER_DESC', 'Select the editor which should be used in user area for text area fields');
\define('_MI_WGWFHDIARIES_EDITOR_MAXCHAR', 'Text max characters');
\define('_MI_WGWFHDIARIES_EDITOR_MAXCHAR_DESC', 'Max characters for showing text of a textarea or editor field in admin area');
\define('_MI_WGWFHDIARIES_KEYWORDS', 'Keywords');
\define('_MI_WGWFHDIARIES_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
\define('_MI_WGWFHDIARIES_SIZE_MB', 'MB');
\define('_MI_WGWFHDIARIES_MAXSIZE_FILE', 'Max size file');
\define('_MI_WGWFHDIARIES_MAXSIZE_FILE_DESC', 'Define the max size for uploading files');
\define('_MI_WGWFHDIARIES_MIMETYPES_FILE', 'Mime types file');
\define('_MI_WGWFHDIARIES_MIMETYPES_FILE_DESC', 'Define the allowed mime types for uploading files');
\define('_MI_WGWFHDIARIES_NUMB_COL', 'Number Columns');
\define('_MI_WGWFHDIARIES_NUMB_COL_DESC', 'Number Columns to View');
\define('_MI_WGWFHDIARIES_DIVIDEBY', 'Divide By');
\define('_MI_WGWFHDIARIES_DIVIDEBY_DESC', 'Divide by columns number');
\define('_MI_WGWFHDIARIES_TABLE_TYPE', 'Table Type');
\define('_MI_WGWFHDIARIES_TABLE_TYPE_DESC', 'Table Type is the bootstrap html table');
\define('_MI_WGWFHDIARIES_PANEL_TYPE', 'Panel Type');
\define('_MI_WGWFHDIARIES_PANEL_TYPE_DESC', 'Panel Type is the bootstrap html div');
\define('_MI_WGWFHDIARIES_IDPAYPAL', 'Paypal ID');
\define('_MI_WGWFHDIARIES_IDPAYPAL_DESC', 'Insert here your PayPal ID for donations');
\define('_MI_WGWFHDIARIES_SHOW_BREADCRUMBS', 'Show breadcrumb navigation');
\define('_MI_WGWFHDIARIES_SHOW_BREADCRUMBS_DESC', 'Show breadcrumb navigation which displays the current page in context within the site structure');
\define('_MI_WGWFHDIARIES_ADVERTISE', 'Advertisement Code');
\define('_MI_WGWFHDIARIES_ADVERTISE_DESC', 'Insert here the advertisement code');
\define('_MI_WGWFHDIARIES_MAINTAINEDBY', 'Maintained By');
\define('_MI_WGWFHDIARIES_MAINTAINEDBY_DESC', 'Allow url of support site or community');
\define('_MI_WGWFHDIARIES_BOOKMARKS', 'Social Bookmarks');
\define('_MI_WGWFHDIARIES_BOOKMARKS_DESC', 'Show Social Bookmarks in the single page');
// ---------------- End ----------------
