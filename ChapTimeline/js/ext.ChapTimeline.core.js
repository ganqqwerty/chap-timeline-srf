/**
 * Created with JetBrains PhpStorm.
 * User: ganqqwerty
 * Date: 10/11/13
 * Time: 7:33 PM
 * To change this template use File | Settings | File Templates.
 */

(function($, srf) {

	'use strict';

	/*global chap:true, mw:true, google:true*/
	/**
	 * Module for formats extensions
	 * @since 1.8
	 * @type Object*/

	srf.formats = srf.formats || {};

	/**
	 * Base constructor for objects representing a d3 instance
	 * @since 1.8
	 * @type Object*/

	srf.formats.chap = function() {};

	//Implementation ---------------------------------------------------------------------------------------------------

	srf.formats.chap.prototype = {
		chaptimeline: function (context) {
			return context.each(function () {

				//Class scope variables---------------------------------------------------------------------------------

				var self = this;
				var $this = $(this);

				// Find the container instance that was created by the PHP output
				// and store it as "container" variable which all preceding steps
				// working on a localized instance
				var container = $this.find('.container');

				// Find the ID that connects to the current instance with the published data
				var ID = container.attr('id');

				// Fetch the stored data with help of mw.config.get() method and the current instance ID
				// @see http://www.mediawiki.org/wiki/ResourceLoader/Default_modules#mediaWiki.config
				var json = mw.config.get(ID);

				var timeline;

				//Class functions --------------------------------------------------------------------------------------

				self.initData = function() {

					var data = new google.visualization.DataTable();
					data.addColumn('datetime', 'start');
					data.addColumn('datetime', 'end');
					data.addColumn('string', 'content');

					var json = mw.config.get(ID);
					// Parse the fetched json string and convert it back into objects/arrays
					var phpData = typeof json === 'string' ? jQuery.parseJSON(json) : json;

					for (var phpEvent in phpData) {
						var start = phpData[phpEvent].start;
						var end = phpData[phpEvent].end;
						var content = phpData[phpEvent].content;
						data.addRow([new Date(start.year, start.month-1, start.day, start.hours, start.minutes, start.seconds),
							(end != null) ? new Date(end.year, end.month-1, end.day, end.hours, end.minutes, end.seconds) : null,
							content
						]);

					}
					// specify options
					var options = jQuery.parseJSON(mw.config.get(ID + '-options'));

                    options.start = Date.parse(options.start);
                    options.end = Date.parse(options.end);
					// Instantiate our timeline object.
					timeline = new links.Timeline(document.getElementById(ID));


					// Draw our timeline with the created data and options
					timeline.draw(data, options);

				};

				//Class entry point ------------------------------------------------------------------------------------
				self.initData();

			});
		}
	};

	//Global entry point -----------------------------------------------------------------------------------------------
	var util = new srf.util();
	var chap = new srf.formats.chap;

	//Autorun
	$.getScript('https://www.google.com/jsapi', function() {

		google.load('visualization', '1', {"callback": function() {
			console.log('Google JSApi loaded and executed.');
			$( '.chap-timeline' ).each(function() {
				chap.chaptimeline( $( this ) );
			});
		}});

	});

})(jQuery, semanticFormats);