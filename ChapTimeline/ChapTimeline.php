<?php
/**
 * Initialization file for the ChapTimeline extension.
 *
 * @file ChapTimeline.php
 * @ingroup ChapTimeline
 *
 * @licence GNU GPL v3
 * @author WikiVote! ltd. < http://wikivote.ru >
 */

global $srfgFormats, $smwgResultFormats, $wgVersion;

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.20', '<' ) ) {
	die( '<b>Error:</b> This version of ChapTimeline requires MediaWiki 1.20 or above.' );
}

/* Credits page */
$wgExtensionCredits['specialpage'][] = array(
    'path' => __FILE__,
    'name' => 'ChapTimeline',
    'version' => '0.1',
    'author' => 'Wikivote! ltd',
    'url' => 'https://www.mediawiki.org/wiki/Extension:ChapTimeline',
    'descriptionmsg' => 'chaptimeline-desc',
);

/* Resource modules */
$wgResourceModules['ext.chapTimeline.main'] = array(
	'localBasePath' => dirname( __FILE__ ) . '/',
	'remoteExtPath' => 'ChapTimeline/',
	'group' => 'ext.ChapTimeline',
	'scripts' => array('js/timeline-locales.js', 'js/timeline.js', 'js/ext.ChapTimeline.core.js'),
	'styles' => 'css/timeline.css',
	'dependencies' => array(
		'ext.srf',
		'ext.srf.util',
	)
);

/* Message Files */
$wgExtensionMessagesFiles['ChapTimeline'] = dirname( __FILE__ ) . '/ChapTimeline.i18n.php';

/* Autoload classes */
$wgAutoloadClasses['ChapTimeline'] = dirname( __FILE__ ) . '/ChapTimeline.class.php';

$srfgFormats[] = 'chap-timeline';
$smwgResultFormats['chap-timeline'] = 'ChapTimeline';
