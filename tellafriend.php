<?php
/**
*
* @package Icy Phoenix
* @version $Id$
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

define('IN_ICYPHOENIX', true);
define('CT_SECLEVEL', 'MEDIUM');
$ct_ignoregvar = array('');
if (!defined('IP_ROOT_PATH')) define('IP_ROOT_PATH', './');
if (!defined('PHP_EXT')) define('PHP_EXT', substr(strrchr(__FILE__, '.'), 1));
include(IP_ROOT_PATH . 'common.' . PHP_EXT);
include_once(IP_ROOT_PATH . 'includes/functions_post.' . PHP_EXT);

// Start session management
$userdata = session_pagestart($user_ip);
init_userprefs($userdata);
// End session management

$topic_title = request_var('topic_title', '', true);
$topic_id = request_var('topic_id', 0);
$friendname = request_var('friendname', '', true);
$message = request_var('message', '', true);
$PHP_SELF = $_SERVER['SCRIPT_NAME'];

if (!$userdata['session_logged_in'])
{
	redirect(append_sid(CMS_PAGE_LOGIN . '?redirect=' . 'tellafriend.' . PHP_EXT . '&topic_title=' . urlencode($topic_title) . '&topic_id=' . $topic_id, true));
}

if (($config['url_rw'] == true) || ($config['url_rw_guests'] == true))
{
	$topic_link = create_server_url() . make_url_friendly($topic_title) . '-vt' . $topic_id . '.html';
}
else
{
	$topic_link = create_server_url() . CMS_PAGE_VIEWTOPIC . '?' . POST_TOPIC_URL . '=' . $topic_id;
}

$mail_body = str_replace("{TOPIC}", htmlspecialchars_decode($topic_title), $lang['TELL_FRIEND_BODY']);
$mail_body = str_replace("{LINK}", $topic_link, $mail_body);
$mail_body = str_replace("{SITENAME}", $config['sitename'], $mail_body);

$template->assign_vars(array(
	'SUBMIT_ACTION' => append_sid($PHP_SELF, true),
	'L_SUBMIT' => $lang['Send_email'],
	'SITENAME' => $config['sitename'],

	'SENDER_NAME' => $userdata['username'],
	'SENDER_MAIL' => $userdata['user_email'],

	'L_TELL_FRIEND_BODY' => $mail_body,

	'TOPIC_TITLE' => $topic_title,
	'TOPIC_ID' => $topic_id,
	'TOPIC_LINK' => $topic_link,
	)
);

/**************/
if (isset($_POST['submit']))
{
	$error = false;

	$topic_title = request_var('topic_title', '', true);
	$message = request_var('message', '', true);
	$friendemail = request_var('friendemail', '', true);
	$friendname = request_var('friendname', '', true);

	if (!empty($friendemail) && (strpos($friendemail, '@') > 0))
	{
		if (empty($friendname))
		{
			$friendname = substr($friendemail, 0, strpos($friendemail, '@'));
		}
	}
	else
	{
		$error = true;
		$error_msg = $lang['Tell_Friend_Wrong_Email'];
	}

	if (!$error)
	{
		if ($config['html_email'])
		{
			$message = str_replace("\n", '<br />', $message);
			$message = str_replace($topic_link, ('<a href="' . $topic_link . '">' . $topic_link . '</a>'), $message);
		}

		include(IP_ROOT_PATH . 'includes/emailer.' . PHP_EXT);
		$emailer = new emailer($config['smtp_delivery']);

		$email_headers = 'X-AntiAbuse: Board servername - ' . trim($config['server_name']) . "\n";
		$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
		$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
		$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";

		$emailer->use_template('tellafriend_email', $user_lang);
		$emailer->email_address($friendname . '<' . $friendemail . '>');
		$emailer->from($userdata['user_email']);
		$emailer->replyto($userdata['user_email']);
		$emailer->extra_headers($email_headers);
		$emailer->set_subject($topic_title);

		$emailer->assign_vars(array(
			'SITENAME' => $config['sitename'],
			'BOARD_EMAIL' => $config['board_email'],
			'FROM_USERNAME' => $userdata['username'],
			'TO_USERNAME' => $friendname,
			'MESSAGE' => $message
			)
		);
		$emailer->send();
		$emailer->reset();

		$redirect_url = append_sid(CMS_PAGE_FORUM);
		meta_refresh(5, $redirect_url);

		$message = $lang['Email_sent'] . '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid(CMS_PAGE_FORUM) . '">', '</a>');

		message_die(GENERAL_MESSAGE, $message);
	}

	if ($error)
	{
		$template->set_filenames(array('reg_header' => 'error_body.tpl'));
		$template->assign_vars(array(
			'ERROR_MESSAGE' => $error_msg
			)
		);
		$template->assign_var_from_handle('ERROR_BOX', 'reg_header');
	}

}

full_page_generation('tellafriend_body.tpl', '', '', '');

?>