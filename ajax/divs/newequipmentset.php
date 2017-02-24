<?php
include "../../inc/session_test.php";
include "basemessages.php";
?>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
$(document).ready(function () {
	// Prevent all form submits as we use ajax
	$("#newfrm").submit(function (event) {
		event.preventDefault();
	});

	$("#newfrm").validate({
		// No error message
		errorPlacement: function (error, element) {
			$(element).prop("title", $(error).text())
		},
		rules: {
			eqsdescription: "required",
		},
	});

	$("#btnnew").click(function () {
		if ($("#newfrm").valid() == true) {
			$.ajax({
				url: "ajax/inserts/newequipmentset.php",
				type: "POST",
				data: {
					eqsdescription: $("#eqsdescription").val(),
					token: '<?php echo $_SESSION['atoken']; ?>',
				},
				success: function (data) {
					if ($.isNumeric(data)) {
						$.alert('NEW EQUIPMENT SET CREATED: ID ' + data);
						$("#newitem").fadeOut();
						$("#workspace").load("equipment.php");
					} else {
						$.alert('<?php echo QUERYERROR; ?>' + data);
					}
				},
				error: function (data) {
					$.alert('<?php echo AJAXERROR; ?>');
				},
			})
		} else {
			$.alert('<?php echo CHECKFORM; ?>');
		}
	});
})
</script>
</head>
<body>
<button onclick="$('#newitem').fadeOut();" class="closebutton">X</button>
<form name="newfrm" id="newfrm">
<div>
<label class="newitemlabel">Set Description:</label> <input type="text" name="eqsdescription" id="eqsdescription" style="width: 200px" autocomplete=""><br><br>
</div>
<div style="text-align: center; width: 100%">
<input type="button" name="btnnew" id="btnnew" value="CREATE NEW <?php echo $_REQUEST['btntext']; ?>">
</div>
</form>
</body>
</html>