<?php

$lang['start_tag']	= '<html><body>';
$lang['end_tag']	= '</body></html>';
///////////////////////////////////
// ������� �����������

$lang['letter_subject'] = 'findbestbride.com - You have received new message!';
$lang['letter_body'] = '<p>Hi,</p>
<p>%s sent you a new message with subject:</p>
<table border="0" width="100%" cellpadding="15" cellspacing="0"><tbody><tr><td style="background-color:#e8e8e8">
	%s
</td></tr></tbody></table>
<table border="0" cellpadding="0" cellspacing="0"><tbody><tr><td>&nbsp;</td></tr></tbody></table>
<table border="0" cellpadding="10" cellspacing="0"><tbody><tr><td style="padding-left:15px;padding-right:15px;background-color:#3366cc">
	<a href="' . base_url() . 'my/letters/" style="color:#fff;font-weight:bold;text-decoration:none" target="_blank">Read this message</a>
</td></tr></tbody></table>
<p>You can configure email notifications <a href="' . base_url() . 'my/edit/" style="color:#404040" target="_blank">on this page</a>.<br></p>
<p>Sincerely, Administration<br>
<a href="' . base_url() . '" style="color:#404040" target="_blank">findbestbride.com</a></p>
';


/////////////////////////////////
//

$lang['women_subject']	= 'A-mans-mind.com - New women profiles on website';
$lang['women_template'] = '<tr>
				<td><img src="%s"><br>%s</td>
				<td style="padding-left:15px;padding-right:15px;">
						<a href="' . base_url() . 'user%s" style="background-color:#3366cc;color:#fff;font-weight:bold;text-decoration:none" target="_blank">VIEW PROFILE</a>
				</td>
				</tr>';
$lang['women_header']	= '<html><body>
				<p>HI,</p>
				<p>we picked up a few profiles that may interest for you.</p>
				<table border="0" width="100%" cellpadding="15" cellspacing="0">';
$lang['women_footer']	= '</table>
<table border="0" cellpadding="10" cellspacing="0"><tbody><tr><td style="padding-left:15px;padding-right:15px;background-color:#3366cc">
	<a href="' . base_url() . 'women_profiles/" style="color:#fff;font-weight:bold;text-decoration:none" target="_blank">VIEW MORE PROFILES</a>
</td></tr></tbody></table>
<p>You can configure email notifications <a href="' . base_url() . 'my/edit/" style="color:#404040" target="_blank">on this page</a>.<br></p>
<p>Sincerely, Administration<br>
<a href="' . base_url() . '" style="color:#404040" target="_blank">a-mans-mind.com</a></p>
		';