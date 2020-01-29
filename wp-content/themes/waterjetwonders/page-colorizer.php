<?php
/**
 * Template Name: SVG Colorizer
 *
 */

get_header(); 

?>

<style type="text/css">
	g { cursor: pointer; }
	g#color-1 path.cls-1 {
		fill: transparent;
	}
</style>


<script type="text/javascript">
	var svgObject = new Object();
	var selectedArea = "color-1";
	
	// get the name of the given object property
	function propName(obj, prop){
		for(var i in obj) {
			 if (obj[i] == prop){ return i;  }
		}
		return false;
	}
	
	jQuery(document).ready(function(){
		jQuery("svg g").each(function(index){
			svgObject[jQuery(this).attr('id')] = "";
		});
		
		jQuery('select').on('change', function() {
			jQuery("#"+selectedArea).css("fill","url(#"+this.value+")");
		});
		
      // When svg area is clicked on, that's going to be our selection
		jQuery("#selection span").text(selectedArea);
		jQuery("g").on("click", function(){
			selectedArea = jQuery(this).attr('id');
			jQuery("#selection span").text(selectedArea);
		});
	});

</script>

<div class="container">
	<h1 id="selection">Selecting Pattern for <span></span></h1>

<?php 

function array_push_assoc($array, $key, $value){
   $array[$key] = $value;
   return $array;
}

// We pull all the directory names to get the dropdown categories, and then the contents for the patterns themselves
$categories = array_filter(glob('wp-content/themes/waterjetwonders/img/patterns/*'), 'is_dir');
$masterPatternArray = [];
	
foreach($categories as $path) {
	$name = trim(substr($path, strrpos($path, '/') + 1));
	$patternPaths = glob($path . "/*{jpg,gif,png}", GLOB_BRACE);
	$patternNames = [];
	foreach($patternPaths as $pattern) {
		array_push($patternNames, pathinfo($pattern, PATHINFO_FILENAME));
	}
	$patternArray = array_combine($patternNames, $patternPaths);
   $masterPatternArray = array_merge ( $masterPatternArray, $patternArray );
	$dropDown = "<label for='".$name."'>".ucfirst($name)."</label><select id='".$name."'><option value='blank'>--Select One--</option>";
	foreach($patternArray as $key => $value) {
		$dropDown .= "<option value='".$key."'>".ucwords(str_replace("-", " ", $key))."</option>";
	}
	$dropDown .= "</select>";
	echo($dropDown);
}



if (have_posts()) : while (have_posts()) : the_post();
	if ( get_field('svg_body') ) {
		// The initial bit of the svg will have all the patterns that are possible for the colorizer
		$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 612 612"><defs>';
		foreach($masterPatternArray as $key => $value) {
			$svg .= '<pattern xmlns="http://www.w3.org/2000/svg" id="'.$key.'" patternUnits="userSpaceOnUse" width="400" height="400"><image xlink:href="http://wtjwonders.local/'.$value.'" x="0" y="0" width="400" height="400"/></pattern>';
		}
		$svg .= '<style>.cls-1{fill:#fff;}</style></defs><title>Baton-Rouge</title>';
		// The second part of the svg is what we pull from our created svg files
		$svg .= get_field('svg_body');
		echo($svg);
	}
?>

<?php endwhile; ?>
<?php endif; ?>

</div>


<?php get_footer(); ?>