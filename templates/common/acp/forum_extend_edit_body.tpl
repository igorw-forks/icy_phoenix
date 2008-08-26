<script type="text/javascript">
<!--
function update_icon(newimage)
{
	if(newimage != '')
	{
		document.icon_image.src = '../' + newimage;
		document.edit.icon.value = newimage;
	}
	else
	{
		document.icon_image.src = '../images/spacer.gif';
		document.edit.icon.value = '';
	}
}
//-->
</script>

<h1>{L_TITLE}</h1>

<div class="forumline nav-div">
	<p class="nav-header">
		<a href="{U_INDEX}" class="nav">{L_INDEX}</a>{NAV_CAT_DESC}</span>
	</p>
	<div class="nav-links">
		<div class="nav-links-left">
			{L_TITLE_EXPLAIN}
		</div>
		&nbsp;<br />&nbsp;
	</div>
</div>

<form method="post" name="edit" action="{S_ACTION}">
<table class="forumline" width="100%" cellspacing="0" cellpadding="0">
<tr><th colspan="2" width="70%">{L_TITLE}</th></tr>
<tr>
	<td class="row1" width="40%"><span class="gen">{L_TYPE}</span></td>
	<td class="row2" width="60%"><span class="gen">&nbsp;<select name="type" onchange="this.form.submit();">{S_TYPE_OPT}</select></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_NAME}</span></td>
	<td class="row2"><span class="gen">&nbsp;<input name="name" value="{NAME}" type="text" class="post" size="60" /></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_DESC}</span></td>
	<td class="row2"><span class="gen">&nbsp;<textarea name="desc" rows="5" cols="60" class="post">{DESC}</textarea></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_MAIN}</span></td>
	<td class="row2"><span class="gen">&nbsp;<select name="main" onchange="this.form.submit();">{S_FORUMS_OPT}</select></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_COPY_AUTH}</span><!-- <br /><span class="gensmall">{L_COPY_AUTH_EXPLAIN}</span> --></td>
	<td class="row2"><span class="gen">&nbsp;<select name="dup_auth">{S_FORUM_LIST}</select></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_ICON}</span><span class="gensmall"><br />{L_ICON_EXPLAIN}</span></td>
	<td class="row2">&nbsp;{ICON_LIST}</td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_POSITION}</span></td>
	<td class="row2"><span class="gen">&nbsp;<select name="position">{S_POS_OPT}</select></span></td>
</tr>
<!-- BEGIN forum -->
<tr>
	<td class="row1"><span class="gen">{L_STATUS}</span></td>
	<td class="row2"><span class="gen">&nbsp;<select name="status">{S_STATUS_OPT}</select></span></td>
</tr>
<!-- BEGIN topic_display_order -->
<tr>
	<td class="row1"><span class="gen">{L_FORUM_DISPLAY_SORT}</span></td>
	<td class="row2"><span class="gen">&nbsp;<select name="forum_display_sort">{S_FORUM_DISPLAY_SORT_LIST}</select>&nbsp;<select name="forum_display_order">{S_FORUM_DISPLAY_ORDER_LIST}</select></span></td>
</tr>
<!-- END topic_display_order -->
<!-- END forum -->
<!-- BEGIN move -->
<tr>
	<td class="row1"><span class="gen">{L_MOVE}</span></td>
	<td class="row2"><span class="gen">&nbsp;<select name="move">{S_MOVE_OPT}</select></span></td>
</tr>
<!-- END move -->
<!-- BEGIN forum -->
<tr>
	<td class="row1"><span class="gen">{L_FORUM_THANK}</span></td>
	<td class="row2">
	<input type="radio" name="thank" value="1" {FORUM_THANK_YES} />
	<span class="gen">{L_YES}</span>&nbsp;&nbsp;
	<input type="radio" name="thank" value="0" {FORUM_THANK_NO} />
	<span class="gen">{L_NO}</span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_FORUM_NOTIFY}</span></td>
	<td class="row2">
	<input type="radio" name="forum_notify" value="1" {FORUM_NOTIFY_YES} />
	<span class="gen">{L_YES}</span>&nbsp;&nbsp;
	<input type="radio" name="forum_notify" value="0" {FORUM_NOTIFY_NO} />
	<span class="gen">{L_NO}</span></td>
</tr>
<tr><th colspan="2">{L_MOD_OS_FORUMRULES}</th></tr>
<tr>
	<td class="row1">{L_RULES_DISPLAY_TITLE}</td>
	<td class="row2">
		<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td><input type="checkbox" name="rules_display_title" value="1" {S_RULES_DISPLAY_TITLE_ENABLED} /></td>
				<td>{L_ENABLED}</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td class="row1">{L_RULES_CUSTOM_TITLE}</td>
	<td class="row2"><input type="text" name="rules_custom_title" value="{RULES_CUSTOM_TITLE}" size="50" maxlength="80" class="post" /></td>
</tr>
<tr>
	<td class="row1" valign="top">{L_FORUM_RULES}</td>
	<td class="row2"><textarea rows="8" cols="70" wrap="virtual" name="forum_rules" class="post">{FORUM_RULES}</textarea></td>
</tr>
<tr>
	<td class="row1" valign="top">{L_RULES_APPEAR_IN}</td>
	<td class="row2">
		<table cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td><input type="checkbox" name="rules_in_viewforum" value="1" {S_RULES_VIEWFORUM_ENABLED} /></td>
				<td>{L_RULES_IN_VIEWFORUM}</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="rules_in_viewtopic" value="1" {S_RULES_VIEWTOPIC_ENABLED} /></td>
				<td>{L_RULES_IN_VIEWTOPIC}</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="rules_in_posting" value="1" {S_RULES_POSTING_ENABLED} /></td>
				<td>{L_RULES_IN_POSTING}</span></td>
			</tr>
		</table>
	</td>
</tr>
<!-- END forum -->
<!-- BEGIN forum -->
<tr>
	<td class="cat" colspan="2">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td width="100%"><span class="cattitle">{L_PRUNE_ENABLE}</span></td>
			<td nowrap="nowrap">
				<span class="genmed">
					<b>{L_ENABLED}:&nbsp;</b>
					<input name="prune_enable" type="radio" value="0" {PRUNE_ENABLE_NO} onClick="if (this.form.prune_enable.checked=true) {document.all.prune_display.style.display='none'} else {document.all.prune_display.style.display=''}" />
					{L_NO}&nbsp;&nbsp;
					<input name="prune_enable" type="radio" value="1" {PRUNE_ENABLE_YES} onClick="if (this.form.prune_enable.checked=false) {document.all.prune_display.style.display='none'} else {document.all.prune_display.style.display=''}" />
					{L_YES}
				</span>
			</td>
		</tr>
		</table>
	</td>
</tr>
<tbody id="prune_display" style="display:{PRUNE_DISPLAY}">
<tr>
	<td class="row1" align="right"><span class="gen">{L_PRUNE_DAYS}</span></td>
	<td class="row2"><span class="gen">&nbsp;<input name="prune_days" type="text" class="post" value="{PRUNE_DAYS}" size="3" />&nbsp;{L_DAYS}</span></td>
</tr>
<tr>
	<td class="row1" align="right"><span class="gen">{L_PRUNE_FREQ}</span></td>
	<td class="row2"><span class="gen">&nbsp;<input name="prune_freq" type="text" class="post" value="{PRUNE_FREQ}" size="3" />&nbsp;{L_DAYS}</span></td>
</tr>
</tbody>
<!-- END forum -->
<!-- BEGIN link -->
<tr>
	<td class="cat" colspan="2"><span class="cattitle">{L_LINK}</span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_FORUM_LINK}</span><span class="gensmall"><br />{L_FORUM_LINK_EXPLAIN}</span></td>
	<td class="row2"><span class="gen">&nbsp;<input name="link" type="text" class="post" value="{FORUM_LINK}" size="60" /></span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_FORUM_LINK_INTERNAL}</span><span class="gensmall"><br />{L_FORUM_LINK_INTERNAL_EXPLAIN}</span></td>
	<td class="row2"><span class="gen"><input name="link_internal" type="radio" value="1" {LINK_INTERNAL_YES} />{L_YES}&nbsp;&nbsp;<input name="link_internal" type="radio" value="0" {LINK_INTERNAL_NO} />{L_NO}</span></td>
</tr>
<tr>
	<td class="row1"><span class="gen">{L_FORUM_LINK_HIT_COUNT}</span><span class="gensmall"><br />{L_FORUM_LINK_HIT_COUNT_EXPLAIN}</span></td>
	<td class="row2"><span class="gen"><input name="link_hit_count" type="radio" value="1" {LINK_COUNT_YES} />{L_YES}&nbsp;&nbsp;<input name="link_hit_count" type="radio" value="0" {LINK_COUNT_NO} />{L_NO}</span></td>
</tr>
<!-- END link -->
<!-- BEGIN forum_link -->
<tr>
	<td width="100%" colspan="5">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
		<tr>
			<td class="cat" colspan="{AUTH_SPAN}">
				<table cellspacing="0" cellpadding="0" border="0" width="100%">
				<tr>
					<td align="left" width="100%"><span class="cattitle">{L_AUTH}</span></td>
					<!-- BEGIN no_link -->
					<td align="right" nowrap="nowrap">
						<span class="genmed"><input type="hidden" name="preset_choice" value="0" />
							&nbsp;<b>{L_PRESET}:&nbsp;</b>
							<select name="forum_preset" onChange="this.form.preset_choice.value=1; this.form.submit();">{S_PRESET_OPT}</select>
						</span>
					</td>
					<!-- END no_link -->
				</tr>
				</table>
			</td>
		</tr>
		<!-- BEGIN auth -->
		<tr>
			<!-- BEGIN cell -->
			<td width="25%" class="{forum_link.auth.cell.COLOR}" align="center">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
					<td align="right" width="50%"><span class="genmed">{forum_link.auth.cell.L_AUTH}:</span></td>
					<td align="left" nowrap="nowrap"><select name="{forum_link.auth.cell.AUTH}">{forum_link.auth.cell.S_AUTH_OPT}</select></td>
				</tr>
				</table>
			</td>
			<!-- END cell -->
			<!-- BEGIN empty -->
			<td class="row3" colspan="{forum_link.auth.empty.SPAN}"><span class="genmed">&nbsp;</span></td>
			<!-- END empty -->
		</tr>
		<!-- END auth -->
		</table>
	</td>
</tr>
<!-- END forum_link -->
<tr>
	<td class="cat" align="center"  colspan="5">{S_HIDDEN_FIELDS}
		<span class="cattitle">
			<input type="submit" name="update" value="{L_SUBMIT}" class="mainoption" />&nbsp;
			<input type="submit" name="cancel" value="{L_CANCEL}" class="liteoption" />&nbsp;
			<input type="submit" name="refresh" value="{L_REFRESH}" class="liteoption" />&nbsp;
		</span>
	</td>
</tr>
</table>
</form>