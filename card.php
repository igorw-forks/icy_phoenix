<?php
/**
*
* @package Icy Phoenix
* @version $Id$
* @copyright (c) 2008 Icy Phoenix
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
*
* @Extra credits for this file
* Niels Chr. Rød (ncr@db9.dk) - (http://mods.db9.dk)
*
*/

define('IN_ICYPHOENIX', true);
if (!defined('IP_ROOT_PATH')) define('IP_ROOT_PATH', './');
if (!defined('PHP_EXT')) define('PHP_EXT', substr(strrchr(__FILE__, '.'), 1));
include(IP_ROOT_PATH . 'common.' . PHP_EXT);

// Find what we are to do
$mode = (isset($_POST['report_x'])) ? 'report' :
		((isset($_POST['report_reset_x'])) ? 'report_reset' :
			((isset($_POST['ban_x'])) ? 'ban' :
				((isset($_POST['unban_x'])) ? 'unban' :
					((isset($_POST['warn_x'])) ? 'warn' :
						((isset($_POST['block_x'])) ? 'block' :
							((isset($_GET['mode'])) ? $_GET['mode'] : ''
							)
						)
					)
				)
			)
		);

if (empty($mode))
{
	message_die(GENERAL_ERROR, "No action specified", "", __LINE__, __FILE__, 'mode="' . $mode . '"');
}

$forum_id = request_var(POST_FORUM_URL, 0);
$topic_id = request_var(POST_TOPIC_URL, 0);
$post_id = request_var(POST_POST_URL, 0);
$post_id = empty($post_id) ? request_var('post_id', 0) : $post_id;

$user_id = request_var(POST_USERS_URL, 0);
$user_id = ($user_id < 2) ? ANONYMOUS : $user_id;

$forum_id_append = (!empty($forum_id) ? (POST_FORUM_URL . '=' . $forum_id . '&amp;') : '');
$topic_id_append = (!empty($topic_id) ? (POST_TOPIC_URL . '=' . $topic_id . '&amp;') : '');
$post_id_append = (!empty($post_id) ? (POST_POST_URL . '=' . $post_id) : '');

// check that we have all what is needed to know
if (empty($post_id) && ($user_id == ANONYMOUS))
{
	message_die(GENERAL_ERROR, "No user/post specified", "", __LINE__, __FILE__, 'post_id="' . $post_id . '", user_id="' . $user_id . '"');
}

$sql = 'SELECT DISTINCT forum_id, poster_id, post_bluecard FROM ' . POSTS_TABLE . ' WHERE post_id = "' . $post_id . '"';
$result = $db->sql_query($sql);
$result = $db->sql_fetchrow($result);
$blue_card = $result['post_bluecard'];
if ($post_id)
{
	// post mode
	$forum_id = $result['forum_id'];
	$poster_id = $result['poster_id'];
}
elseif ($user_id)
{
	//user mode
	//forum_id will control witch permission, when no post_id is given, and a user_id is given instead
	//disable the frum_id line will give no default access when no post_id is given
	// installe extra permission mod, in order to enable this feature
//	$forum_id = PAGE_CARD;
	$poster_id = $user_id;
}

// Start session management
$userdata = session_pagestart($user_ip);
init_userprefs($userdata);
// End session management

// Start auth check
$is_auth = array();
$is_auth = auth(AUTH_ALL, $forum_id, $userdata);

$no_error = true;
$already_banned = false;

if ($mode == 'report_reset')
{
	if (! $is_auth['auth_mod'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}

	$sql = "SELECT p.post_subject, f.forum_name FROM " . POSTS_TABLE . " p, " . FORUMS_TABLE . " f WHERE p.post_id = '" . $post_id . "' AND p.forum_id = f.forum_id";
	$result = $db->sql_query($sql);
	$subject = $db->sql_fetchrow($result);
	$post_subject = $subject['post_subject'];
	$forum_name = $subject['forum_name'];

	$sql = 'UPDATE ' . POSTS_TABLE . ' SET post_bluecard = "0" WHERE post_id = "' . $post_id . '"';
	$result = $db->sql_query($sql);
	message_die(GENERAL_MESSAGE, $lang['Post_reset'].'<br /><br />'.
	sprintf($lang['Click_return_viewtopic'], '<a href="' . append_sid(CMS_PAGE_VIEWTOPIC . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id). '">', '</a>'));
}
elseif ($mode == 'report')
{
	if (!$is_auth['auth_bluecard'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}

	$sql = 'SELECT f.forum_name, p.topic_id FROM ' . POSTS_TABLE . ' p, ' . FORUMS_TABLE . ' f WHERE p.post_id = "' . $post_id . '" AND  p.forum_id = f.forum_id';
	$result = $db->sql_query($sql);
	$post_details = $db->sql_fetchrow($result);
	$forum_name = $post_details['forum_name'];
	$topic_id = $post_details['topic_id'];

	$sql = 'SELECT p.post_subject FROM ' . POSTS_TABLE . ' p, ' . TOPICS_TABLE . ' t WHERE t.topic_id = "' . $topic_id . '" AND p.post_id = t.topic_first_post_id';
	$result = $db->sql_query($sql);
	$post_details = $db->sql_fetchrow($result);
	$post_subject = $post_details['post_subject'];

	$sql = 'SELECT p.topic_id FROM ' . POSTS_TABLE . ' p WHERE p.post_subject = "(' . $post_id . ')' . $post_subject . '"';
	$result = $db->sql_query($sql);
	$post_details = $db->sql_fetchrow($result);
	$allready_reported = ($blue_card) ? $post_details['topic_id'] : '';

	$blue_card++;
	$sql = 'UPDATE ' . POSTS_TABLE . ' SET post_bluecard = "' . $blue_card . '" WHERE post_id = "' . $post_id . '"';
	$result = $db->sql_query($sql);

	// Obtain list of moderators of this forum
	$sql = "SELECT u.user_id, u.username, u.user_email, u.user_lang
		FROM " . AUTH_ACCESS_TABLE . " aa,  " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g, " . USERS_TABLE . " u
		WHERE aa.forum_id = $forum_id
			AND aa.auth_mod = " . TRUE . "
			AND ug.group_id = aa.group_id
			AND g.group_id = aa.group_id
			AND u.user_id = ug.user_id";
	$result = $db->sql_query($sql);
	$total_mods = $db->sql_numrows($result);
	$mods_rowset = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	// Obtain list of moderators of this forum
	$sql = "SELECT u.user_id, u.username, u.user_email, u.user_lang
		FROM " . USERS_TABLE . " u
		WHERE u.user_level = '" . ADMIN . "'
			OR  u.user_level = '" . JUNIOR_ADMIN . "'";
	$result = $db->sql_query($sql);
	$total_admins = $db->sql_numrows($result);
	$admins_rowset = $db->sql_fetchrowset($result);
	$db->sql_freeresult($result);

	$temp_recipients = array_merge($mods_rowset, $admins_rowset);
	$report_recipients = array();
	$report_recipients_ids = array();
	$total_recipients = 0;
	foreach ($temp_recipients as $recipient)
	{
		if (!isset($report_recipients_ids[$recipient['user_id']]))
		{
			$report_recipients[] = $recipient;
			$report_recipients_ids[$recipient['user_id']] = $recipient['user_id'];
			$total_recipients++;
		}
	}

	if (empty($total_recipients))
	{
		message_die(GENERAL_MESSAGE, $lang['No_moderators'] . '<br /><br />');
	}

	(($config['report_forum']) ? sprintf($lang['Send_message'], '<a href="' . append_sid('posting.' . PHP_EXT . '?mode=' . (($allready_reported) ? 'reply&amp;' . POST_TOPIC_URL . '=' . $allready_reported : 'newtopic&amp' . POST_FORUM_URL . '=' . $config['report_forum']) . '&amp;postreport=' . $post_id) . '">', '</a>') : '') . sprintf($lang['Click_return_viewtopic'], '<a href="' . append_sid(CMS_PAGE_VIEWTOPIC . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id) . '">', '</a>');

	$i = 0;
	if (($blue_card >= $config['bluecard_limit_2'] && (!(($blue_card - $config['bluecard_limit_2']) % $config['bluecard_limit']))) || ($blue_card == $config['bluecard_limit_2']))
	{
		include(IP_ROOT_PATH . 'includes/emailer.' . PHP_EXT);
		$server_url = create_server_url();
		$viewtopic_server_url = $server_url . CMS_PAGE_VIEWTOPIC;
		while ($i < $total_recipients)
		{
			$emailer = new emailer($config['smtp_delivery']);

			$email_headers = 'X-AntiAbuse: Board servername - ' . trim($config['server_name']) . "\n";
			$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
			$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
			$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";

			$emailer->use_template('repport_post', (file_exists(IP_ROOT_PATH . 'language/lang_' . $report_recipients[$i]['user_lang'] . '/email/html/repport_post.tpl')) ? $report_recipients[$i]['user_lang'] : 'english');
			$emailer->email_address($report_recipients[$i]['user_email']);
			$emailer->from($config['board_email']);
			$emailer->replyto($config['board_email']);
			$emailer->extra_headers($email_headers);
			//$emailer->set_subject($subject);

			$emailer->assign_vars(array(
				'POST_URL' => $viewtopic_server_url . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id,
				'POST_SUBJECT' => $post_subject,
				'FORUM_NAME' => $forum_name,
				'USER' => '"' . $userdata['username'] . '"',
				'NUMBER_OF_REPPORTS' => $blue_card,
				'SITENAME' => $config['sitename'],
				'BOARD_EMAIL' => $config['board_email']
				)
			);
			$emailer->send();
			$emailer->reset();
			$i++;
		}
	}
	message_die(GENERAL_MESSAGE, (($total_mods) ? sprintf($lang['Post_reported'], $total_mods) : $lang['Post_reported_1']) . '<br /><br />' . (($config['report_forum']) ? sprintf($lang['Send_message'], '<a href="' . append_sid('posting.' . PHP_EXT . '?mode=' . (($allready_reported) ? 'reply&amp;' . POST_TOPIC_URL . '=' . $allready_reported : 'newtopic&amp;' . POST_FORUM_URL . '=' . $config['report_forum']) . '&amp;postreport=' . $post_id) . '">', '</a>') : '') . sprintf($lang['Click_return_viewtopic'], '<a href="' . append_sid(CMS_PAGE_VIEWTOPIC . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id). '">', '</a>'));
}
elseif ($mode == 'unban')
{
	if (! $is_auth['auth_greencard'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}
	// look up the user
	$sql = 'SELECT user_active, user_warnings FROM ' . USERS_TABLE . ' WHERE user_id="' . $poster_id . '"';
	$result = $db->sql_query($sql);
	$the_user = $db->sql_fetchrow($result);

	// remove the user from ban list
	$sql = 'DELETE FROM ' . BANLIST_TABLE . ' WHERE ban_userid = "' . $poster_id . '"';
	$result = $db->sql_query($sql);

	// update the user table with new status
	$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings = "0" WHERE user_id = "' . $poster_id . '"';
	$result = $db->sql_query($sql);

	$message = $lang['Ban_update_green'] . '<br /><br />' . sprintf($lang['Send_PM_user'], '<a href="' . append_sid(CMS_PAGE_PRIVMSG . '?mode=post&u=' . $poster_id) . '">', '</a>');
	$e_temp = 'ban_reactivated';
	//$e_subj = $lang['Ban_reactivate'];
}
elseif ($mode == 'ban')
{
	if (!$is_auth['auth_ban'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}
	// look up the user
	$sql = 'SELECT user_active, user_level FROM ' . USERS_TABLE . ' WHERE user_id="' . $poster_id . '"';
	$result = $db->sql_query($sql);
	$the_user = $db->sql_fetchrow($result);
	if (($the_user['user_level'] == ADMIN) || ($the_user['user_level'] == JUNIOR_ADMIN))
	{
		message_die(GENERAL_ERROR, $lang['Ban_no_admin']);
	}

	// insert the user in the ban list
	$sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . ' WHERE ban_userid = "' . $poster_id . '"';
	$result = $db->sql_query($sql);
	if ((!$db->sql_fetchrowset($result)) && ($poster_id != ANONYMOUS))
	{
		// insert the user in the ban list
		$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid) VALUES ($poster_id)";
		$result = $db->sql_query($sql);
		// update the user table with new status
		$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings = "' . $config['max_user_bancard'] . '" WHERE user_id="' . $poster_id . '"';
		$result = $db->sql_query($sql);
		$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_logged_in = "0" WHERE session_user_id="' . $poster_id . '"';
		$result = $db->sql_query($sql);
		$message = $lang['Ban_update_red'];
		$e_temp = 'ban_block';
		//$e_subj = $lang['Card_banned'];
	}
	else
	{
		$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings = "' . $config['max_user_bancard'] . '" WHERE user_id="' . $poster_id . '"';
		$result = $db->sql_query($sql);
		$no_error = false;
		$already_banned = true;
	}
}
elseif ($mode == 'block')
{
	if (empty($config['block_time']))
	{
		message_die(GENERAL_ERROR, "Protect user account mod not installed, this is required for this operation");
	}
	if (! $is_auth['auth_ban'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}
	// look up the user
	$sql = "SELECT user_active, user_level FROM " . USERS_TABLE . " WHERE user_id = '" . $poster_id . "'";
	$result = $db->sql_query($sql);
	$the_user = $db->sql_fetchrow($result);
	if (($the_user['user_level'] == ADMIN) || ($the_user['user_level'] == JUNIOR_ADMIN))
	{
		message_die(GENERAL_ERROR, $lang['Block_no_admin']);
	}
	// update the user table with new status
	$sql = "UPDATE " . USERS_TABLE . " SET user_block_by = '" . $user_ip . "', user_blocktime = '" . (time() + $config['RY_block_time'] * 60) . "' WHERE user_id = '" . $poster_id . "'";
	$result = $db->sql_query($sql);

	$sql = "UPDATE " . SESSIONS_TABLE . " SET session_logged_in = '0', session_user_id = '" . ANONYMOUS . "' WHERE session_user_id = '" . $poster_id . "'";
	$result = $db->sql_query($sql);

	$block_time = make_time_text ($config['RY_block_time']);
	$message = sprintf($lang['Block_update'],$block_time) . '<br /><br />' . sprintf($lang['Send_PM_user'], '<a href="' . append_sid(CMS_PAGE_PRIVMSG . '?mode=post&amp;' . POST_USERS_URL . '=' . $poster_id) . '">', '</a>');
	$e_temp = 'card_block';
	//$e_subj = sprintf($lang['Card_blocked'], $block_time);
}
elseif ($mode == 'warn')
{
	if (!$is_auth['auth_ban'])
	{
		message_die(GENERAL_ERROR, $lang['Not_Authorized']);
	}
	// look up the user
	$sql = 'SELECT user_active, user_warnings, user_level FROM ' . USERS_TABLE . ' WHERE user_id="' . $poster_id . '"';
	$result = $db->sql_query($sql);
	$the_user = $db->sql_fetchrow($result);
	if (($the_user['user_level'] == ADMIN) || ($the_user['user_level'] == JUNIOR_ADMIN))
	{
		message_die(GENERAL_ERROR, $lang['Ban_no_admin']);
	}

	//update the warning counter
	$sql = 'UPDATE ' . USERS_TABLE . ' SET user_warnings = user_warnings + 1 WHERE user_id = "' . $poster_id . '"';
	$result = $db->sql_query($sql);

	// se if the user are to be banned, if so do it ...
	if (($the_user['user_warnings'] + 1) >= $config['max_user_bancard'])
	{
		$sql = 'SELECT ban_userid FROM ' . BANLIST_TABLE . ' WHERE ban_userid = "' . $poster_id . '"';
		$result = $db->sql_query($sql);
		if ((!$db->sql_fetchrowset($result)) && ($poster_id != ANONYMOUS))
		{
			// insert the user in the ban list
			$sql = "INSERT INTO " . BANLIST_TABLE . " (ban_userid) VALUES ($poster_id)";
			$result = $db->sql_query($sql);
			// update the user table with new status
			$sql = 'UPDATE ' . SESSIONS_TABLE . ' SET session_logged_in = "0" WHERE session_user_id = "' . $poster_id . '"';
			$result = $db->sql_query($sql);
			$message = $lang['Ban_update_red'];
			$e_temp = 'ban_block';
			// $e_subj = $lang['Ban_blocked'];
		}
		else
		{
			$no_error = false;
			$already_banned = true;
		}
	}
	else
	{
		// the user shall not be baned this time, update the counter
		$message = sprintf($lang['Ban_update_yellow'], ($the_user['user_warnings'] + 1), $config['max_user_bancard']) . '<br /><br />' . sprintf($lang['Send_PM_user'], '<a href="' . append_sid(CMS_PAGE_PRIVMSG . '?mode=post&u=' . $poster_id) . '">', '</a>');
		$e_temp = 'ban_warning';
		// $e_subj = $lang['Ban_warning'];
	}
}
else
{
	$no_error = false;
}

if ($no_error)
{
	$sql = 'SELECT username, user_warnings, user_email, user_lang FROM ' . USERS_TABLE . ' WHERE user_id = "' . $poster_id . '"';
	$result = $db->sql_query($sql);
	$warning_data = $db->sql_fetchrow($result);
	if (!empty($warning_data['user_email']))
	{
		$server_url = create_server_url();
		$viewtopic_server_url = $server_url . CMS_PAGE_VIEWTOPIC;
		$from_email = ($userdata['user_email'] && $userdata['user_viewemail']) ? $userdata['user_email'] : $config['board_email'];

		include_once(IP_ROOT_PATH . 'includes/emailer.' . PHP_EXT);
		$emailer = new emailer($config['smtp_delivery']);

		$email_headers = 'X-AntiAbuse: Board servername - ' . trim($config['server_name']) . "\n";
		$email_headers .= 'X-AntiAbuse: User_id - ' . $userdata['user_id'] . "\n";
		$email_headers .= 'X-AntiAbuse: Username - ' . $userdata['username'] . "\n";
		$email_headers .= 'X-AntiAbuse: User IP - ' . decode_ip($user_ip) . "\n";

		$emailer->use_template($e_temp, $warning_data['user_lang']);
		$emailer->email_address($warning_data['user_email']);
		$emailer->from($from_email);
		$emailer->replyto($from_email);
		$emailer->extra_headers($email_headers);
		//$emailer->set_subject($e_subj);

		$emailer->assign_vars(array(
			'SITENAME' => $config['sitename'],
			'WARNINGS' => $warning_data['user_warnings'],
			'TOTAL_WARN' => $config['max_user_bancard'],
			'POST_URL' => $viewtopic_server_url . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id,
			'EMAIL_SIG' => str_replace("<br />", "\n", $config['sig_line'] . " \n" . $config['board_email_sig']),
			'WARNER' => $userdata['username'],
			'BLOCK_TIME' => $block_time,
			'WARNED_POSTER' => $warning_data['username'])
		);
		$emailer->send();
		$emailer->reset();
	}
	else
	{
		$message .= '<br /><br />' . $lang['user_no_email'];
	}
}
elseif ($already_banned)
{
	$message = $lang['user_already_banned'];
}
else
{
	$message = 'Error in card.php file';
}

$cache->destroy_datafiles(array('_ranks'), MAIN_CACHE_FOLDER, 'data', false);
$db->clear_cache('ban_', USERS_CACHE_FOLDER);

$message .= ($post_id != '-1') ? '<br /><br />' . sprintf($lang['Click_return_viewtopic'], '<a href="' . append_sid(CMS_PAGE_VIEWTOPIC . '?' . $forum_id_append . $topic_id_append . POST_POST_URL . '=' . $post_id . '#p' . $post_id) . '">', '</a>') : '<br /><br />' . sprintf($lang['Click_return_index'], '<a href="' . append_sid(CMS_PAGE_FORUM). '">', '</a>');

message_die(GENERAL_MESSAGE, $message);

?>