<?php
function wp_insert_legal_get_default_privacy_policy() {
	$output = '<p>At [sitename], the privacy of our visitors is of extreme importance to us (See <a target="_blank" href="http://www.wp-insert.smartlogix.co.in/what-is-a-privacy-policy/">this article</a> to learn more about Privacy Policies.). This privacy policy document outlines the types of personal information is received and collected by [sitename] and how it is used.</p>';
	$output .= '<p><b>Log Files</b></p><p>Like many other Web sites, [sitename] makes use of log files. The information inside the log files includes internet protocol (IP) addresses, type of browser, Internet Service Provider (ISP), date/time stamp, referring/exit pages, and number of clicks to analyze trends, administer the site, track user\'s movement around the site, and gather demographic information. IP addresses, and other such information are not linked to any information that is personally identifiable.</p>';
	$output .= '<p><b>Cookies and Web Beacons</b></p><p>[sitename] does use cookies to store information about visitors preferences, record user-specific information on which pages the user access or visit, customize Web page content based on visitors browser type or other information that the visitor sends via their browser.</p>';
	$output .= '<p><b>DoubleClick DART Cookie</b></p><ul><li>Google, as a third party vendor, uses cookies to serve ads on [sitename].</li><li>Google\'s use of the DART cookie enables it to serve ads to users based on their visit to [sitename] and other sites on the Internet.</li><li>Users may opt out of the use of the DART cookie by visiting the Google ad and content network privacy policy at the following URL - <a href="http://www.google.com/privacy_ads.html">http://www.google.com/privacy_ads.html</a>.</li></ul>';
	$output .= '<p>These third-party ad servers or ad networks use technology to the advertisements and links that appear on [sitename] send directly to your browsers. They automatically receive your IP address when this occurs. Other technologies ( such as cookies, JavaScript, or Web Beacons ) may also be used by the third-party ad networks to measure the effectiveness of their advertisements and / or to personalize the advertising content that you see.</p>';
	$output .= '<p>[sitename] has no access to or control over these cookies that are used by third-party advertisers.</p>';
	$output .= '<p>You should consult the respective privacy policies of these third-party ad servers for more detailed information on their practices as well as for instructions about how to opt-out of certain practices. [sitename]\'s privacy policy does not apply to, and we cannot control the activities of, such other advertisers or web sites.</p>';
	$output .= '<p>If you wish to disable cookies, you may do so through your individual browser options. More detailed information about cookie management with specific web browsers can be found at the browser\'s respective websites.</p>';
	return $output;
}

function wp_insert_legal_get_default_terms_and_conditions() {
	$output = '<p>Welcome to [sitename]. If you continue to browse and use this website you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern [sitename]\'s relationship with you in relation to this website.</p>';
	$output .= '<p>The term [sitename] or \'us\' or \'we\' refers to the owner of the website. The term \'you\' refers to the user or viewer of our website.  The use of this website is subject to the following terms of use:</p>';
	$output .= '<ul>';
		$output .= '<li>The content of the pages of this website is for your general information and use only. It is subject to change without notice.</li>';
		$output .= '<li>Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law.</li>';
		$output .= '<li>Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</li>';
		$output .= '<li>This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</li>';
		$output .= '<li>All trademarks reproduced in this website, which are not the property of, or licensed to the operator, are acknowledged on the website.</li>';
		$output .= '<li>Unauthorized use of this website may give rise to a claim for damages and/or be a criminal offense.</li>';
		$output .= '<li>From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</li>';
		$output .= '<li>You may not create a link to this website from another website or document without [sitename]\'s prior written consent.</li>';
	$output .= '</ul>';
	return $output;
}

function wp_insert_legal_get_default_disclaimer() {
	$output = '<p>The information contained in this website is for general information purposes only. The information is provided by [sitename] and while we endeavour to keep the information up to date and correct, we make no representations or warranties of any kind, express or implied, about the completeness, accuracy, reliability, suitability or availability with respect to the website or the information, products, services, or related graphics contained on the website for any purpose. Any reliance you place on such information is therefore strictly at your own risk.</p>';
	$output .= '<p>In no event will we be liable for any loss or damage including without limitation, indirect or consequential loss or damage, or any loss or damage whatsoever arising from loss of data or profits arising out of, or in connection with, the use of this website.</p>';
	$output .= '<p>Through this website you are able to link to other websites which are not under the control of [sitename]. We have no control over the nature, content and availability of those sites. The inclusion of any links does not necessarily imply a recommendation or endorse the views expressed within them.</p>';
	$output .= '<p>Every effort is made to keep the website up and running smoothly. However, [sitename] takes no responsibility for, and will not be liable for, the website being temporarily unavailable due to technical issues beyond our control.</p>';
	return $output;
}

function wp_insert_legal_get_default_copyright_notice() {
	$output = '<p>This website and its content is copyright of [sitename] - &copy; [sitename] 2012. All rights reserved.</p>';
	$output .= '</p>Any redistribution or reproduction of part or all of the contents in any form is prohibited other than the following:</p>';
	$output .= '<ul>';
		$output .= '<li>you may print or download to a local hard disk extracts for your personal and non-commercial use only</li>';
		$output .= '<li>you may copy the content to individual third parties for their personal use, but only if you acknowledge the website as the source of the material</li>';
	$output .= '</ul>';
	$output .= '<p>You may not, except with our express written permission, distribute or commercially exploit the content. Nor may you transmit it or store it in any other website or other form of electronic retrieval system.</p>';
	return $output;
}
?>