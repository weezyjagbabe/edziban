<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.1.min.js"><\/script>')</script>

<script src="js/vendor/bootstrap-slider.js"></script>                   <!-- bootstrap slider plugin -->
<script src="js/vendor/jquery.sparkline.min.js"></script>
<!-- small charts plugin -->


<script src="bootstrap/js/bootstrap.min.js"></script>

<script src="vendors/datatables/js/jquery.dataTables.min.js"></script>

<script src="vendors/datatables/dataTables.bootstrap.js"></script>
<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script src="js/custom.js"></script>
<script src="js/tables.js"></script>
<!-- Begin calender scripts -->
<?php
	if ( $pageName == 'Calender' ) 
	{
		?>
	        <script src='js/vendor/jquery-ui-1.10.2.custom.min.js'></script>        <!-- jquery ui dragging -->
	        <script src='js/vendor/fullcalendar.min.js'></script>                   <!-- fullcalendar plugin -->
	
	        <script>
	
	        	$(function () 
	        	{
	            	/* initialize the external events */
	            	function externalEvents() 
	            	{
	                	$('#external-events div.external-event').each(function() 
	                	{
	                    	// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
	                    	// it doesn't need to have a start or end
	                    	var eventObject = 
	                    	{
	                        	title: $.trim($(this).text()) // use the element's text as the event title
	                    	};
	                    
	                    	// store the Event Object in the DOM element so we can get to it later
	                    	$(this).data('eventObject', eventObject);
	                    
	                    	// make the event draggable using jQuery UI
	                    	$(this).draggable(
	                    	{
	                        	zIndex: 999,
	                        	revert: true,      // will cause the event to go back to its
	                        	revertDuration: 0,  //  original position after the drag
	                        	appendTo: 'body',
	                        	containment: 'window',
	                        	scroll: false,
	                        	helper: 'clone'
	                    	});
	                
	                	});
	            	};
	
	            	/* initialize the calendar */
	            
	            	function calInit() 
	            	{
	                	$('#calendar').fullCalendar(
	                	{
	                    	header: 
	                    	{
	                        	left: '',
	                        	center: 'title',
	                        	right: 'month,agendaWeek,agendaDay prev,today,next'
	                    	},
	                    	
	                    	editable: true,
	                    	droppable: true, // this allows things to be dropped onto the calendar !!!
	                    	drop: function(date, allDay) 
	                    	{
	                    		// this function is called when something is dropped
	                        	// retrieve the dropped element's stored Event Object
	                        	var originalEventObject = $(this).data('eventObject');
	                        
	                        	// we need to copy it, so that multiple events don't have a reference to the same object
	                        	var copiedEventObject = $.extend({}, originalEventObject);
	                        
	                        	// assign it the date that was reported
	                        	copiedEventObject.start = date;
	                        	copiedEventObject.allDay = allDay;
	                        
	                        	// render the event on the calendar
	                        	// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
	                        	$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
	                        
	                        	// is the "remove after drop" checkbox checked?
	                        	if ($('#drop-remove').is(':checked')) 
	                        	{
	                            	// if so, remove the element from the "Draggable Events" list
	                            	$(this).remove();
	                        	}
	                    	}
	                	});
	                	externalEvents();
	            	};
	
	            	function newEvent() 
	            	{
	                	if($('#newEventName').val() != '') 
	                	{
	                    	var event_name = $('#newEventName').val();
	                    	$('#external-events p').before('<div class="external-event"><input id="'+event_name+'" class="css-checkbox" type="checkbox"/><label for="'+event_name+'" class="css-label">'+event_name+ ' ' + '</label>');
	                    	externalEvents();
	                    	deleteEvent();
	                    	checkChecked();
	                    	$('#newEventName').val('');
	                	} 
	                	else 
	                	{
	                    	displayError();
	                	}
	            	};
	
	            	function displayError() 
	            	{
	                $('#alertBlock').remove();
	                $('#newEventName').after('<span class="help-block" id="alertBlock">'
	                        +'<div class="alert alert-error" id="event-error">'
	                            + '<button type="button" class="close" data-dismiss="alert">&times;</button>'
	                            + '<strong>Oh snap!</strong> You must fill the event name.'
	                        + '</div>'
	                    +'</span>');
	                $('#alertBlock').delay('3500').fadeOut(700,function() {
	                    $(this).remove();
	                });
	            };
	
	            function checkChecked() 
	            {
	                
	                $('.external-event input:checkbox').click(function() 
	                {
	                    var all_checkboxes = $('.external-event input[type="checkbox"]:checked');
	
	                    if($(this).is(':checked'))
	                    {
	                        $('#deleteEvent').removeClass('disabled');
	                    }
	
	                    if (all_checkboxes.length == 0)
	                    {
	                        $('#deleteEvent').addClass('disabled'); 
	                    }
	                });      
	            };
	
	            function deleteEvent() 
	            {
	                var all_checkboxes = $('.external-event input[type="checkbox"]:checked');
	                
	                all_checkboxes.parent().fadeOut(300, function()
	                {
	                    $(this).remove()
	                });
	            };
	
	            calInit();
	            checkChecked();
	
	            $('#addNewEvent').click(function()
	            {
	                newEvent();
	                return false;
	            });
	            
	            $('#newEventName').keypress(function(e)
	            {
	                if(e.which == 13) 
	                { 
	                    newEvent();
	                    return false;
	                }
	            });
	
	            $('#deleteEvent').click(function()
	            {
	                deleteEvent();
	                $('#deleteEvent').addClass('disabled'); 
	            });
	        })
	
	        </script>		
		<?php
	}
?>
<!-- End calender scripts -->

<script src="js/vendor/jquery.flot.min.js"></script>                    <!-- charts plugin -->
<script src="js/vendor/jquery.flot.resize.min.js"></script>             <!-- charts plugin / resizing extension -->
<script src="js/vendor/jquery.flot.pie.min.js"></script>                <!-- charts plugin / pie chart extension -->
<script src="js/vendor/wysihtml5-0.3.0_rc2.min.js"></script>            <!-- wysiwyg plugin -->
<script src="js/vendor/bootstrap-wysihtml5-0.0.2.min.js"></script>      <!-- wysiwyg plugin / bootstrap extension -->
<script src="js/vendor/bootstrap-tags.js"></script>                     <!-- multivalue input tags -->
<script src="js/vendor/raphael.2.1.0.min.js"></script>                  <!-- vector graphic plugin / for justgage.js -->
<script src="js/vendor/jquery.animate-shadow-min.js"></script>          <!-- shadow animation plugin -->
<script src="js/vendor/justgage.js"></script>                           <!-- justgage plugin -->
<script src="js/vendor/bootstrap-multiselect.js"></script>              <!-- multiselect plugin -->
<script src="js/vendor/bootstrap-datepicker.js"></script>               <!-- datepicker plugin -->
<script src="js/vendor/bootstrap-colorpicker.js"></script>              <!-- colorpicker plugin -->
<script src="js/vendor/parsley.min.js"></script>                        <!-- parsley validator plugin -->
<script src="js/vendor/formToWizard.js"></script>                       <!-- form wizard plugin -->
<script src="js/vendor/bootstrap-editable.min.js"></script>             <!-- editable fields plugin -->
<script src="js/thecm.min.js"></script>                             <!-- main project js file -->

<!-- Begin add content scripts -->
<?php
	if ( $pageName == 'Add Blog' || $pageName == 'Add Team Member' || $pageName == 'AboutUS Contents' || $pageName = 'Add HomePage Contents' )
	{
		?>
			<script>
		        $(function () 
		        {
		            $('#uniqueSelect').multiselect();
		
		            $('#multipleSelect').multiselect({
		                buttonText: function(options, select) 
		                {
		                    if (options.length == 0) 
		                    {
		                        return 'None selected <b class="caret"></b>';
		                    }
		                    else if (options.length > 1) 
		                    {
		                        return options.length + ' selected <b class="caret"></b>';
		                    }
		                    else {
		                        var selected = '';
		                        options.each(function() 
		                        {
		                            selected += $(this).text() + ', ';
		                        });
		                        return selected.substr(0, selected.length -2) + ' <b class="caret"></b>';
		                    }
		                },
		            });
		
		            $('#datepickerField').datepicker();
		            $('#hexColorPicker').colorpicker();
		            $('#rgbColorPicker').colorpicker({
		                format: 'rgb'
		            });
		
		            $( "#fileselectbutton" ).click(function(e)
		            {
		                $( "#inputFile" ).trigger("click");
		            });  
		
		            $( "#inputFile" ).change(function(e){
		                var val = $(this).val();
		                var file = val.split(/[\\/]/);
		                $( "#filename" ).val(file[file.length-1]);
		            });
                    $( "#fileselectbutton1" ).click(function(e)
                    {
                        $( "#inputFile1" ).trigger("click");
                    });

                    $( "#inputFile1" ).change(function(e){
                        var val = $(this).val();
                        var file = val.split(/[\\/]/);
                        $( "#filename1" ).val(file[file.length-1]);
                    });
		
		        })
	        </script>
		<?php	
	}
?>
<!-- End add content scripts -->
<script>
    $(function () {
        /* realtime chart */

        var container = $("#realTimeChart");

        // Determine how many data points to keep based on the placeholder's initial size;
        // this gives us a nice high-res plot while avoiding more than one point per pixel.

        var maximum = container.outerWidth() / 2 || 300;

        //

        var data = [];

        function getRandomData() {

            if (data.length) {
                data = data.slice(1);
            }

            while (data.length < maximum) {
                var previous = data.length ? data[data.length - 1] : 50;
                var y = previous + Math.random() * 10 - 5;
                data.push(y < 0 ? 0 : y > 100 ? 100 : y);
            }

            // zip the generated y values with the x values

            var res = [];
            for (var i = 0; i < data.length; ++i) {
                res.push([i, data[i]])
            }

            return res;
        }

        //

        series = [{
            data: getRandomData(),
            lines: {
                fill: true,
                fillColor: '#e2e2e2'
            },
            color: '#b2b2b2'
        }];

        //

        var plot = $.plot(container, series, {
            grid: {
                color: 'rgba(0,0,0, .3)',
                borderColor: 'rgba(0,0,0, .3)',
                borderWidth: 1,
                minBorderMargin: 20,
                labelMargin: 10,
                backgroundColor: {
                    colors: ["#fff", "#e2e2e2"]
                },
                margin: {
                    top: 8,
                    bottom: 20,
                    left: 20
                },
                markings: function(axes) {
                    var markings = [];
                    var xaxis = axes.xaxis;
                    for (var x = Math.floor(xaxis.min); x < xaxis.max; x += xaxis.tickSize * 2) {
                        markings.push({ xaxis: { from: x, to: x + xaxis.tickSize }, color: "rgba(232, 232, 255, 0.2)" });
                    }
                    return markings;
                }
            },
            xaxis: {
                tickFormatter: function() {
                    return "";
                }
            },
            yaxis: {
                min: 0,
                max: 110
            },
            legend: {
                show: true
            }
        });

        // Create the demo X and Y axis labels

        var yaxisLabel = $("<div class='axisLabel yaxisLabel'></div>")
            .text("Response Time (ms)")
            .appendTo(container);

        // Since CSS transforms use the top-left corner of the label as the transform origin,
        // we need to center the y-axis label by shifting it down by half its width.
        // Subtract 20 to factor the chart's bottom margin into the centering.

        yaxisLabel.css("margin-top", -20);

        // Update the random dataset at 25FPS for a smoothly-animating chart

        setInterval(function updateRandom() {
            series[0].data = getRandomData();
            plot.setData(series);
            plot.draw();
        }, 40);

        // pie chart 

        var dataPie = [],
        pieSeries = Math.floor(Math.random() * 6) + 3;

        for (var i = 0; i < pieSeries; i++) {
            dataPie[i] = {
                label: "Series" + (i + 1),
                data: Math.floor(Math.random() * 100) + 1
            }
        }

        $.plot('#firstPieChart', dataPie, {
            series: {
            pie: {
                show: true,
                radius: 1,
                label: {
                    show: true,
                    radius: 1,
                    formatter: labelFormatter,
                    background: {
                        opacity: 0.8
                    }
                }
            }
            },
            legend: {
                show: false
            }
        });

        $.plot('#thirdPieChart', dataPie, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true
                }
            },
            legend: {
                show: true
            }
        });

        // A custom label formatter used by several of the plots
        function labelFormatter(label, series) 
        {
            return "<div style='font-size:8pt; text-align:center; padding:2px; color:white;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
        };

    })
</script>