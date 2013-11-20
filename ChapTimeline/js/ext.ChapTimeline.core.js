/**
 * Created with JetBrains PhpStorm.
 * User: ganqqwerty
 * Date: 10/11/13
 * Time: 7:33 PM
 * To change this template use File | Settings | File Templates.
 */
(function ($) {
	// Use EcmaScript 5 to improve code quality and check with jshint/jslint
	// if the code adheres standard coding conventions

	// Strict mode eliminates some JavaScript pitfalls
	'use strict';

	// Passing jshint
	/*global mw:true */

	/**
	 * Document ready instance
	 * @since 1.8
	 * @type Object
	 */
	$(document).ready(function () {

		$('.chap-timeline').each(function () {
			// Ensure variables have only local scope otherwise leaked content might
			// cause issues for other plugins
			var $this = $( this );

			// Find the container instance that was created by the PHP output
			// and store it as "container" variable which all preceding steps
			// working on a localized instance
			var container = $this.find( '.container' );

			// Find the ID that connects to the current instance with the published data
			var ID = container.attr( 'id' );

			// Fetch the stored data with help of mw.config.get() method and the current instance ID
			// @see http://www.mediawiki.org/wiki/ResourceLoader/Default_modules#mediaWiki.config
			var json = mw.config.get( ID );

			var timeline;

			google.load("visualization", "1");

			// Set callback to run when API is loaded
			google.setOnLoadCallback(drawVisualization);

			// Called when the Visualization API is loaded.
			function drawVisualization() {
				// Create and populate a data table.
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
					data.addRow([new Date(start.year, start.month, start.day, start.hours, start.minutes, start.seconds),
						(end!=null) ? new Date(end.year, end.month, end.day, end.hours, end.minutes, end.seconds) : null,
						content
					]);

				}
				// specify options
				var options =  jQuery.parseJSON(mw.config.get(ID+'-options'));

				// Instantiate our timeline object.
				timeline = new links.Timeline(document.getElementById(ID));


				// Draw our timeline with the created data and options
				timeline.draw(data, options);
			}
		});
	});
})(jQuery);