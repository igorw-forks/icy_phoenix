{IMG_TBL}<div class="forumline nav-div">
	<p class="nav-header">
		<a href="{U_PORTAL}">{L_HOME}</a>{NAV_SEP}<a href="{U_INDEX}">{L_INDEX}</a>{NAV_SEP}<a href="{U_RECENT}">{L_RECENT}</a>{NAV_SEP}<a href="#" class="nav-current">{STATUS}</a>
	</p>
	<div class="nav-links">
		<div class="nav-links-left">{CURRENT_TIME}</div>
		<form name="form" method="get" action="{FORM_ACTION}">
			{L_SELECT_MODE}
			[ <a href="{FORM_ACTION}?mode=today" class="mainmenu">{L_TODAY}</a> ]
			[ <a href="{FORM_ACTION}?mode=yesterday" class="mainmenu">{L_YESTERDAY}</a> ]
			[ <a href="{FORM_ACTION}?mode=last24" class="mainmenu">{L_LAST24}</a> ]
			[ <a href="{FORM_ACTION}?mode=lastweek" class="mainmenu">{L_LASTWEEK}</a> ]
			[ <a href="#" class="mainmenu">{L_LAST}</a> <input type="hidden" name="mode" value="lastXdays" />
			<input type="text" name="amount_days" size="2" value="{AMOUNT_DAYS}" maxlength="3" class="post" />
			<a href="javascript:document.form.submit();" class="mainmenu">{L_DAYS}</a> ]
		</form>
	</div>
</div>{IMG_TBR}

{IMG_THL}{IMG_THC}<span class="forumlink">{L_RECENT_TITLE}</span>{IMG_THR}<table class="forumlinenb" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<th>&nbsp;</th>
	<th><a href="{U_SORT_CAT}">{L_FORUM}</a></th>
	<th>{L_TOPICS}</th>
	<th>{L_REPLIES}</th>
	<th>{L_AUTHOR}</th>
	<th>{L_VIEWS}</th>
	<th><a href="{U_SORT_TIME}">{L_LASTPOST}</a></th>
</tr>
<!-- BEGIN recent -->
<tr>
	<td class="row1 row-center" width="22"><img src="{recent.TOPIC_FOLDER_IMG}" alt="{recent.L_TOPIC_FOLDER_ALT}" title="{recent.L_TOPIC_FOLDER_ALT}" style="margin-right:4px;" /></td>
	<td class="row1h{recent.CLASS_NEW} row-forum" onclick="window.location.href='{recent.U_VIEW_FORUM}'">
		<span class="topiclink{recent.CLASS_NEW}"><a href="{recent.U_VIEW_FORUM}">{recent.FORUM_NAME}</a></span>
	</td>
	<td class="row1h{recent.CLASS_NEW} row-forum" onclick="window.location.href='{recent.U_VIEW_TOPIC}'">
		<span class="topiclink{recent.CLASS_NEW}">
			{recent.NEWEST_POST_IMG}{recent.TOPIC_ATTACHMENT_IMG}{recent.L_NEWS}{recent.TOPIC_TYPE}<a href="{recent.U_VIEW_TOPIC}" class="{recent.TOPIC_CLASS}">{recent.TOPIC_TITLE}</a>
		</span>
		{recent.GOTO_PAGE}
	</td>
	<td class="row2 row-center-small">{recent.REPLIES}</td>
	<td class="row1 row-center">{recent.FIRST_AUTHOR}</td>
	<td class="row2 row-center-small">{recent.VIEWS}</td>
	<td class="row1 row-center" width="20%" nowrap="nowrap"><span class="gensmall">{recent.LAST_TIME}<br />{recent.LAST_AUTHOR}&nbsp;{recent.LAST_URL}&nbsp;</span></td>
</tr>
<!-- END recent -->
<!-- BEGIN switch_no_topics -->
<tr><td colspan="7" class="row1 row-center"><span class="gen"><i>{L_NO_TOPICS}</i></span></td></tr>
<!-- END switch_no_topics -->
<tr><td class="cat" colspan="7">&nbsp;</td></tr>
</table>{IMG_TFL}{IMG_TFC}{IMG_TFR}
<table class="empty-table" width="100%" cellspacing="0" cellpadding="0" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="pagination">{PAGINATION}</span><br /><span class="gensmall">{S_TIMEZONE}</span></td>
</tr>
</table>