{IMG_TBL}<div class="forumline nav-div">
	<p class="nav-header">
		<a href="{U_PORTAL}">{L_HOME}</a>{NAV_SEP}<a href="{U_INDEX}">{L_INDEX}</a>{NAV_SEP}<a href="{REQUEST_URI}">{PAGE_NAME}</a>{NAV_SEP}<a href="{TOPIC}" class="nav-current">{L_TITLE}</a>
	</p>
	<div class="nav-links">
		<div class="nav-links-left">{CURRENT_TIME}</div>
		{L_TOPIC_RETURN}
	</div>
</div>{IMG_TBR}

{IMG_THL}{IMG_THC}<span class="forumlink">{L_TITLE}</span>{IMG_THR}<table class="forumlinenb" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<th align="center"><strong>{L_RANK2}</strong></th>
	<th width="38%">{L_USERNAME}</th>
	<th width="30%">{L_USER_RATED}</th>
	<th width="30%"> {L_USER_RATE_DATE}</th>
</tr>
<!-- BEGIN user_rates_row -->
<tr>
	<td class="row1 row-center"><span class="postdetails">{user_rates_row.RANK}</span></td>
	<td class="row1 row-center"><span class="postdetails">{user_rates_row.USERNAME}</span></td>
	<td class="row1 row-center"><span class="postdetails">{user_rates_row.USER_RATE}</span></td>
	<td class="row1 row-center"><span class="postdetails">{user_rates_row.USER_RATE_DATE}</span></td>
</tr>
<!-- END user_rates_row -->
</table>{IMG_TFL}{IMG_TFC}{IMG_TFR}