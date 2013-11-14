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
    'url' => '',
    'descriptionmsg' => 'ChapTimeline-desc',
);

///* Resource modules */
//we don't use ResourceLoader since we're dependent on Google API with cannot be loaded with ResourceLoader

/* Message Files */
$wgExtensionMessagesFiles['ChapTimeline'] = dirname( __FILE__ ) . '/ChapTimeline.i18n.php';

/* Autoload classes */
$wgAutoloadClasses['ChapTimeline'] = dirname( __FILE__ ) . '/ChapTimeline.class.php';

global $srfgFormats, $smwgResultFormats;
$srfgFormats[] = 'chap-timeline';
$smwgResultFormats['chap-timeline'] = 'ChapTimeline';
