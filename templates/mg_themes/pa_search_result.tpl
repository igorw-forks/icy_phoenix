<!-- INCLUDE pa_header.tpl -->
{IMG_TBL}<div class="forumline nav-div">
	<p class="nav-header">
		<a href="{U_INDEX}">{L_HOME}</a>{NAV_SEP}<a href="{U_DOWNLOAD}" class="nav">{DOWNLOAD}</a>{NAV_SEP}<a href="#" class="nav-current">{L_SEARCH_MATCHES}</a>
	</p>
	<div class="nav-links">
		<div class="nav-links-left">{CURRENT_TIME}</div>
		<!-- INCLUDE pa_links.tpl -->
	</div>
</div>{IMG_TBR}

{IMG_THL}{IMG_THC}<span class="forumlink">{L_SEARCH_MATCHES}</span>{IMG_THR}<table class="forumlinenb" width="100%" cellspacing="0" cellpadding="0">
<tr>
	<th width="4%" height="25" nowrap="nowrap">&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_CATEGORY}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_FILE}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_SUBMITER}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_DATE}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_DOWNLOADS}&nbsp;</th>
	<th nowrap="nowrap">&nbsp;{L_RATE}&nbsp;</th>
</tr>

<!-- BEGIN searchresults -->
<tr>
	<td class="row1 row-center" width="30"><a href="{searchresults.U_FILE}" class="topictitle">{searchresults.PIN_IMAGE}</a></td>
	<td class="row1h{searchresults.XS_NEW} row-forum" onclick="window.location.href='{searchresults.U_CAT}'"><span class="forumlink"><a href="{searchresults.U_CAT}" class="forumlink{searchresults.XS_NEW}">{searchresults.CAT_NAME}</a></span>&nbsp;</td>
	<td class="row1h{searchresults.XS_NEW} row-forum" onclick="window.location.href='{searchresults.U_FILE}'"><span class="forumlink"><a href="{searchresults.U_FILE}" class="forumlink{searchresults.XS_NEW}">{searchresults.FILE_NAME}</a></span>&nbsp;
	<br /><span class="genmed">{searchresults.FILE_DESC}</span>
	</td>
	<td class="row1 row-center" align="center" valign="middle"><span class="name">{searchresults.FILE_SUBMITER}</span></td>
	<td class="row2 row-center" align="center" valign="middle"><span class="postdetails">{searchresults.DATE}</span></td>
	<td class="row1 row-center" align="center" valign="middle"><span class="postdetails">{searchresults.DOWNLOADS}</span></td>
	<td class="row2 row-center" nowrap="nowrap"><span class="postdetails"><img src="images/rates/rate_{searchresults.RATING}.png" /></td>
</tr>
<!-- END searchresults -->
<tr><td class="cat" colspan="7">&nbsp;</td></tr>
</table>{IMG_TFL}{IMG_TFC}{IMG_TFR}
<br />
<table class="empty-table" width="100%" align="center" cellspacing="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{PAGE_NUMBER}</span></td>
	<td align="right" valign="top" nowrap="nowrap"><span class="pagination">{PAGINATION}</span></td>
</tr>
</table>
<!-- INCLUDE pa_footer.tpl -->