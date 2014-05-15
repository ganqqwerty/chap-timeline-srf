<?php
/* Language file for mediawiki extension ChapTimeline.i18n */

$messages = array();

/* English */
$messages['en'] = array(
		'chaptimeline-desc' => 'displays nice timeline',
		'chap-timeline' => 'chap-timeline',
		'srf-paramdesc-chaptimeline-startproperty' => 'Property that stores starting date of an object',
		'srf-paramdesc-chaptimeline-endproperty' => 'Property that stores ending date of an object',
		'srf-paramdesc-chaptimeline-template' => 'Name of the template that will be used to format the text inside the eventbox',
		'srf-paramdesc-chaptimeline-width' => 'The width of the timeline in pixels or as a percentage.',
		'srf-paramdesc-chaptimeline-height' => 'The height of the timeline in pixels, as a percentage, or "auto". When the height is set to "auto", the height of the timeline is automatically adjusted to fit the contents. If not, it is possible that events get stacked so high, that they are not visible in the timeline. When height is set to "auto", a minimum height can be specified with the option minHeight.',
		'srf-paramdesc-chaptimeline-style' => 'Specifies the style for the timeline events. Choose from "dot" or "box". Note that the content of the events may contain additional html formatting. It is possible to implement custom styles using the method addItemType.',
		'srf-paramdesc-chaptimeline-cluster' => 'If true, events will be clustered together when zooming out. This keeps the Timeline clear and fast also with a larger amount of events. ',
		'srf-paramdesc-chaptimeline-showNavigation' => 'Show a navigation menu with buttons to move and zoom the timeline. The zoom buttons are only visible when option `zoomable` is true, and and move buttons are only visible when option `moveable` is true.',
		'srf-paramdesc-chaptimeline-zoomable' => 'If true, the timeline is zoomable.',
		'srf-paramdesc-chaptimeline-zoomMax' => 'Set a maximum zoom interval for the visible range in milliseconds. It will not be possible to zoom out further than this maximum. Default value equals about 10000 years.',
		'srf-paramdesc-chaptimeline-zoomMin' => 'Set a minimum zoom interval for the visible range in milliseconds. It will not be possible to zoom in further than this minimum.',
		'srf-paramdesc-chaptimeline-showMinorLabels' => 'By default, the timeline shows both minor and major date labels on the horizontal axis. For example the minor labels show minutes and the major labels show hours. When showMinorLabels is false, no minor labels are shown. When both showMajorLabels and showMinorLabels are false, no horizontal axis will be visible.',
		'srf-paramdesc-chaptimeline-showMajorLabels' => 'By default, the timeline shows both minor and major date labels on the horizontal axis. For example the minor labels show minutes and the major labels show hours. When showMajorLabels is false, no major labels are shown.	',
		'srf-paramdesc-chaptimeline-showCurrentTime' => 'If true, the timeline shows a red, vertical line displaying the current time. This time can be synchronized with a server via the method setCurrentTime.',
		'srf-paramdesc-chaptimeline-showCustomTime' => 'If true, the timeline shows a blue vertical line displaying a custom time. This line can be dragged by the user. The custom time can be utilized to show a state in the past or in the future. When the custom time bar is dragged by the user, an event is triggered, on which the contents of the timeline can be changed in to the state at that moment in time.',
		'srf-paramdesc-chaptimeline-stackEvents' => 'If true, the events are stacked above each other to prevent overlapping events. This option cannot be used in combination with grouped events.',
		'srf-paramdesc-chaptimeline-minHeight' => 'Specifies a minimum height for the Timeline in pixels. Useful when height is set to "auto".',
		'srf-paramdesc-chaptimeline-min' => 'Set a minimum Date for the visible range. It will not be possible to move beyond this minimum.',
		'srf-paramdesc-chaptimeline-max' => 'Set a maximum Date for the visible range. It will not be possible to move beyond this maximum.',
		'srf-paramdesc-chaptimeline-start' => 'The initial start date for the axis of the timeline. If not provided, the earliest date present in the events is taken as start date.',
		'srf-paramdesc-chaptimeline-end' => 'The initial start date for the axis of the timeline. If not provided, the earliest date present in the events is taken as start date.',
		'srf-paramdesc-chaptimeline-axisOnTop' => 'If false (default), the horizontal axis is drawn at the bottom. If true, the axis is drawn on top.',
		'srf-paramdesc-chaptimeline-animateZoom' => 'When true, events are moved animated when zooming the Timeline. This looks cool, but does require more computational power.',
		'srf-paramdesc-chaptimeline-animate' => 'When true, events are moved animated when resizing or moving them. This is very pleasing for the eye, but does require more computational power.',
);

/* Russian */
$messages['ru'] = array(
		'chaptimeline-desc' => 'displays nice timeline',
		'chap-timeline' => 'chap-timeline',
		'srf-paramdesc-chaptimeline-startproperty' => 'Property that stores starting date of an object',
		'srf-paramdesc-chaptimeline-endproperty' => 'Property that stores ending date of an object',
		'srf-paramdesc-chaptimeline-template' => 'Name of the template that will be used to format the text inside the eventbox',
		'srf-paramdesc-chaptimeline-width' => '',
		'srf-paramdesc-chaptimeline-height' => '',
		'srf-paramdesc-chaptimeline-style' => '',
		'srf-paramdesc-chaptimeline-cluster' => '',
		'srf-paramdesc-chaptimeline-showNavigation' => '',
		'srf-paramdesc-chaptimeline-zoomable' => '',
		'srf-paramdesc-chaptimeline-zoomMax' => '',
		'srf-paramdesc-chaptimeline-zoomMin' => '',
		'srf-paramdesc-chaptimeline-showMinorLabels' => '',
		'srf-paramdesc-chaptimeline-showMajorLabels' => '',
		'srf-paramdesc-chaptimeline-showCurrentTime' => '',
		'srf-paramdesc-chaptimeline-showCustomTime' => '',
		'srf-paramdesc-chaptimeline-stackEvents' => '',
		'srf-paramdesc-chaptimeline-minHeight' => '',
		'srf-paramdesc-chaptimeline-min' => '',
		'srf-paramdesc-chaptimeline-max' => '',
		'srf-paramdesc-chaptimeline-start' => '',
		'srf-paramdesc-chaptimeline-end' => '',
		'srf-paramdesc-chaptimeline-axisOnTop' => '',
		'srf-paramdesc-chaptimeline-animateZoom' => '',
		'srf-paramdesc-chaptimeline-animate' => '',
);
