<?php

/**
 * Created by PhpStorm.
 * User: Yury Katkov
 */
class ChapTimeline extends SMWResultPrinter {

	public $data;
	/**
	 * @var SMWQueryResult
	 */
	protected $mQueryResult;

	/**
	 * @see SMWResultPrinter::handleParameters
	 *
	 * @since 1.6.3
	 *
	 * @param array $params
	 * @param $outputmode
	 */
	protected function handleParameters( array $params, $outputmode ) {
		parent::handleParameters( $params, $outputmode );
	}


	/**
	 * Return serialised results in specified format.
	 * Implemented by subclasses.
	 */
	protected function getResultText( SMWQueryResult $queryResult, $outputmode ) {

		/** @var $wgParser Parser */
		global $wgOut, $wgParser;

//				$wgOut->addScriptFile("http://www.google.com/jsapi");
		/*$wgOut->addScriptFile("$wgScriptPath/extensions/ChapTimeline/js/timeline.js");
		$wgOut->addScriptFile("$wgScriptPath/extensions/ChapTimeline/js/timeline-locales.js");
		$wgOut->addScriptFile("$wgScriptPath/extensions/ChapTimeline/js/ext.ChapTimeline.core.js");
		$wgOut->addLink(array('rel'=>"stylesheet",
				"type"=>"text/css",
				"href"=>"$wgScriptPath/extensions/ChapTimeline/css/timeline.css"));*/

		SMWOutputs::requireResource( 'ext.chapTimeline.main' );

		if ( ! $this->paramsValid( $queryResult ) ) {
			return "";
		}
		$this->data = $this->getRawData( $queryResult, $outputmode );

		$this->createCaptions();
		$this->prepareDates();
		return $this->getFormatOutput( $this->data );
	}

	/**
	 * @see SMWResultPrinter::getParamDefinitions
	 *
	 * @since 1.8
	 *
	 * @param $definitions array of IParamDefinition
	 *
	 * @return array of IParamDefinition|array
	 */
	public function getParamDefinitions( array $definitions ) {
		$params = parent::getParamDefinitions( $definitions );

		$params['startproperty'] = array( 'message' => 'srf-paramdesc-chaptimeline-startproperty', 'default' => '' );
		$params['endproperty'] = array( 'message' => 'srf-paramdesc-chaptimeline-endproperty', 'default' => '' );
		$params['template'] = array( 'message' => 'srf-paramdesc-chaptimeline-template', 'default' => '' );
		$params['width'] = array( 'message' => 'srf-paramdesc-chaptimeline-width', 'default' => '100%' );
		$params['height'] = array( 'message' => 'srf-paramdesc-chaptimeline-height', 'default' => '300px' );
		$params['style'] = array( 'message' => 'srf-paramdesc-chaptimeline-style', 'default' => 'box' );
		$params['cluster'] = array( 'message' => 'srf-paramdesc-chaptimeline-cluster', 'default' => false, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['showNavigation'] = array( 'message' => 'srf-paramdesc-chaptimeline-showNavigation', 'default' => false, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['zoomable'] = array( 'message' => 'srf-paramdesc-chaptimeline-zoomable', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['zoomMax'] = array( 'message' => 'srf-paramdesc-chaptimeline-zoomMax', 'default' => '' );
		$params['zoomMin'] = array( 'message' => 'srf-paramdesc-chaptimeline-zoomMin', 'default' => '' );
		$params['showMinorLabels'] = array( 'message' => 'srf-paramdesc-chaptimeline-showMinorLabels', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['showMajorLabels'] = array( 'message' => 'srf-paramdesc-chaptimeline-showMajorLabels', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['showCurrentTime'] = array( 'message' => 'srf-paramdesc-chaptimeline-showCurrentTime', 'default' => false, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['showCustomTime'] = array( 'message' => 'srf-paramdesc-chaptimeline-showCustomTime', 'default' => false, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['stackEvents'] = array( 'message' => 'srf-paramdesc-chaptimeline-stackEvents', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['minHeight'] = array( 'message' => 'srf-paramdesc-chaptimeline-minHeight', 'default' => '0' );
		$params['min'] = array( 'message' => 'srf-paramdesc-chaptimeline-min', 'default' => '' );
		$params['max'] = array( 'message' => 'srf-paramdesc-chaptimeline-max', 'default' => '' );
		$params['start'] = array( 'message' => 'srf-paramdesc-chaptimeline-start', 'default' => '' );
		$params['end'] = array( 'message' => 'srf-paramdesc-chaptimeline-end', 'default' => '' );
		$params['axisOnTop'] = array( 'message' => 'srf-paramdesc-chaptimeline-axisOnTop', 'default' => false, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['animateZoom'] = array( 'message' => 'srf-paramdesc-chaptimeline-animateZoom', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		$params['animate'] = array( 'message' => 'srf-paramdesc-chaptimeline-animate', 'default' => true, 'type' => 'boolean', 'allowed values' => array( false, true ), );
		return $params;
	}


	/**
	 * @param SMWQueryResult $queryResult
	 * @param $outputmode
	 * @return array
	 */
	private function getRawData( SMWQueryResult $queryResult, $outputmode ) {
		$data = array();
		while ( $row = $queryResult->getNext() ) { // Loop over the objects (pages)
			/**
			 * @var $row SMWResultArray[]
			 */
			$subjectLabel = '';
			foreach ( $row as $field ) { //loop over properties (starting from pagename and all printouts)
				$subjectLabel = $field->getResultSubject()->getTitle()->getFullText();
				$propertyLabel = $field->getPrintRequest()->getLabel();

				while ( ( $object = $field->getNextDataValue() ) != false ) {
					$data[$subjectLabel][$propertyLabel] = $object;
				}
			}
			//we won't display event without start date
			if ( ! isset ( $data[$subjectLabel][$this->params['startproperty']] ) ) {
				unset ( $data[$subjectLabel] );
			}
		}
		return $data;
	}

	/**
	 * generates the caption of the event based on either template set by 'template' parameter or by some default template
	 * modifies $this->data
	 */
	private function createCaptions() {
		foreach ( $this->data as $subj => $props ) { //loop over pages
			if ( $this->params['template'] != '' ) {
				$this->data[$subj]["content"] = $this->generateTemplateCaption( $subj );
			} else {
				$this->data[$subj]["content"] = $this->generateDefaultCaption( $subj );
			}
		}
	}

	/**
	 * Passes data to js
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	protected function getFormatOutput( $data ) {
		global $wgLanguageCode;

		// The generated ID is to distinguish similar instances of the same
		// printer that can appear within the same page
		static $statNr = 0;
		$ID = 'chap-timeline-' . ++$statNr;

		// Used to set that the output and being treated as HTML (opposed to plain wiki text)
		$this->isHTML = true;

		// Correct escaping is vital to minimize possibilites of malicious code snippets
		// and also a coherent string evalution therefore it is recommended
		// that data transferred to the JS plugin is JSON encoded

		// Assign the ID to make a data instance readly available and distinguishable
		// from other content within the same page

		$options = array(
			"width" => $this->params['width'],
			"height" => $this->params['height'],
			"style" => $this->params['style'], //sometimes we'll support style=box
			"cluster" => $this->params['cluster'],
			"showNavigation" => $this->params['showNavigation'],
			"zoomable" => $this->params['zoomable'],
			"zoomMax" => $this->params['zoomMax'],
			"zoomMin" => $this->params['zoomMin'],
			"showMinorLabels" => $this->params['showMinorLabels'],
			"showMajorLabels" => $this->params['showMajorLabels'],
			"showCurrentTime" => $this->params['showCurrentTime'],
			"showCustomTime" => $this->params['showCustomTime'],
			"stackEvents" => $this->params['stackEvents'],
			"minHeight" => $this->params['minHeight'],
			"min" => $this->params['min'],
			"max" => $this->params['max'],
			"start" => $this->params['start'],
			"end" => $this->params['end'],
			"axisOnTop" => $this->params['axisOnTop'],
			"animateZoom" => $this->params['animateZoom'],
			"animate" => $this->params['animate'],
			"locale" => $wgLanguageCode
		);
		$requireHeadItem = array( $ID => FormatJson::encode( $data ), $ID . "-options" => FormatJson::encode( $options ) );
		SMWOutputs::requireHeadItem( $ID, Skin::makeVariablesScript( $requireHeadItem ) );

		// Add two elements a outer wrapper that is assigned a class which the JS plugin
		// can select and will fetch all instances of the same result printer and an innner
		// container which is set invisible (display=none) for as long as the JS plugin
		// holds the content hidden. It is normally the place where the "hard work"
		// is done hidden from the user until it is ready.
		// The JS plugin can prepare the output within this container without presenting
		// unfinished visual content, to avoid screen clutter and improve user experience.
		return Html::rawElement( 'div', array( 'class' => 'chap-timeline' ), Html::element( 'div', array( 'id' => $ID, 'class' => 'container', ), null ) );
	}

	/**
	 * @param $subj string . Object for which we need to generate caption
	 * @return string text with template call
	 */
	private function generateTemplateCaption( $subj ) {
		global $wgParser, $wgOut;

		$templateCall = '{{' . $this->params['template'] . "\n";
		foreach ( $this->data[$subj] as $p => $v ) {
			/** @var $v SMWDataValue */
			$templateCall .= '|' . $v->getWikiValue();
		}
		$templateCall .= '}}';

		$text = $wgParser->replaceVariables( $templateCall );
		$text = $wgParser->parse( $text, $wgOut->getTitle(), new ParserOptions(), null, null, null )->getText();
		return $text;
	}

	/**
	 * @param $subj string . Object for which we need to generate caption
	 */
	private function generateDefaultCaption( $subj ) {
		$caption = '';

		foreach ( $this->data[$subj] as $p => $v ) {
			/** @var $v SMWDataValue */
			if ( $p == "" ) {
				$pagename = $v->getShortWikiText();
				$caption .= Html::element( "span", array( "class" => "chap-timeline-caption-head", ), "[[$pagename]]" );
			} else {
				$caption .= Html::openElement( "div", array( "class" => "chap-timeline-caption-propvaluepain" ) );
				$caption .= Html::element( "span", array( "class" => "chap-timeline-caption-propname" ), $p );
				$caption .= Html::element( "span", array( "class" => "chap-timeline-caption-propvalue" ), $v->getShortWikiText() );
				$caption .= Html::closeElement( "div" );
			}
			$caption .= "\n";

		}

		global $wgParser, $wgOut;
		$caption = $wgParser->replaceVariables( $caption );
		$caption = $wgParser->parse( $caption, $wgOut->getTitle(), new ParserOptions(), null, null, null )->getText();

		return $caption;
	}

	/**
	 * prepares the dates for javascript: search for param['startproperty']and param['endproperty'] properties and convert them
	 * to arrays that are easy to read with JS. These arrays are put in $data['start'] and $data['end']
	 * respectively
	 * TODO add checks like $object->getTypeID()=="_dat"
	 */
	private function prepareDates() {
		foreach ( $this->data as $subj => $props ) {
			foreach ( array( 'start', 'end' ) as $i ) {
				$di = $this->data[$subj][$this->params["${i}property"]]->getDataItem();
				unset( $this->data[$subj][$this->params["${i}property"]] );

				$this->data[$subj][$i] = array( 'precision' => $di->getPrecision(), //FIXME with precision it's possible to draw months and years
					'year' => $di->getYear(), 'month' => $di->getMonth(), 'day' => $di->getDay(), 'hours' => $di->getHour(), 'minutes' => $di->getMinute(), 'seconds' => $di->getSecond() );
				//if there's no enddate
				if ( ! isset( $this->data[$subj][$this->params["endproperty"]] ) ) {
					break;
				}
			}
		}
	}

	private function paramsValid( SMWQueryResult $queryResult ) {
		// startproperty and endproperty must be of type _dat
		$printouts = $queryResult->getQuery()->getExtraPrintouts();
		foreach ( $printouts as $printout ) {
			/**
			 * @var $printout SMWPrintRequest
			 */
			if ( ( $printout->getLabel() == $this->params['startproperty'] || $printout->getLabel() == $this->params['endproperty'] ) && $printout->getTypeID() != "_dat" ) {
				return false;
			}
		}
		return true;
	}


	/**
	 * @see SMWIResultPrinter::getName
	 *
	 * @return string
	 */
	public function getName() {
		return wfMessage( 'srf_printername_' . $this->mFormat )->text();
	}
}
