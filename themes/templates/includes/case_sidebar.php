<?php 
	$name 	= $session['firstname'] . " " . $session['lastname'];
	$img 	= ($user['display_image_url'] == "" ? MEDIA_FOLDER ."images/nodefaultphoto.png" : MEDIA_FOLDER . "images/user/" . $user['display_image_url']);
?>

<aside id="sidebar">
	<section id="case_number"><!--This is Dynamic-->
		<ul>
			<li class="case">case number</li>
			<li class="number"><?php echo $case_code; ?></li>
		</ul>
	</section>

	<?php 
		$imgsrc = BASE_FOLDER."themes/images/check-sidebar.png";
		$module	= $_SESSION['tmp_cases'];
	?>
	<?php if($case_notes_active) { ?>
	<nav id="side_bar_menu">
		<section class="accordionButton case_general super_sidebar super-active">
			General
			<?php if(!$module['general']) { $display_general = "display:none;"; } ?>
			<img id="general_sidebar_check" style="<?php echo $display_general; ?>" class="sidebar_check" src="<?php echo $imgsrc; ?>">
		</section>

		<section class="accordionButton case_parties super_sidebar">
			Parties
			<?php if(!$module['parties']) { $display_parties = "display:none;"; } ?>
			<div id="parties_count_sidebar" class="item_count_sidebar" style="<?php echo $display_parties; ?>"><?php echo count($module['parties']); ?></div>

		</section>
		<section id="party_accordion_wrapper" class="accordionContent">
			<div id="party_list_wrapper" style="margin-top:-8%;"></div>
		</section>

		<section class="accordionButton case_incident_description super_sidebar">
			Incident Description
			<?php if(!$module['incident_description']) { $display_incident_description = "display:none;"; } ?>
			<img id="incident_description_sidebar_check" style="<?php echo $display_incident_description; ?>" class="sidebar_check" src="<?php echo $imgsrc; ?>">
		</section>

		<section class="accordionButton case_insurance super_sidebar">
			Insurance
			<?php if(!$module['insurance']) { $display_insurance = "display:none;"; } ?>
			<div id="insurance_count_sidebar" class="item_count_sidebar" style="<?php echo $display_insurance; ?>"><?php echo count($module['insurance']); ?></div>
		</section>
		<section id="insurance_accordion_wrapper" class="accordionContent"><div id="insurance_list_wrapper" class="insurance_list_sidebar"></div></section>

		<section class="accordionButton case_vehicles super_sidebar">
			Vehicles
			<?php if(!$module['vehicles']) { $display_vehicles = "display:none;"; } ?>
			<div id="vehicles_count_sidebar" class="item_count_sidebar" style="<?php echo $display_vehicles; ?>"><?php echo count($module['vehicles']); ?></div>
		</section>
		<section id="vehicles_accordion_wrapper" class="accordionContent"><div id="vehicle_list_wrapper" class="vehicle_list_sidebar"></div></section>
		
		<section class="accordionButton case_injuries_treatments super_sidebar">
			<small>Injuries & Treatments</small>
			<?php if(!$module['injuries_treatments']) { $display_injrtrtmnts = "display:none;"; } ?>
			<img id="injuries_treatments_sidebar_check" style="<?php echo $display_injrtrtmnts; ?>" class="sidebar_check" src="<?php echo $imgsrc; ?>">
		</section>
		<section class="accordionButton case_economic_damages super_sidebar">
			Economic Damages
			<?php if(!$module['economic_damages']) { $display_economic_damages = "display:none;"; } ?>
			<img id="economic_damages_sidebar_check" style="<?php echo $display_economic_damages; ?>" class="sidebar_check" src="<?php echo $imgsrc; ?>">
		</section>
		<section class="accordionButton case_notes super_sidebar">
			Notes
			<?php if(!$module['notes']) { $display_notes = "display:none;"; } ?>
			<img id="notes_sidebar_check" style="<?php echo $display_notes; ?>" class="sidebar_check" src="<?php echo $imgsrc; ?>">
		</section>
	</nav>
	<?php } ?>
</aside>

