<?php
/*
** Zabbix
** Copyright (C) 2001-2016 Zabbix SIA
**
** This program is free software; you can redistribute it and/or modify
** it under the terms of the GNU General Public License as published by
** the Free Software Foundation; either version 2 of the License, or
** (at your option) any later version.
**
** This program is distributed in the hope that it will be useful,
** but WITHOUT ANY WARRANTY; without even the implied warranty of
** MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
** GNU General Public License for more details.
**
** You should have received a copy of the GNU General Public License
** along with this program; if not, write to the Free Software
** Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/


define('ZBX_PAGE_NO_HEADER', 1);
define('ZBX_PAGE_NO_FOOTER', 1);

$request = CHtml::encode(getRequest('request', ''));
$message = CHtml::encode(getRequest('message', '')) ;
// remove debug code for login form message, trimming not in regex to relay only on [ ] in debug message.
$message = trim(preg_replace('/\[.*\]/', '', $message));

require_once dirname(__FILE__).'/../page_header.php';

$error = ($message !== '') ? (new CDiv($message))->addClass(ZBX_STYLE_RED) : null;
$guest = (CWebUser::$data['userid'] > 0)
	? (new CListItem(['或者 ', new CLink('游客模式登陆', ZBX_DEFAULT_URL)]))
		->addClass(ZBX_STYLE_SIGN_IN_TXT)
	: null;

global $ZBX_SERVER_NAME;

(new CDiv([

	(new CDiv([
		(new CDiv())->addClass(ZBX_STYLE_SIGNIN_LOGO),
		(new CForm())
			->addItem(
				(new CList())
					->addItem([
						new CLabel(_('&nbsp;用户名：'), 'name'),
						(new CTextBox('name'))->setAttribute('autofocus', 'autofocus'),
						$error
					])
					->addItem([new CLabel(_('&nbsp;密码：'), 'password'), (new CTextBox('password'))->setType('password')])
					->addItem(
						new CLabel([
							(new CCheckBox('autologin'))->setChecked(getRequest('autologin', 1) == 1),
							_('记住密码自动登陆30天')
						], 'autologin')
					)
					->addItem(new CSubmit('enter', _('Sign in')))
					->addItem($guest)
			)
	]))->addClass(ZBX_STYLE_SIGNIN_CONTAINER),
	(new CDiv([
		(new CLink(_('帮助中心'), 'http://www.zabbix.com/documentation/3.0/'))
			->setTarget('_blank')
			->addClass(ZBX_STYLE_GREY)
			->addClass(ZBX_STYLE_LINK_ALT),
		'&nbsp;&nbsp;•&nbsp;&nbsp;',
		(new CLink(_('技术支持'), 'http://www.zghaoyu.cn'))
			->setTarget('_blank')
			->addClass(ZBX_STYLE_GREY)
			->addClass(ZBX_STYLE_LINK_ALT)
	]))->addClass(ZBX_STYLE_SIGNIN_LINKS)
]))
	->addClass(ZBX_STYLE_ARTICLE)
	->show();

makePageFooter(false)->show();
?>
</body>
