/**
 * iPanelThemes Plugin Framework
 *
 * This is a jQuery plugin which works on the plugin framework to populate the UI
 * Admin area
 *
 * Dependencies: TODO
 *
 * @author Swashata Ghosh <swashata@intechgrity.com>
 * @version 1.0.3
 */
(function($) {
	//Default Options
	var defaultOp = {

	};

	var wp_media_reference = {
		input : null,
		preview : null,
		download : null,
		self : null
	};

	var ipt_uif_wp_media_frame;

	$(window).on('resize', function() {
		methods.reinitTBAnchors();
	});

	//Methods
	var methods = {
		init : function(options) {
			var op = $.extend(true, {}, defaultOp, options); //No use right now
			var _parent = this;

			return this.each(function() {
				var self = $(this);

				//Init the help + delegate
				self.on('click', '.ipt_uif_msg', function(e) {
					methods.applyHelp.apply(this, [e]);
				});

				//Init the checkbox toggler
				self.find('.ipt_uif_checkbox_toggler').each(function() {
					methods.applyCheckboxToggler.apply(this);
				});

				//Init the spinner
				methods.applySpinner.apply(self.find('.ipt_uif_uispinner'));

				//Init the Slider
				self.find('.ipt_uif_slider').each(function() {
					methods.applySlider.apply(this);
				});

				//Init the Progressbar
				self.find('.ipt_uif_progress_bar').each(function() {
					methods.applyProgressBar.apply(this);
				});

				//Init the Icon Selector + delegated
				methods.applyIconSelector.apply(this);

				//Init the datepickers
				methods.applyDatePicker.apply(self.find('.ipt_uif_datepicker input.ipt_uif_text'));
				methods.applyDateTimePicker.apply(self.find('.ipt_uif_datetimepicker input.ipt_uif_text'));
				methods.applyDateTimeNowButton.apply(this);

				//Init the printElements + delegate
				methods.applyPrintElement.apply(this);

				//Init the font selector
				self.find('.ipt_uif_font_selector').each(function() {
					methods.applyFontSelector.apply(this);
				});

				//Init the theme selector
				self.find('.ipt_uif_theme_selector').each(function() {
					methods.applyThemeSelector.apply(this);
				});

				//Uploader
				self.find('.ipt_uif_upload').each(function() {
					methods.applyUploader.apply(this);
				});

				//Init the IRIR ColorPicker + delegate
				methods.applyIRIS.apply(this);

				//Init the conditional
				self.find('.ipt_uif_conditional_input').each(function() {
					methods.applyConditionalInput.apply(this);
				});
				self.find('.ipt_uif_conditional_select').each(function() {
					methods.applyConditionalSelect.apply(this);
				});

				//Init the collapsible
				self.find('.ipt_uif_collapsible').each(function() {
					methods.applyCollapsible.apply(this);
				});

				//Init the deleter + delegate
				self.on('click', '.wp-list-table a.delete', function(e) {
					methods.applyDeleteConfirm.apply(this, [e]);
				});

				//Init the Scroll
				self.find('.ipt_uif_scroll').each(function() {
					//methods.applyScrollBar.apply(this);
				});

				//Init the SDA
				self.find('.ipt_uif_sda').each(function() {
					methods.applySDA.apply(this);
				});

				//Init the Tabs
				self.find('.ipt_uif_tabs').each(function() {
					methods.applyTabs.apply(this, op);
				});

				//Init the Builder
				self.find('.ipt_uif_builder').each(function() {
					methods.applyBuilder.apply(this);
				});

			});
		},

		applyDeleteConfirm : function(e) {
			var self = $(this);
			e.preventDefault();
			$('<div>' + iptPluginUIFAdmin.L10n.delete_msg + '</div>').dialog({
				autoOpen : true,
				modal : true,
				minWidth : 400,
				closeOnEscape : true,
				title : iptPluginUIFAdmin.L10n.delete_title,
				buttons : {
					'Confirm' : function() {
						window.location.href = self.attr('href');
						$(this).dialog('close');
					},
					'Cancel' : function() {
						$(this).dialog('close');
					}
				},
				//appendTo : '.ipt_uif_common',
				create : function(event, ui) {
					$('body').addClass('ipt_uif_common');
				},
				close : function(event, ui) {
					$('body').removeClass('ipt_uif_common');
				}
			});
		},

		applyCheckboxToggler : function() {
			var selector = $($(this).data('selector')),
			self = $(this);
			self.on('change', function() {
				if(self.is(':checked')) {
					selector.prop('checked', true);
				} else {
					selector.prop('checked', false);
				}
			});

			selector.on('change', function() {
				self.prop('checked', false);
			});

			if(self.is(':checked')) {
				selector.prop('checked', true);
			}
		},

		applyFontSelector : function() {
			var select = $(this).find('select').eq(0);
			var preview = $(this).find('.ipt_uif_collapsible').eq(0);

			//Bind the change
			select.on('change keyup', function() {
				var selected = $(this).find('option:selected');
				var font_suffix = selected.data('fontinclude');
				var font_key = selected.val();
				var font_family = selected.text();

				//Attach the link
				if(!$('#ipt_uif_webfont_' + font_key).length) {
					$('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + font_suffix + '" id="ipt_uif_webfont_' + font_key + '" />').appendTo('head');
				}

				//Change the font family
				preview.css({fontFamily : font_family});
			});

			//Create the initial
			var selected = $(this).find('option:selected');
			var font_suffix = selected.data('fontinclude');
			var font_key = selected.val();
			var font_family = selected.text();

			//Attach the link
			if(!$('#ipt_uif_webfont_' + font_key).length) {
				$('<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=' + font_suffix + '" id="ipt_uif_webfont_' + font_key + '" />').appendTo('head');
			}

			//Change the font family
			preview.css({fontFamily : font_family});
		},

		applyThemeSelector : function() {
			var select = $(this),
			preview = select.next('.ipt_uif_theme_preview'),
			updateTheme = function() {
				var selected = select.find('option:selected'),
				colors = selected.data('colors'),
				newHTML = '', i;
				preview.html('');
				for (i = 0; i < colors.length; i++) {
					newHTML += '<div style="background-color: #' + colors[i] + ';"></div>';
				}
				preview.html(newHTML);
			};

			select.on('change keyup', function() {
				updateTheme();
			});
			updateTheme();
		},

		applyPrintElement : function() {
			$(this).on('click', '.ipt_uif_printelement', function() {
				$('#' + $(this).data('printid')).printElement({
					leaveOpen:true,
					printMode:'popup',
					pageTitle : document.title
				});
			});
		},

		applyDatePicker : function() {
			if ( ! this.length ) {
				return;
			}

			this.datepicker({
				dateFormat : 'yy-mm-dd',
				beforeShow : function() {
					$('body').addClass('ipt_uif_common');
				},
				onClose : function() {
					$('body').removeClass('ipt_uif_common');
				},
				showButtonPanel: true,
				closeText: iptPluginUIFDTPL10n.closeText,
				currentText: iptPluginUIFDTPL10n.currentText,
				monthNames: iptPluginUIFDTPL10n.monthNames,
				monthNamesShort: iptPluginUIFDTPL10n.monthNamesShort,
				dayNames: iptPluginUIFDTPL10n.dayNames,
				dayNamesShort: iptPluginUIFDTPL10n.dayNamesShort,
				dayNamesMin: iptPluginUIFDTPL10n.dayNamesMin,
				firstDay: iptPluginUIFDTPL10n.firstDay,
				isRTL: iptPluginUIFDTPL10n.isRTL,
				timezoneText : iptPluginUIFDTPL10n.timezoneText
			});
		},

		applyDateTimePicker : function() {
			if ( ! this.length ) {
				return;
			}

			this.datetimepicker({
				dateFormat : 'yy-mm-dd',
				timeFormat : 'hh:mm:ss',
				beforeShow : function() {
					$('body').addClass('ipt_uif_common');
				},
				onClose : function() {
					$('body').removeClass('ipt_uif_common');
				},
				showButtonPanel: true,
				closeText: iptPluginUIFDTPL10n.closeText,
				currentText: iptPluginUIFDTPL10n.tcurrentText,
				monthNames: iptPluginUIFDTPL10n.monthNames,
				monthNamesShort: iptPluginUIFDTPL10n.monthNamesShort,
				dayNames: iptPluginUIFDTPL10n.dayNames,
				dayNamesShort: iptPluginUIFDTPL10n.dayNamesShort,
				dayNamesMin: iptPluginUIFDTPL10n.dayNamesMin,
				firstDay: iptPluginUIFDTPL10n.firstDay,
				isRTL: iptPluginUIFDTPL10n.isRTL,
				amNames : iptPluginUIFDTPL10n.amNames,
				pmNames : iptPluginUIFDTPL10n.pmNames,
				timeSuffix : iptPluginUIFDTPL10n.timeSuffix,
				timeOnlyTitle : iptPluginUIFDTPL10n.timeOnlyTitle,
				timeText : iptPluginUIFDTPL10n.timeText,
				hourText : iptPluginUIFDTPL10n.hourText,
				minuteText : iptPluginUIFDTPL10n.minuteText,
				secondText : iptPluginUIFDTPL10n.secondText,
				millisecText : iptPluginUIFDTPL10n.millisecText,
				microsecText : iptPluginUIFDTPL10n.microsecText,
				timezoneText : iptPluginUIFDTPL10n.timezoneText
			});
		},

		applyDateTimeNowButton : function() {
			$(this).on('click', '.ipt_uif_datepicker_now', function() {
				$(this).nextAll('.ipt_uif_text').val('NOW');
			});
		},

		applyCollapsible : function() {
			var state = false;
			var self = this;
			var collapse_box = $(this).find('> .ipt_uif_collapsed');
			if($(this).data('opened') == true) {
				state = true;
			}
			var controller = $(this).find('> .ipt_uif_box.cyan h3 a');

			//Attach the event
			controller.on('click', function() {
				$(this).toggleClass('ipt_uif_collapsible_open');
				collapse_box.slideToggle('normal', function() {
					methods.reinitParentScroll.apply(self);
				});
			});

			//Check the initial state
			if(state) {
				collapse_box.show();
				controller.addClass('ipt_uif_collapsible_open');
			} else {
				collapse_box.hide();
				controller.removeClass('ipt_uif_collapsible_open');
			}
		},

		applyUploader : function() {
			var input = $(this).find('input').eq(0);
			var preview = $(this).find('div.ipt_uif_upload_preview').eq(0);
			var button = $(this).find('button.ipt_uif_upload_button').eq(0);
			var cancel = $(this).find('button.ipt_uif_upload_cancel').eq(0);
			var download = $(this).find('a').eq(0);
			var filename;

			if(button.length && input.length) {
				//Initialize
				filename = input.val();
				preview.hide();
				download.hide();
				button.removeClass('ipt_uif_upload_float');
				if(methods.testImage(filename)) {
					preview.css({backgroundImage : 'url("' + filename + '")'}).show();
				} else if(filename == '') {
					cancel.hide();
				} else {
					download.attr('href', filename).show();
					button.addClass('ipt_uif_upload_float');
				}

				//Bind to previewer
				preview.on('click', function() {
					tb_show('', input.val() + '?TB_iframe=true');
				});

				// Bind to cancel button
				cancel.on('click', function(e) {
					e.preventDefault();
					// Remove the input value
					input.val('');
					preview.hide();
					download.hide();
					cancel.hide();
				});

				//Bind to upload button
				button.on('click', function(e) {
					e.preventDefault();

					//Set the reference variables
					wp_media_reference.input = input;
					wp_media_reference.preview = preview;
					wp_media_reference.download = download;
					wp_media_reference.self = this;
					wp_media_reference.cancel = cancel;

					//If wp_media already exists
					if(ipt_uif_wp_media_frame) {
						ipt_uif_wp_media_frame.open();
						return;
					}

					//Create the media frame
					ipt_uif_wp_media_frame = wp.media.frames.ipt_uif_wp_media_frame = wp.media({
						title : $(input).data('title'),
						button : {
							text : $(input).data('select')
						},
						multiple : false
					});

					//Bind the select event
					ipt_uif_wp_media_frame.on('select', function() {
						var attachment = ipt_uif_wp_media_frame.state().get('selection').first().toJSON();
						wp_media_reference.preview.hide();
						wp_media_reference.download.hide();
						$(wp_media_reference.self).removeClass('ipt_uif_upload_float');

						if(methods.testImage(attachment.url)) {
							wp_media_reference.preview.css({backgroundImage : 'url("' + attachment.url + '")'}).show();
						} else if(attachment.url == '') {

						} else {
							wp_media_reference.download.attr('href', attachment.url).show();
							$(wp_media_reference.self).addClass('ipt_uif_upload_float');
						}

						//Change the input value
						wp_media_reference.input.val(attachment.url);

						//Check to see if title is associated
						var associated_title_elem = wp_media_reference.input.data('settitle');
						if ( associated_title_elem != undefined && $( '#' + associated_title_elem ).length ) {
							$('#' + associated_title_elem).val(attachment.title);
						}

						// Show the cancel button
						wp_media_reference.cancel.show();

						//Reinit parent scroll
						methods.reinitParentScroll.apply(wp_media_reference.self);
					});

					//open it
					ipt_uif_wp_media_frame.open();
				});
			}
		},

		applyBuilder : function() {
			var self = this;
			//Store the keys
			var keys = JSON.parse($(self).find('input.ipt_uif_builder_keys').val());
			keys = $.extend(true, {}, JSON.parse($(self).find('input.ipt_uif_builder_default_keys').val()), keys);
			$(self).data('ipt_uif_builder_keys', keys);
			var replace = JSON.parse($(self).find('input.ipt_uif_builder_replace_string').val());
			$(self).data('ipt_uif_builder_replace', replace);

			//Init the variables
			var tabs = $(this).find('.ipt_uif_builder_layout'),
			adds = $(this).find('.ipt_uif_builder_add_layout');
			var tab = undefined, add = undefined;

			//Apply the layout tabs
			if(tabs.length) {
				tab = tabs[0];
				methods.builderTabs.apply(tab, [self]);
			}

			//Init the Add New Layout button
			if(adds.length) {
				add = adds[0];
				methods.builderAddTab.apply(add, [tab, self]);
			}

			//Init the new elements button
			$(this).find('.ipt_uif_droppable').each(function() {
				methods.builderDraggables.apply(this, [tab, self]);
			});

			//Init the toolbar
			$(this).find('.ipt_uif_builder_layout_settings_toolbar').each(function() {
				methods.builderToolbar.apply(this, [tab, self, add]);
			});

			//Init the settings
			var settings_box = $(this).find('.ipt_uif_builder_settings_box').eq(0);
			$(this).data('ipt_uif_builder_settings', settings_box);
			settings_box.data('ipt_uif_builder_settings_origin', undefined);

			//Init the settings save
			var settings_save = settings_box.next().find('button');
			methods.builderSettingsSaveInit.apply(settings_save, [settings_box, self]);

			//Delegate all settings and expandables
			methods.builderElementSettingsEvent.apply(this);

			//Hide the wp_editor
			$(this).find('.ipt_uif_builder_wp_editor').css({position : 'absolute', 'left' : -9999});

			//Init the del dragger
			$(this).find('.ipt_uif_builder_deleter').each(function() {
				methods.builderDeleter.apply(this, [settings_box, self]);
			});

			// Init the copier
			$(this).on('click', '.ipt_uif_builder_copy_handle', function(e) {
				methods.builderDuplicate.apply(this, [self, settings_box]);
				// No need to stop propagation because none of the child element can have a builder within!!
			});
		},

		applyHelp : function(e) {
			e.preventDefault();
			var trigger = $(this).find('.ipt_uif_msg_icon'),
			title = trigger.attr('title'),
			temp, dialog_content;

			if(undefined === title || '' === title) {
				if(undefined !== (temp = trigger.parent().parent().siblings('th').find('label').html())) {
					title = temp;
				} else {
					title = iptPluginUIFAdmin.L10n.help;
				}
			}

			dialog_content = $('<div><div style="padding: 10px;">'  + trigger.next('.ipt_uif_msg_body').html() + '</div></div>');
			var buttons = {};
			buttons[iptPluginUIFAdmin.L10n.got_it] = function() {
				$(this).dialog("close");
			};
			dialog_content.dialog({
				autoOpen: true,
				buttons: buttons,
				modal: true,
				minWidth: 600,
				closeOnEscape: true,
				title: title,
				//appendTo : '.ipt_uif_common',
				create : function(event, ui) {
					$('body').addClass('ipt_uif_common');
				},
				close : function(event, ui) {
					$('body').removeClass('ipt_uif_common');
				}
			});
		},

		applySDA : function() {
			//get the submit button
			var $submit_button = $(this).find('> .ipt_uif_sda_foot button.ipt_uif_sda_button');
			var self = $(this);

			//get some variables
			var vars = {
				sort : self.data('draggable') == 1 ? true : false,
				add : self.data('addable') == 1 ? true : false,
				del : self.data('addable') == 1 ? true : false,
				count : ($submit_button.length && $submit_button.data('count') ? $submit_button.data('count') : 0),
				key : ($submit_button.length && $submit_button.data('key') ? $submit_button.data('key') : '__KEY__'),
				confirmDel : ($submit_button.length && $submit_button.data('confirm') ? $submit_button.data('confirm') : 'Are you sure you want to delete? This can not be undone.'),
				confirmTitle : ($submit_button.length && $submit_button.data('confirmtitle') ? $submit_button.data('confirmtitle') : 'Confirmation of Deletion')
			};
			//alert(typeof($submit_button.data('count')));

			//store this
			$(this).data('iptSortableData', vars);

			//make them sortable
			if(vars.sort)
				methods.SDAsort.apply(this);

			//make them deletable
			if(vars.del) {
				methods.SDAattachDel.apply(this, [vars]);
			}

			var $this = this;
			//attach to add new
			if(vars.add) {
				$submit_button.click(function(e) {
					e.preventDefault();
					methods.SDAadd.apply($this, [$submit_button]);
				});
			}
		},

		applyConditionalInput : function() {
			//Get all the inputs
			var inputs = $(this).find('input');
			//Store all the IDs
			var ids = new Array();

			var _self = this;

			//Loop through
			inputs.each(function() {
				var input_ids = $(this).data('condid');

				if(typeof(input_ids) == 'string') {
					input_ids = input_ids.split(',');
				} else {
					input_ids = [];
				}
				//Concat
				ids.push.apply(ids, input_ids);

				//Save it
				$(this).data('ipt_uif_conditional_inputs', input_ids);
			});

			//Show checked function
			var show_checked = function() {
				var shown = new Array();
				//Show only the checked
				inputs.filter(':checked').each(function() {
					var show_ids = $(this).data('ipt_uif_conditional_inputs');
					for(var id in show_ids) {
						shown[show_ids[id]] = true;
						$('#' + show_ids[id]).show();
					}
				});
				//Hide rest
				for(var id in ids) {
					if(shown[ids[id]] != true) {
						$('#' + ids[id]).stop(true, true).hide();
					}
				}
				methods.reinitParentScroll.apply(_self);
			};

			//Bind the change
			inputs.on('change', function() {
				show_checked();
			});
			//Init it
			show_checked();
		},

		applyConditionalSelect : function() {
			var select = $(this).find('select').eq(0);
			var _self = this;

			var ids = new Array();
			select.find('option').each(function() {
				var input_ids = $(this).data('condid');

				if(typeof(input_ids) == 'string') {
					input_ids = input_ids.split(',');
				} else {
					input_ids = [];
				}

				ids.push.apply(ids, input_ids);
			});

			var show_checked = function() {
				//Hide all
				for(var id in ids) {
					$('#' + ids[id]).hide();
				}

				//Show the current
				var activated_ids = select.find('option:selected').data('condid');

				if(typeof(activated_ids) == 'string') {
					activated_ids = activated_ids.split(',');
				} else {
					activated_ids = [];
				}

				for(var id in activated_ids) {
					$('#' + activated_ids[id]).show();
				}
				methods.reinitParentScroll.apply(_self);
			};

			//Attach listener
			select.on('change keyup', function() {
				show_checked();
			});

			show_checked();
		},

		applyProgressBar : function() {
			//First get the start value
			var start_value = $(this).data('start') ? $(this).data('start') : 0;
			var progress_self = $(this);

			//Add the value to the inner div
			var value_div = progress_self.find('.ipt_uif_progress_value').addClass('code');
			value_div.html(start_value + '%');

			//Init the progressbar
			var progressbar = progress_self.progressbar({
				value : start_value,
				change : function(event, ui) {
					value_div.html($(this).progressbar('option', 'value') + '%');
				}
			});

			if(progress_self.next('.ipt_uif_button_container').find('.ipt_uif_button.progress_random_fun').length) {
				progress_self.next('.ipt_uif_button_container').find('.ipt_uif_button.progress_random_fun').on('click', function() {
					//this.preventDefault();
					var new_value = parseInt(Math.random()*100);
					progressbar.progressbar('option', 'value', new_value);
					return false;
				});
			}
		},

		applySpinner : function() {
			if ( ! this.length ) {
				return;
			}
			this.spinner({mouseWheel: false});
			this.off('mousewheel');
			/*$(this).on('mousewheel', function(e) {
				e.preventDefault();
				var scroll = $(this).parents('.ipt_uif_scroll').eq(0);
				//console.log(scroll);
				scroll.mCustomScrollbar('disable');
			});
			$(this).on('mouseout', function() {
				var scroll = $(this).parents('.ipt_uif_scroll').eq(0);
				//console.log(scroll);
				scroll.mCustomScrollbar('update');
			});*/
		},

		applySlider : function() {
			//First get the settings
			var step = (($(this).data('step'))? parseFloat($(this).data('step')) : 1);
			if(isNaN(step))
				step = 1;

			var min = parseFloat($(this).data('min'));
			if(isNaN(min))
				min = 1;

			var max = parseFloat($(this).data('max'));
			if(isNaN(max))
				max = 9999;

			var value = parseFloat($(this).val());
			if(isNaN(value))
				value = min;

			var slider_range = $(this).hasClass('slider_range') ? true : false;
			//alert(slider_range);

			var slider_settings = {
				min: min,
				max: max,
				step: step,
				range: false
			};

			var second_value;

			//Store the reference
			var first_input = $(this);

			//Get the second input if necessary
			var second_input = null;
			if(slider_range) {
				second_input = $(this).next('input');
				second_value = parseFloat(second_input.val());
				if(isNaN(second_value)) {
					second_value = min;
				}
			}

			//Prepare the show count
			var count_div = first_input.prev('div.ipt_uif_slider_count');

			//Now append the div
			var slider_div = $('<div />');
			slider_div.addClass(slider_range ? 'ipt_uif_slider_range' : 'ipt_uif_slider_single');

			var slider_div_duplicate;
			if(slider_range) {
				slider_div_duplicate = second_input.next('div');
			} else {
				slider_div_duplicate = first_input.next('div');
			}
			if(slider_div_duplicate.length) {
				slider_div_duplicate.remove();
			}

			if(slider_range) {
				second_input.after(slider_div);
			} else {
				$(this).after(slider_div);
			}


			//Prepare the slide function
			if(!slider_range) {
				slider_settings.slide = function(event, ui) {
					first_input.val(ui.value);
					if(count_div.length) {
						count_div.find('span').text(ui.value);
					}
				};
				slider_settings.value = value;
			} else {
				//alert('atta boy');
				slider_settings.slide = function(event, ui) {
					first_input.val(ui.values[0]);
					second_input.val(ui.values[1]);
					if(count_div.length) {
						count_div.find('span.ipt_uif_slider_count_min').text(ui.values[0]);
						count_div.find('span.ipt_uif_slider_count_max').text(ui.values[1]);
					}
				};
				slider_settings.values = [value, second_value];
				slider_settings.range = true;
			}

			//Make the input(s) readonly
			$(this).attr('readonly', true);
			if(slider_range) {
				second_input.attr('readonly', true);
			}

			//Init the counter
			if(count_div.length) {
				if(slider_range) {
					count_div.find('span.ipt_uif_slider_count_min').text(value);
					count_div.find('span.ipt_uif_slider_count_max').text(second_value);
				} else {
					count_div.find('span').text(value);
				}
			}

			//Init the slider
			var slider = slider_div.slider(slider_settings);

			//Bind the change function
			if(slider_range) {
				first_input.change(function() {
					slider.slider({
						values : [parseFloat(first_input.val()), parseFloat(second_input.val())]
					});
				});
				$(second_input).change(function() {
					slider.slider({
						values : [parseFloat(first_input.val()), parseFloat(second_input.val())]
					});
				});
			} else {
				first_input.change(function() {
					slider.slider({
						value : parseFloat(first_input.val())
					});
				});
			}
		},

		applyIconSelector : function() {
			$(this).on('change keyup', '.ipt_uif_icon_selector', function() {
				var previewer = $(this).prev('.ipt_uif_icon_selector_preview');
				previewer.attr('data-icon', $(this).find('option:selected').data('hex'));
			});
		},

		applyIRIS : function() {
			$(this).find('.ipt_uif_colorpicker').wpColorPicker();
			$(this).on('click', '.wp-picker-container a', function() {
				methods.reinitParentScroll.apply(this);
			});
		},

		applyTabs : function(op) {
			//Default tab functionality
			var tab_ops = {
				collapsible : $(this).data('collapsible') ? true : false,
				//Add Scrollbar to the activate tab when created
				create : function(event, ui) {
					ui.panel.find('> div > .ipt_uif_tabs_scroll').each(function() {
						methods.applyScrollBar.apply(this);
					});
				}
			};
			$(this).tabs(tab_ops);

			//Fix for vertical tabs
			if($(this).hasClass('vertical')) {
				$(this).addClass('ui-tabs-vertical ui-helper-clearfix');
				$(this).find('> ul > li').removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );
			}

			//Add Scrollbar on change of tabs
			$(this).on("tabsactivate", function(event, ui) {
				//Init the new scrollbar
				ui.newPanel.find('> div > .ipt_uif_tabs_scroll').each(function() {
					methods.applyScrollBar.apply(this);
				});

				//Init scrollbar to the inner tab (if any)
				var inner_tabs = ui.newPanel.find('.ipt_uif_tabs');
				if(inner_tabs.length) {
					inner_tabs.each(function() {
						var active_inner_tab = $(this).find('> .ui-tabs-panel').eq($(this).tabs('option', 'active')).find('.ipt_uif_tabs_scroll');
						active_inner_tab.each(function() {
							methods.applyScrollBar.apply(this);
						});
					});
				}
			});
		},

		applyScrollBar : function() {
			$(this).mCustomScrollbar('destroy');
			$(this).mCustomScrollbar({
				scrollInertia : 300,
				autoDraggerLength : true,
				scrollButtons : {
					enable : true
				},
				advanced : {
					autoScrollOnFocus: false
				},
				theme : 'ipt-uif'
			});
		},

		SDAattachDel : function(vars) {
			$(this).on('click', '.ipt_uif_sda_del', function() {
				var $this = this;
				var dialog = $('<p>' + vars.confirmDel + '</p>');
				dialog.dialog({
					autoOpen : true,
					modal : true,
					minWidth : 400,
					closeOnEscape : true,
					title : vars.confirmTitle,
					buttons : {
						'Confirm' : function() {
							methods.SDAdel.apply($this);
							$(this).dialog('close');
						},
						'Cancel' : function() {
							$(this).dialog('close');
						}
					},
					//appendTo : '.ipt_uif_common',
					create : function(event, ui) {
						$('body').addClass('ipt_uif_common');
					},
					close : function(event, ui) {
						$('body').removeClass('ipt_uif_common');
					}
				});
			});
		},

		SDAsort : function() {
			$(this).find('> .ipt_uif_sda_body').sortable({
				items : 'div.ipt_uif_sda_elem',
				placeholder : 'ipt_uif_sda_highlight',
				handle : 'div.ipt_uif_sda_drag',
				distance : 5,
				axis : 'y',
				helper : 'original'
			});
		},

		SDAdel : function() {
			var target = $(this).parent();
			var parent = $(this).parent().parent();
			target.slideUp('normal');
			target.css('background-color', '#ffaaaa').animate({'background-color' : '#ffffff'}, 'normal', function() {
				target.stop().remove();
				methods.reinitParentScroll.apply(parent);
			});
		},

		SDAadd : function($submit) {
			var vars = $(this).data('iptSortableData');

			var $add_string = $(this).find('> .ipt_uif_sda_data').text();
			$add_string = $('<div></div>').html($add_string).text();

			//alert($add_string);
			var count = vars.count++;
			var re = new RegExp(methods.quote(vars.key), 'g');

			$add_string = $add_string.replace(re, count);
			//alert($add_string);

			var new_div = $('<div class="ipt_uif_sda_elem" />').append($($add_string));

			$(this).find('> .ipt_uif_sda_body').append(new_div);

			//Apply the framework again
			$(new_div).iptPluginUIFAdmin();

			var old_color = new_div.css('background-color');

			new_div.hide().slideDown('fast').css('background-color', '#aaffaa').animate({'background-color' : old_color}, 'normal', function() {
				//Reinit the scrollbar
				methods.reinitParentScroll.apply(this);
			});
			$submit.data('count', vars.count);
			$submit.attr('data-count', vars.count);
		},

		builderTabs : function(container) {
			var self = this;
			var tab = $(this).tabs();
			tab.find('.ui-tabs-nav').sortable({
				placeholder : 'ipt_uif_builder_tabs_sortable_highlight',
				stop : function() {
					methods.builderTabRefresh.apply(self);
				},
				handle : '.ipt_uif_builder_tab_sort',
				tolerance : 'pointer',
				containment : 'parent',
				distance : 5
			});

			//Make existing drop_here 's droppable
			tab.find('.ui-tabs-panel').each(function() {
				methods.builderDroppables.apply(this, [container]);
			});

			//Make the tab li 's droppable
			tab.find('.ui-tabs-nav li').each(function() {
				methods.builderTabDroppable.apply(this, [container]);
			})

			//Store the tab counter
			var tab_counter = $(this).find('.ui-tabs-nav > li').length;
			$(this).data('ipt_uif_builder_tab_counter', tab_counter);

			//Add empty class if necessary
			if(tab_counter == 0) {
				$(this).addClass('ipt_uif_builder_empty');
			}
		},

		builderAddTab : function(tab, container) {
			$(this).on('click', function(e) {
				e.preventDefault();
				//alert(container);
				var key = $(container).data('ipt_uif_builder_replace')['l_key'];
				var tab_content = $(container).find('.ipt_uif_builder_tab_content').text();

				tab_content = $('<div></div>').html(tab_content).text();

				var tab_counter = $(tab).data('ipt_uif_builder_tab_counter');
				var re = new RegExp(methods.quote(key), 'g');
				tab_content = tab_content.replace(re, tab_counter);

				var id = $(tab).attr('id') + '_' + tab_counter,
				li = $(container).find('.ipt_uif_builder_tab_li').text();
				li = $('<div></div>').html(li).text();
				li = $(li);

				li.find('.tab_position').val(tab_counter);
				li.find('a').attr('href', '#' + id);
				$(tab).find('.ui-tabs-nav').append(li);

				var new_tab = $('<div id="' + id + '">' + tab_content + '</div>');
				$(tab).append(new_tab);
				tab_counter++;

				new_tab.iptPluginUIFAdmin();
				methods.builderTabDroppable.apply(li, [container]);

				$(tab).data('ipt_uif_builder_tab_counter', tab_counter);

				$(tab).removeClass('ipt_uif_builder_empty');

				methods.builderTabRefresh.apply(tab);
				methods.builderDroppables.apply(new_tab, [container]);

				//Open the last tab
				$(tab).tabs('option', 'active', $(tab).find('> .ui-tabs-nav > li').length - 1);

			});
		},

		builderTabDroppable : function(container) {
			$(this).find('.ipt_uif_builder_tab_droppable').droppable({
				greedy : true,
				accept : '.ipt_uif_droppable_element',
				tolerance : 'pointer',
				activate : function(event, ui) {
					$(this).addClass('ipt_uif_builder_tab_droppable_highlight');
				},
				deactivate : function(event, ui) {
					$(this).removeClass('ipt_uif_builder_tab_droppable_highlight');
				},
				over : function(event, ui) {
					$(this).addClass('ipt_uif_builder_tab_droppable_over');
				},
				out : function(event, ui) {
					$(this).removeClass('ipt_uif_builder_tab_droppable_over');
				},
				drop : function(event, ui) {
					var new_droppable = $('#' + $(this).parent().parent().attr('aria-controls')).find('> .ipt_uif_builder_drop_here').get(0);
					var self = this;
					var tab = $(self).parent().parent().parent().parent();
					var move_to = $(self).parent().parent().parent().find('> li').index($(self).parent().parent());
					tab.tabs('option', 'active', move_to);
					var callback = function() {
						$(self).removeClass('ipt_uif_builder_tab_droppable_highlight');
						$(self).removeClass('ipt_uif_builder_tab_droppable_over');
					};
					methods.builderHandleDrop.apply(new_droppable, [event, ui, container, callback]);
				}
			});
		},

		builderTabRefresh : function() {
			$(this).tabs('refresh');

			$(this).find('.ui-tabs-nav').sortable('refresh');
			$(this).find('.ui-tabs-nav').sortable('refreshPositions');

			var tab_counter = $(this).find('.ui-tabs-nav > li').length;
			//Add empty class if necessary
			if(tab_counter == 0) {
				$(this).addClass('ipt_uif_builder_empty');
			}
		},

		builderToolbar : function(tab, container, add) {
			$(this).find('.ipt_uif_builder_layout_settings').on('click', function() {
				var active_tab = $(tab).tabs('option', 'active');
				var panelID = $(tab).find('.ui-tabs-nav li').eq(active_tab).attr('aria-controls');
				var settings_box = $(container).data('ipt_uif_builder_settings').get(0);
				var origin = $('#' + panelID).find('.ipt_uif_builder_tab_settings').get(0);
				//console.log(origin);
				methods.builderSettingsOpen.apply(this, [settings_box, container, origin]);
			});

			$(this).find('.ipt_uif_builder_layout_copy').on('click', function() {
				// Get the original tab in question (this to copy)
				var original_active_tab = $(tab).tabs('option', 'active'),
				originalPanelID = $(tab).find('.ui-tabs-nav li').eq(original_active_tab).attr('aria-controls');

				// First close the settings box
				var settings_box = $(container).data('ipt_uif_builder_settings').get(0);
				methods.builderSettingsClose.apply(this, [settings_box, container]);

				// Add a new tab
				$(add).trigger('click');

				// Get the last added tab
				var active_tab = $(tab).tabs('option', 'active'),
				panelID = $(tab).find('.ui-tabs-nav li').eq(active_tab).attr('aria-controls');

				var originalPanel = $('#' + originalPanelID),
				newPanel = $('#' + panelID),
				cloneDroppable = originalPanel.find('>.ipt_uif_builder_drop_here').clone();

				// Remove the existing droppable area but store the key first
				var existingLayout = newPanel.find('>.ipt_uif_builder_drop_here'),
				existingKey = existingLayout.data('containerKey');
				existingLayout.remove();

				// Add the new one
				cloneDroppable.appendTo( newPanel );

				// Now modify existing elements
				methods.builderDuplicateReplaceInnerKeys.apply( cloneDroppable, [container, existingKey] );

				// Finally refresh it
				methods.builderTabRefresh.apply(tab);
				methods.builderDroppables.apply(newPanel, [container]);
				newPanel.iptPluginUIFAdmin();
			});

			$(this).find('.ipt_uif_builder_layout_del').on('click', function() {
				var title = $(this).data('title');
				var dialog_content = $('<div><div style="padding: 10px;"><p>'  + $(this).data('msg') + '</p></div></div>');
				dialog_content.dialog({
					autoOpen: true,
					buttons: {
						"Confirm": function() {
							var active_tab = $(tab).tabs('option', 'active');
							//Remove the li
							var panelID = $(tab).find('.ui-tabs-nav li').eq(active_tab).remove().attr('aria-controls');
							//Remove the Panel
							$(tab).find('#' + panelID).remove();

							methods.builderTabRefresh.apply(tab);
							$(this).dialog("close");
						},
						'Cancel' : function() {
							$(this).dialog("close");
						}
					},
					modal: true,
					minWidth: 600,
					closeOnEscape: true,
					title: title,
					//appendTo : '.ipt_uif_common',
					create : function(event, ui) {
						$('body').addClass('ipt_uif_common');
					},
					close : function(event, ui) {
						$('body').removeClass('ipt_uif_common');
					}
				});
			});
		},

		builderSettingsOpen : function(settings_box, container, origin) {
			methods.builderSettingsClose.apply(this, [settings_box, container]);
			container = $(container);
			origin = $(origin);

			//Double Click? Then Toggle
			if(!origin.length) {
				return;
			}

			//Store the parent
			var parent = origin.parent();
			$(settings_box).data('ipt_uif_builder_settings_parent', parent);

			//Append the origin settings
			$(settings_box).find('.ipt_uif_builder_settings_box_container').prepend(origin);



			//Check wp_editor
			var wp_editor_textarea = $(settings_box).find('textarea.wp_editor').eq(0);
			if(wp_editor_textarea.length) {
				var wp_editor_container = container.find('.ipt_uif_builder_wp_editor');
				var tmce_textarea = wp_editor_container.find('textarea').eq(0);

				//Init the tinyMCE API
				var editor = tinyMCE.get(tmce_textarea.attr('id'));

				//Get the original content
				var content = wp_editor_textarea.val();

				//Show it
				wp_editor_container.css({position : 'static', 'left' : 'auto'});

				//Set the content
				if(editor && editor instanceof tinymce.Editor) {
					editor.setContent(switchEditors.wpautop(content));
					editor.save({ no_events: true });
					//console.log('Setter in TinyMCE: ' + switchEditors.wpautop(content));
				} else {
					tmce_textarea.val(switchEditors.pre_wpautop(content));
					//console.log('Setter in TextArea: ' + switchEditors.pre_wpautop(content));
				}

			}

			//See if origin parent is a droppable
			if(parent.hasClass('ipt_uif_droppable_element')) {
				parent.find('> .ipt_uif_droppable_element_wrap').addClass('white');
			}

			//Store the origin
			$(settings_box).data('ipt_uif_builder_settings_origin', origin);

			//Show it
			$(settings_box).parent().stop(true, true).css({height : 'auto'}).hide().slideDown('fast', function() {
				//Apply the scrollbar
				methods.applyScrollBar.apply(settings_box);

				//Init the scroll position
				var scroll_position = $(settings_box).parent().offset().top;
				if(wp_editor_textarea.length) {
					//Change the scroll position
					scroll_position = wp_editor_container.offset().top;
				}

				//Scroll the body
				if($('#wpadminbar').length) {
					scroll_position -= ($('#wpadminbar').outerHeight() + 10);
				}
				$('html, body').animate({scrollTop : scroll_position});
			});

			//$(settings_box).next().show();
		},

		builderSettingsClose : function(settings_box, container) {
			//Destroy the scroll bar
			methods.destroyScrollBar.apply(settings_box);

			//Get origin and parent
			var origin = $(settings_box).data('ipt_uif_builder_settings_origin');
			var parent = $(settings_box).data('ipt_uif_builder_settings_parent');
			//console.log(origin);
			//console.log(parent);

			//Check for double click on a single button
			if(origin == undefined) {
				return;
			}

			//Init the container
			container = $(container);

			//Check wp_editor
			var wp_editor_textarea = $(settings_box).find('textarea.wp_editor').eq(0);
			if(wp_editor_textarea.length) {
				//Get the tmce textarea
				var tmce_textareaID = container.find('.ipt_uif_builder_wp_editor textarea').eq(0).attr('id');
				var content;
				var editor = tinyMCE.get(tmce_textareaID);

				//Get the content
				if(editor && editor instanceof tinymce.Editor) {
					content = switchEditors.pre_wpautop(editor.getContent());
					//console.log('Getter in TinyMCE: ' + content);
				} else {
					content = $('#' + tmce_textareaID).val();
					//console.log('Getter in TextArea: ' + content);
				}

				//Update it
				wp_editor_textarea.val(content);

				//Hide the wp_editor
				container.find('.ipt_uif_builder_wp_editor').css({position : 'absolute', 'left' : -9999});
			}

			//See if origin parent is a droppable
			if(parent.hasClass('ipt_uif_droppable_element')) {
				parent.find('> .ipt_uif_droppable_element_wrap').removeClass('white');
			}

			//Restore
			parent.append(origin);

			// Change the subtitle of the parent
			if ( parent.hasClass('ipt_uif_droppable_element_added') ) {
				var possible_title_id = parent.find('.element_m_type').val() + '_' + parent.find('.element_key').val() + '_title',
				possible_title = $('#' + possible_title_id).val();

				if ( possible_title && typeof( possible_title ) == 'string' ) {
					parent.find('span.element_title').text( ' : ' + possible_title.trim() );
					parent.find('h3.element_title_h3').attr( 'title', possible_title.trim() );
				}
			}


			//Hide it
			$(settings_box).data('ipt_uif_builder_settings_origin', undefined);
			$(settings_box).data('ipt_uif_builder_settings_parent', undefined);
			$(settings_box).parent().stop(true).slideUp('fast');
			//$(settings_box).next().hide();
		},

		builderSettingsSaveInit : function(settings_box, container) {
			$(this).on('click', function() {
				methods.builderSettingsClose.apply(this, [settings_box, container]);
			});
		},

		builderElementSettingsEvent : function() {
			var container = this;
			//Delegate the settings
			$(container).on('click', '.ipt_uif_builder_settings_handle', function(e) {
				e.preventDefault();
				var origin = $(this).parent().parent().find('> .ipt_uif_builder_settings').get(0),
				settings_box = $(container).data('ipt_uif_builder_settings').get(0);
				methods.builderSettingsOpen.apply(this, [settings_box, container, origin]);
			});

			$(container).on('click', '.ipt_uif_builder_droppable_handle', function(e) {
				e.preventDefault();
				if($(this).hasClass('ipt_uif_builder_droppable_handle_open')) {
					$(this).removeClass('ipt_uif_builder_droppable_handle_open');
					$(this).siblings('.ipt_uif_builder_drop_here').slideUp('normal');
				} else {
					$(this).addClass('ipt_uif_builder_droppable_handle_open');
					$(this).siblings('.ipt_uif_builder_drop_here').slideDown('normal');
				}
			});
		},

		builderDeleter : function(settings_box, container) {
			var self = $(this).css('visibility', 'hidden');
			$(this).droppable({
				greedy : true,
				tolerance : 'pointer',
				accept : '.ipt_uif_builder_drop_here .ipt_uif_droppable_element',
				activate : function(event, ui) {
					self.stop(true, true).css('visibility', 'visible');
					self.find('.ipt_uif_builder_deleter_wrap').stop(true, true).css({height : 0, opacity : 0}).animate({height : 45, opacity : 1}, 'fast');
				},
				deactivate : function(event, ui) {
					self.find('.ipt_uif_builder_deleter_wrap').stop(true, false).animate({height : 0, opacity : 0}, 'fast', function() {
						self.stop(true, true).css('visibility', 'hidden');
					});
				},
				over : function(event, ui) {
					ui.helper.find('.ipt_uif_droppable_element_wrap').addClass('red');
				},
				out : function(event, ui) {
					ui.helper.find('.ipt_uif_droppable_element_wrap').removeClass('red');
				},
				drop : function(event, ui) {
					var drop_here = ui.draggable.parent();

					//First check for dbmap
					var item = ui.draggable;
					if(item.data('dbmap') == true) {
						//Restore
						var original = item.data('ipt_uif_builder_dbmap_original');
						original.removeClass('ipt_uif_droppable_element_disabled');
					}
					ui.draggable.remove();

					methods.builderSettingsClose.apply(this, [settings_box, container]);

					if(drop_here.find('.ipt_uif_droppable_element:not(.ui-sortable-placeholder):not(.ui-sortable-helper)').length < 1) {
						drop_here.addClass('ipt_uif_builder_drop_here_empty');
					}
					self.find('.ipt_uif_builder_deleter_wrap').stop(true, false).animate({height : 0, opacity : 0}, 'fast', function() {
						self.stop(true, true).css('visibility', 'hidden');
					});
				}
			});
		},

		builderDuplicate: function(container, settings_box) {
			// Close the settings box
			methods.builderSettingsClose.apply(this, [settings_box, container]);

			// Get the mother element
			var elementToCopy = $(this).closest('.ipt_uif_droppable_element'),
			// Clone it
			duplicateDOM = elementToCopy.clone(),
			// Init the new key
			key = 0,
			// Init the inner droppable element
			innerDroppableDOM = null;

			// Do not do anything if it is a dbmap
			if ( elementToCopy.data('dbmap') ) {
				return;
			}

			// Update the DOM id, name and for attributes
			key = methods.builderDuplicateModifyElements( elementToCopy, duplicateDOM, container );

			// Hide it
			duplicateDOM.hide();

			// Append it
			elementToCopy.after( duplicateDOM );

			//Check for other droppables
			innerDroppableDOM = duplicateDOM.find('> .ipt_uif_droppable_element_wrap > .ipt_uif_builder_drop_here');
			if(innerDroppableDOM.length) {
				innerDroppableDOM.each(function() {
					methods.builderDuplicateReplaceInnerKeys.apply( this, [container, key] );
				});
			}

			//Add any new Framework item
			duplicateDOM.iptPluginUIFAdmin();

			//Show it
			duplicateDOM.slideDown('fast');
		},

		builderDuplicateModifyElements: function( originalDOM, duplicateDOM, container ) {
			var element_m_type = originalDOM.find('> input.ipt_uif_builder_helper.element_m_type').val(),
			// Get type
			element_type = originalDOM.find('> input.ipt_uif_builder_helper.element_type').val(),
			// Get key
			element_key = parseInt( originalDOM.find('> input.ipt_uif_builder_helper.element_key').val(), 10 ),
			// Prepare the name to replace
			name_replace = element_m_type + '\\[' + element_key + '\\]',
			// Prepare the id to replace
			id_replace = element_m_type + '_' + element_key + '_',
			//Get the data variables
			keys = $(container).data('ipt_uif_builder_keys'),
			// Init the new key
			key = 0;

			// Set the new key
			if(undefined !== keys[element_m_type]) {
				key = keys[element_m_type];
				keys[element_m_type]++;
			} else {
				keys[element_m_type] = key;
			}

			//Update the keys
			$(container).data('ipt_uif_builder_keys', keys);

			// Update the DOM id, name and for attributes
			duplicateDOM.find('>.ipt_uif_builder_settings').find('input, textarea, select, button, datalist, keygen, output, label').each(function() {
				var form_elem = $(this),
				name = form_elem.attr('name'),
				id = form_elem.attr('id'),
				label_for = form_elem.attr('for');
				if ( name ) {
					form_elem.attr('name', name.replace(new RegExp(name_replace, 'g'), element_m_type + '[' + key + ']'));
				}
				if ( id ) {
					form_elem.attr('id', id.replace(new RegExp(id_replace, 'g'), element_m_type + '_' + key + '_'));
				}
				if ( label_for ) {
					form_elem.attr('for', label_for.replace(new RegExp(id_replace, 'g'), element_m_type + '_' + key + '_'));
				}
			});

			// Update SDA data, if any
			duplicateDOM.find('script.ipt_uif_sda_data').each(function() {
				var originalSDAData = $(this).html(),
				modifiedSDAData = originalSDAData.replace( new RegExp(name_replace, 'g'), element_m_type + '[' + key + ']' ).replace( new RegExp(id_replace, 'g'), element_m_type + '_' + key + '_' );
				$(this).html(modifiedSDAData);
			});

			// Set the new Key
			duplicateDOM.find('>input.ipt_uif_builder_helper.element_key').val(key);

			// Set the element info (M){K}
			var duplicateElementInfo = duplicateDOM.find('> .ipt_uif_droppable_element_wrap > h3 > .element_info');
			duplicateElementInfo.text( duplicateElementInfo.text().replace(element_key, key) );

			return key;
		},

		builderDuplicateReplaceInnerKeys: function(container, new_key) {
			// Update the key first
			$(this).data('containerKey', new_key);
			// First get the keys of this droppable container and stuff
			var droppable_key = new_key,
			droppable_m_type = $(this).data('replaceby'),
			new_helper_name = droppable_m_type + '[' + droppable_key + '][elements]';

			// Recursively check all ipt_uif_droppable_element
			$(this).find('>.ipt_uif_droppable_element').each( function() {
				var self = $(this),
				key = 0;

				// Update the DOM id, name and for attributes
				key = methods.builderDuplicateModifyElements( self, self, container );

				// Update new layout
				self.find('> input.ipt_uif_builder_helper.element_m_type').attr('name', new_helper_name + '[m_type][]' );
				self.find('> input.ipt_uif_builder_helper.element_type').attr('name', new_helper_name + '[type][]' );
				self.find('> input.ipt_uif_builder_helper.element_key').attr('name', new_helper_name + '[key][]' );

				// Now check if it again contains any inner droppable element
				var innerDroppableDOM = self.find('> .ipt_uif_droppable_element_wrap > .ipt_uif_builder_drop_here');
				if(innerDroppableDOM.length) {
					innerDroppableDOM.each(function() {
						methods.builderDuplicateReplaceInnerKeys.apply( this, [container, key] );
					});
				}
			} );
		},

		builderDraggables : function(tab, container) {
			//Make 'em droppable (err, sorry draggable to the droppables)
			var droppables = $(this).find('.ipt_uif_droppable_element');
			droppables.draggable({
				revert : 'invalid',
				revertDuration : 200,
				helper : 'clone',
				zIndex : 9999,
				appendTo : $(this),
				cancel : '.ipt_uif_droppable_element_disabled',
				handle : '.ipt_uif_builder_sort_handle',
				cursorAt : {left : 19, top : 17},
				delay : 100
			});

			// Emulate the same event when something is clicked
			$(this).on( 'click', '.ipt_uif_droppable_element', function(event) {
				var helper = $(this).clone(),
				ui = $(this),
				// Get the active tab droppable
				activeTab = $(tab).tabs( 'option', 'active' ),
				activeTabAria = $(tab).find('>ul>li.ipt_uif_builder_layout_tabs').eq(activeTab).attr('aria-controls'),
				activeTabAriaDOM = $('#' + activeTabAria).find('> .ipt_uif_builder_drop_here');
				console.log(activeTabAriaDOM);
				methods.builderHandleDrop.apply(activeTabAriaDOM.get(0), [null, {
					draggable: ui,
					helper: helper
				}, container]);
			} );

			//Bind the parent click function -> On click show elements under that category
			$(this).find('.ipt_uif_droppable_elements_parent').each(function() {
				$(this).on('click', function() {
					$(this).parent().find('.ipt_uif_droppable_elements_parent').hide();
					$(this).next('.ipt_uif_droppable_elements_wrap').fadeIn('fast');
				});
			});

			//Bind the child go back button function
			$(this).find('.ipt_uif_droppable_back').each(function() {
				$(this).on('click', function(e) {
					e.preventDefault();
					var self = $(this);
					self.parent().fadeOut('fast', function() {
						self.parent().parent().find('.ipt_uif_droppable_elements_parent').show();
					});
				});
			});
		},

		builderDroppables : function(container) {
			$(this).find('.ipt_uif_builder_drop_here').droppable({
				greedy : true,
				accept : '.ipt_uif_droppable_element',
				tolerance : 'pointer',
				activate : function(event, ui) {
					$(this).addClass('ipt_uif_highlight');
				},
				deactivate : function(event, ui) {
					$(this).removeClass('ipt_uif_highlight');
				},
				over : function(event, ui) {
					$(this).addClass('ipt_uif_droppable_hover');
					ui.helper.find('.ipt_uif_droppable_element_wrap').addClass('white');
				},
				out : function(event, ui) {
					$(this).removeClass('ipt_uif_droppable_hover');
					ui.helper.find('.ipt_uif_droppable_element_wrap').removeClass('white');
				},
				drop : function(event, ui) {
					methods.builderHandleDrop.apply(this, [event, ui, container]);
					return;
				}
			}).sortable({
				//accept : '.ipt_uif_droppable .ipt_uif_droppable_elements_wrap .ipt_uif_droppable_element',
				items : '> .ipt_uif_droppable_element',
				handle : '> div > a.ipt_uif_builder_sort_handle',
				helper : function(event, item) {
					var c = item.attr('class');
					var insider = item.find('> .ipt_uif_droppable_element_wrap');
					var helper = $('<div class="' + c + '"><div class="' + insider.attr('class') + '"></div></div>');
					helper.addClass('ui-sortable-helper');
					insider.find('> a.ipt_uif_builder_action_handle').each(function() {
						helper.find('> .ipt_uif_droppable_element_wrap').append($(this).clone());
					});
					helper.find('> .ipt_uif_droppable_element_wrap').append(insider.find('> h3').clone()).append('<div class="clear"></div>');
					return helper.appendTo($(this));
				},
				cancel : '.ipt_uif_droppable_element_cancel_sort',
				cursorAt : {left : 19, top : 17},
				stop : function(event, ui) {
					if(ui.item.hasClass('ipt_uif_droppable_element_move')) {
						var self = $(this);
						var append_to = ui.item.data('ipt_uif_droppable_move');
						ui.item.removeClass('ipt_uif_droppable_element_move');
						var parent = ui.item.parent();
						ui.item.slideUp('fast', function() {
							ui.item.appendTo(append_to).slideDown('fast', function() {
								if(parent.find('.ipt_uif_droppable_element:not(.ui-sortable-placeholder):not(.ui-sortable-helper)').length < 1) {
									parent.addClass('ipt_uif_builder_drop_here_empty');
								}
								append_to.sortable('refresh');
								self.sortable('refresh');
							});
						});
					}
				}
			});

			$(this).find('.ipt_uif_droppable_element').each(function() {
				//change the state of dbmap
				if($(this).data('dbmap') == true) {
					//get the original container from draggable
					var identify_class = $(this).attr('class');
					var original = $(container).find('.ipt_uif_droppable .ipt_uif_droppable_element').filter('[class="' + identify_class + '"]').addClass('ipt_uif_droppable_element_disabled');
					$(this).data('ipt_uif_builder_dbmap_original', original);
				}

				//Add the added class
				$(this).addClass('ipt_uif_droppable_element_added');
			});
		},

		builderHandleDrop : function(event, ui, container, callback) {
			ui.helper.find('.ipt_uif_droppable_element_wrap').removeClass('white');
			$(this).removeClass('ipt_uif_highlight');
			$(this).removeClass('ipt_uif_droppable_hover');
			//Two conditions
			//First the item is being dragged from .ipt_uif_droppable_elements_wrap
			//The item is being dragged within
			var item;
			var layout_key = $(this).data('containerKey');

			if(ui.draggable.hasClass('ipt_uif_droppable_element_added')) {
				item = ui.draggable;
				//Reset the names
				var new_name = $(this).data('replaceby') + '[' + $(this).data('containerKey') + '][elements]';
				item.find('> input.element_m_type').attr('name', new_name + '[m_type][]');
				item.find('> input.element_type').attr('name', new_name + '[type][]');
				item.find('> input.element_key').attr('name', new_name + '[key][]');

				//Append it
				if($(this).is(item.parent())) {
					//Do nothing
				} else {
					//Tell the bloody sortable to append it when it is done
					var append_to = $(this);
					item.data('ipt_uif_droppable_move', append_to);
					item.addClass('ipt_uif_droppable_element_move');
				}

				//That's it I guess
			} else {
				item = ui.draggable.clone();

				//Remove the template script
				var template_script = item.find('> .ipt_uif_builder_settings');
				var new_settings = $('<div class="ipt_uif_builder_settings"></div>');
				var decoded = new_settings.html(template_script.text()).text();
				new_settings.html(decoded);
				template_script.remove();
				item.find('.ipt_uif_droppable_element_wrap').before(new_settings);

				//Get the data variables
				var keys = $(container).data('ipt_uif_builder_keys');
				var replaces = $(container).data('ipt_uif_builder_replace');

				var prefix_to_replace = ui.draggable.data('replacethis');
				var prefix_replace_by = $(this).data('replaceby');

				var key = 0;
				var type = item.find('.element_m_type').val();
				if(undefined !== keys[type]) {
					key = keys[type];
					keys[type]++;
				} else {
					keys[type] = key;
				}
				var rk = new RegExp(methods.quote(replaces.key), 'g');
				var rl = new RegExp(methods.quote(replaces.l_key), 'g');
				var rprefix = new RegExp(methods.quote(prefix_to_replace), 'g');

				//Set the proper HTML name of the hidden element
				item.html(function(i, oldHTML) {
					var newHTML = oldHTML.replace(rk, key);
					newHTML = newHTML.replace(rprefix, prefix_replace_by);
					return newHTML.replace(rl, layout_key);
				});

				//Make the disabled="disabled" disappear
				item.find('> input.element_m_type').attr('disabled', false);
				item.find('> input.element_type').attr('disabled', false);
				item.find('> input.element_key').attr('disabled', false);

				//Now check for dbmap
				if(item.data('dbmap') == true) {
					ui.draggable.addClass('ipt_uif_droppable_element_disabled');
					item.data('ipt_uif_builder_dbmap_original', ui.draggable);
				}

				//Apply the added class
				item.addClass('ipt_uif_droppable_element_added');
				item.hide();

				//Append
				$(this).append(item);

				//Add any new Framework item
				item.iptPluginUIFAdmin();

				//Check for droppables
				if(item.find('.ipt_uif_builder_drop_here').length) {
					methods.builderDroppables.apply(item.get(0), [container]);
				}

				//Apply the Settings Event - not necessary since delegated
				//methods.builderElementSettingsEvent.apply(item.get(0), [container]);

				//Show it
				item.slideDown('fast');

				//Update the keys
				$(container).data('ipt_uif_builder_keys', keys);
			}

			$(this).removeClass('ipt_uif_builder_drop_here_empty');

			if(typeof(callback) == 'function') {
				callback();
			}
		},

		quote : function(str) {
			return str.replace(/([.?*+^$[\]\\(){}|-])/g, "\\$1");
		},

		testImage : function(filename) {
			return (/\.(gif|jpg|jpeg|tiff|png)$/i).test(filename);
		},

		destroyScrollBar : function() {
			$(this).mCustomScrollbar('destroy');
		},

		updateScrollBar : function() {
			$(this).mCustomScrollbar('update');
		},
		reinitParentScroll : function() {
			//Reinit the scrollbar
			var parent_scrolls = $(this).parents('.ipt_uif_tabs_scroll, .ipt_uif_scroll'); //
			//console.log(parent_scrolls);
			parent_scrolls.each(function() {
				methods.updateScrollBar.apply(this);
			});
		},
		reinitTBAnchors : function() {
			var tbWindow = $('#TB_window'), width = $(window).width(), H = $(window).height(), W = ( 1024 < width ) ? 1024 : width, adminbar_height = 0;

			if ( $('body.admin-bar').length )
					adminbar_height = 28;

			if ( tbWindow.size() ) {
					tbWindow.width( W - 50 ).height( H - 45 - adminbar_height );
					$('#TB_iframeContent').width( W - 50 ).height( H - 75 - adminbar_height );
					$('#TB_ajaxContent').width( W - 80 ).height( H - 95 - adminbar_height );
					tbWindow.css({'margin-left': '-' + parseInt((( W - 50 ) / 2),10) + 'px'});
					if ( typeof document.body.style.maxWidth != 'undefined' )
							tbWindow.css({'top': 20 + adminbar_height + 'px','margin-top':'0'});
			};

			return $('a.thickbox').each( function() {
					var href = $(this).attr('href');
					if ( ! href ) return;
					href = href.replace(/&width=[0-9]+/g, '');
					href = href.replace(/&height=[0-9]+/g, '');
					$(this).attr( 'href', href + '&width=' + ( W - 80 ) + '&height=' + ( H - 85 - adminbar_height ) );
			});
		}
	};

	$.fn.iptPluginUIFAdmin = function(method) {
		if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof(method) == 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.iptPluginUIFAdmin');
			return this;
		}
	};
})(jQuery);

jQuery(document).ready(function($) {
	$('.ipt_uif').iptPluginUIFAdmin();
	$(document).iptPluginUIFAdmin('reinitTBAnchors');
});
