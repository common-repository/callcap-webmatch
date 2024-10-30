<?php

	$pluginURL = plugins_url();
	$aSafeURI = explode('&', $_SERVER['REQUEST_URI']); // strip extra url variables beyond ?page=webmatch-options
	$safeURI = $aSafeURI[0];

	// handle URL actions
	switch ($_GET['action']) {
		case "delete":
			$id = $_GET['id'];
			$cacheCampaign = get_option('callcap_campaigns');
			unset($cacheCampaign[$id]);
			$cacheCampaign = array_values($cacheCampaign);
			update_option('callcap_campaigns', $cacheCampaign);
			echo "<script>window.location.replace('".$safeURI."');</script>";
			break;
	}

?>

<div class="wrap">
  <h2>Webmatch Options</h2>

  <form method="post" action="options.php">
		<?php

			settings_fields( 'webmatch_menu_settings_group' );
			do_settings_sections( 'webmatch_menu_settings_group' );

			// put the entire array of campaigns into a PHP array
			$aCampaign = get_option('callcap_campaigns');

		?>

		<div class="webmatchContainer">

			<div class="campaignListContainer">
				<?php
					if (empty($aCampaign)) {
					 	echo '<div class="callcapButton newCampaignButton button button-primary">Add a campaign</div>';
						echo '<div style="padding:15px 0;"><i>No active campaigns</i></div>';
					} else {
						$listIterator = 0;
						echo '<div class="callcapButton newCampaignButton button button-primary">Add another campaign</div>';

				?>
						<div class="campaignListTitle">

							<h3>Existing Campaigns</h3>

						</div>

							<?php
								// loop through all available campaigns
								foreach ($aCampaign as $key => $campaign) {

									// Create some variables to help clarify terminology to the user
									if ($campaign['phone_format'] == "paren") { $phoneFormat = "(555) 555-5555"; $parenSelected = "selected"; } elseif ($campaign['phone_format'] == "dash") { $phoneFormat = "555-555-5555"; $dashSelected = "selected"; }
									if ($campaign['phone_link']=="true") { $phoneLink = "On"; $phoneLinkOn = "selected"; } else { $phoneLink = "Off"; $phoneLinkOff = "selected"; }
									if ($campaign['utm_tags'] || $campaign['utm_option'] == "load_utm_parameters") { $utmTagsChecked = "checked"; $utmTagsStatus = "Enabled"; } else { $utmTagsStatus = "Disabled"; }
									if ($campaign['pull_parameters'] || $campaign['utm_option'] == "pull_parameters") { $pullParametersChecked = "checked"; $pullparametersStatus = "Enabled"; } else { $pullparametersStatus = "Disabled"; }
									if ($campaign['utm_term_for_search']) { $utmSearchChecked = "checked"; $utmSearchStatus = "Enabled"; } else { $utmSearchStatus = "Disabled"; }

									if ($campaign['campaign_type'] == "static") {
										$campaignTypeDisplay = "Campaign ID";
										$campaignType = "Static";
									} elseif ($campaign['campaign_type'] == "dynamic") {
										$campaignTypeDisplay = "Rotator ID";
										$campaignType = "Dynamic";
									}

									$utmOptionPretty = "";
									if ($campaign['utm_option'] == "pull_parameters") { $utmOptionPretty = "Pull Parameters"; }
									if ($campaign['utm_option'] == "load_utm_parameters") { $utmOptionPretty = "Load UTM Parameters"; }

							?>
									<div class="campaignListItem">
										<h4 class="campaignData_<?php echo $listIterator; ?>"><?php echo $campaign['campaign_label']; ?></h4>
										<input type="text" class="campaignEdit_<?php echo $listIterator; ?> callcapHide" name="callcap_campaigns[<?php echo $listIterator; ?>][campaign_label]" value="<?php echo $campaign['campaign_label']; ?>" />

										<ul class='campaignDetails'>
											<li><b><?php echo $campaignTypeDisplay; ?>:</b> <?php echo $campaign['campaign_id']; ?></li>
											<li><b>Campaign Type:</b> <?php echo $campaignType; ?></li>

											<?php

												echo "<li>
																<b>Phone Format:</b>
																<span class='campaignData_".$listIterator."'>".$phoneFormat."</span>
																<select class='campaignEdit_".$listIterator." callcapHide' name='callcap_campaigns[".$listIterator."][phone_format]'>
																	<option value='dash' ".$dashSelected.">555-555-5555</option>
																	<option value='paren' ".$parenSelected.">(555) 555-5555</option>
																</select>
															</li>";

												echo "<li>
																<b>Phone Link:</b>
																<span class='campaignData_".$listIterator."'>".$phoneLink."</span>
																<select class='campaignEdit_".$listIterator." callcapHide' name='callcap_campaigns[".$listIterator."][phone_link]'>
																	<option value='true' ".$phoneLinkOn.">On</option>
																	<option value='false' ".$phoneLinkOff.">Off</option>
																</select>
															</li>";

												echo "<li>
																<b>Instance Class:</b>
																<span class='campaignData_".$listIterator."'>".$campaign['instance_class']."</span>
																<input type='text' class='campaignEdit_".$listIterator." callcapHide' name='callcap_campaigns[".$listIterator."][instance_class]' value='".$campaign['instance_class']."' />
															</li>";

												echo "<li>
																<b>Parameters:</b>
																<span class='campaignData_".$listIterator."'>".$utmOptionPretty."</span>
																<p class='parameterOptions_".$listIterator."' style='display:none;'>Load UTM Parameters <input id='utm_tags' type='radio' name='callcap_campaigns[".$listIterator."][utm_option]' class='campaignEdit_".$listIterator." callcapHide' ".$utmTagsChecked." value='load_utm_parameters' /></p>
																<p class='parameterOptions_".$listIterator."' style='display:none;'>Pull Parameters <input id='pull_parameters' type='radio' data-iteration='".$listIterator."' name='callcap_campaigns[".$listIterator."][utm_option]' class='campaignEdit_".$listIterator." callcapHide' ".$pullParametersChecked." value='pull_parameters' /></p>
															</li>";

												echo "<li>
																<b>Use UTM Search Term:</b>
																<span class='campaignData_".$listIterator."'>".$utmSearchStatus."</span>
																<input id='utm_term_for_search' type='checkbox' data-iteration='".$listIterator."' name='callcap_campaigns[".$listIterator."][utm_term_for_search]' class='campaignEdit_".$listIterator." callcapHide' ".$utmSearchChecked."/>
															</li>";


												if ($campaign['k'])	{ echo "<li><b>K:</b> ".$campaign['k']."</li>"; }
												if ($campaign['c']) { echo "<li><b>C:</b> ".$campaign['c']."</li>"; }
												if ($campaign['a']) { echo "<li><b>A:</b> ".$campaign['a']."</li>"; }
												if ($campaign['p']) { echo "<li><b>P:</b> ".$campaign['p']."</li>"; }
											?>
										</ul>
										<p id="editExistingCampaignButton_<?php echo $key; ?>" class="editExistingCampaignButton button button-primary" data-key="<?php echo $key; ?>">Edit</p>
										<p id="cancelButton_<?php echo $key; ?>" class="cancelButton button button-primary" style="display:none;" data-key="<?php echo $key; ?>">Cancel</p>
										<p class="deleteExistingCampaignButton button button-primary"><a href="<?php echo $safeURI; ?>&action=delete&id=<?php echo $key; ?>">Delete</a></p>

										<!--
											This is here so these fields resubmit on "submit button" click so we don't submit empty fields and lose old data,
											since we're storing all these things inside an array in a single database cell in wp-options

											Not all fields are here as the editable fields are in the block of code above this comment
											The fields below should not be changed once an account is set up
										-->
										<div class="hiddenFormData callcapHide" id="hiddenFormData_<?php echo $listIterator; ?>">
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][campaign_type]" value="<?php echo $campaign['campaign_type']; ?>" />
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][campaign_id]" value="<?php echo $campaign['campaign_id']; ?>" />
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][k]" value="<?php echo $campaign['k']; ?>" />
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][c]" value="<?php echo $campaign['c']; ?>" />
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][a]" value="<?php echo $campaign['a']; ?>" />
											<input type="hidden" name="callcap_campaigns[<?php echo $listIterator; ?>][p]" value="<?php echo $campaign['p']; ?>" />
										</div>

									</div>
									<div class="campaignSpacer"></div>
							<?php
									$listIterator++;
								}
							?>

				<?php
					}
				?>
			</div> <!-- .campaignListContainer -->
			<div id="addCampaignContainer">
				<div class="addCampaignAnchor"></div>
			</div>
		</div>

		<?php submit_button(); ?>

		<div class="bodyCopyContainer">
			<h2>Help</h2>
			<p>Use of this plugin requires an existing campaign set up in Callcap. For help setting this up, refer to the following documentation, or <a href="https://www.callcap.com/contact/" target="_new">contact us</a> directly.</p>
			<ul>
				<li><a href="//www.callcap.com/features/call-tracking/website-call-tracking/" target="_new">What is Webmatch?</a></li>
				<li><a href="//www.callcap.com/help/webmatch-wordpress/" target="_new">How do I configure this plugin?</a></li>
				<li><a href="//www.callcap.com/help/setup-dynamic-number-rotators/" target="_new">How do I set up a new Dynamic Number Rotator?</a></li>
				<li><a href="//www.callcap.com/help/webmatch/" target="_new">Webmatch technical documentation</a></li>
			</ul>
		</div>

	</form>

</div>

<script>

	jQuery(document).ready(function () {

		// saves the number of elements in the main campaign array as a javascript variable
		newCampaignIterator = <?php echo count($aCampaign); ?>;

		jQuery(".callcapHide").hide();

		// whenever a static/dynamic radio button is clicked
		jQuery("#addCampaignContainer").on("click", "label[for='static']", function() {
			var iteration = jQuery(this).data('iteration');
			jQuery("#campaign_id_title").html("Campaign ID");
			jQuery("#dynamic_options_"+iteration).show();
			jQuery("#campaign_id_input, #campaign_id_title").show();
		});

		// whenever a static/dynamic radio button is clicked
		jQuery("#addCampaignContainer").on("click", "label[for='dynamic']", function() {
			var iteration = jQuery(this).data('iteration');
			jQuery("#campaign_id_title").html("Rotator Code");
			jQuery("#dynamic_options_"+iteration).show();
			jQuery("#campaign_id_input, #campaign_id_title, #campaign_id_input_helper").show();
		});

		// handle the 'x' button that removes a campaign item a user just added by clicking "add a campaign"
		jQuery("#addCampaignContainer").on("click", ".removeCampaignButton", function() {
			var iteration = jQuery(this).data('iteration');
			jQuery("#newCampaignRow_"+iteration).empty();
			console.log("#newCampaignRow_"+iteration);
		});

	  // expand the "help" section when a user is adding a dynamic number rotator
	  jQuery("#show_dynamic_help").click(function() {
    	jQuery("#notes_dynamic_help").slideToggle();
	  });

		// Add a new .newCampaignRow populated with all the fields one needs to add a new campaign.
		// Iterates based on the number of entries already in the main campaign array so we don't overwrite things
		jQuery(".newCampaignButton").click(function() {
			var newCampaignRowData = "<div id='newCampaignRow_"+newCampaignIterator+"' class='newCampaignRow'> <div class='newCampaign' style='background-color:#FFF'> <div class='removeCampaignButton button button-primary' data-iteration='"+newCampaignIterator+"'>X</div> <div class='newCampaignCell'> <h4>Label</h4> <input type='text' name='callcap_campaigns["+newCampaignIterator+"][campaign_label]' value='' placeholder='Label' /> <h4>Campaign Type</h4> <label for='static' data-iteration='"+newCampaignIterator+"'> <input type='radio' id='static' class='' name='callcap_campaigns["+newCampaignIterator+"][campaign_type]' value='static' /> Static </label> <label for='dynamic' data-iteration='"+newCampaignIterator+"'> <input type='radio' id='dynamic' class='' name='callcap_campaigns["+newCampaignIterator+"][campaign_type]' value='dynamic' /> Dynamic </label> <h4 id='campaign_id_title' style='display:none;'>Campaign ID</h4> <input id='campaign_id_input' type='text' name='callcap_campaigns["+newCampaignIterator+"][campaign_id]' value='' placeholder='' style='display:none;' /><p class='helpText'><a id='campaign_id_input_helper' style='display:none;' href='https://www.callcap.com/help/webmatch-wordpress/' target='_new'>Where do I find this?</a></p> </div> <div class='newCampaignCell'> <h4>Phone Format</h4> <select name='callcap_campaigns["+newCampaignIterator+"][phone_format]'> <option value='dash'>555-555-5555</option> <option value='paren'>(555) 555-5555</option> </select> <h4>Phone Link</h4><p class='helpText'>Phone number becomes a clickable link</p> <select name='callcap_campaigns["+newCampaignIterator+"][phone_link]'> <option value='true'>On</option> <option value='false'>Off</option> </select> <span id='dynamic_options_"+newCampaignIterator+"' class='dynamicOptions callcapHide'> <h4>Instance Class</h4><p class='helpText'>The target html class - don't use spaces in this field</p> <input type='text' name='callcap_campaigns["+newCampaignIterator+"][instance_class]' value='callcap_phone_number' placeholder='Instance Class' /> </span> </div> <div class='newCampaignCell'> <h4>Options</h4> <label for='utm_tags'> <input id='utm_tags' type='radio' name='callcap_campaigns["+newCampaignIterator+"][utm_option]' value='load_utm_parameters' /> Load UTM Parameters </label> <label for='pull_parameters'> <input id='pull_parameters' type='radio' data-iteration='"+newCampaignIterator+"' name='callcap_campaigns["+newCampaignIterator+"][utm_option]' value='pull_parameters' /> Pull Parameters </label> <label for='utm_term_for_search'> <input id='utm_term_for_search' type='checkbox' data-iteration='"+newCampaignIterator+"' name='callcap_campaigns["+newCampaignIterator+"][utm_term_for_search]' /> UTM Search Term </label> <br /> <a href='//www.callcap.com/help/webmatch-wordpress/' target='_new'>What are these?</a></div> </div> </div>";
			jQuery(".addCampaignAnchor").after(newCampaignRowData);
			jQuery(".newCampaignButton").html("Add Another Campaign");
			newCampaignIterator++;
		});

	  // handle the "delete" button functionality
	  jQuery(".deleteExistingCampaignButton").click(function() {
			if(!confirm("Are you sure you wish to delete this?")) {
				return false;
			}
	  });

		// handle the "edit" button functionality
		jQuery(".editExistingCampaignButton").click(function() {
			var campaignID = jQuery(this).data("key");
			jQuery("#editExistingCampaignButton_"+campaignID).hide();
			jQuery("#cancelButton_"+campaignID).show();
			jQuery(".campaignEdit_"+campaignID).show();
			jQuery(".parameterOptions_"+campaignID).show();
			jQuery(".campaignData_"+campaignID).hide();
		});

		jQuery(".cancelButton").click(function() {
			var campaignID = jQuery(this).data("key");
			jQuery("#editExistingCampaignButton_"+campaignID).show();
			jQuery("#cancelButton_"+campaignID).hide();
			jQuery(".campaignEdit_"+campaignID).hide();
			jQuery(".parameterOptions_"+campaignID).hide();
			jQuery(".campaignData_"+campaignID).show();
		})



	});

</script>
