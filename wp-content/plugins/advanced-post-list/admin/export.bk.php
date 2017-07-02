<?php

function apl_export()
{
    check_ajax_referer("APL_export");
    $outputFileData = get_option('APL_TMP_export_dataOutput');
    delete_option('APL_TMP_export_dataOutput');
    header('Content-type: application/json');
    header('Content-Disposition: attachment; filename="' . $_GET['filename'] . '.json"');
    
    echo trim(json_encode($outputFileData));
    exit();
}

	/**
	 * Summary.
	 *
	 * Export Hook function.
	 *
	 * STEP 1 - Check AJAX security value.
	 * STEP 2 - Store default data.
	 * STEP 3 - Store the filename and url export file location.
	 * STEP 4 - Echo that in json string.
	 *
	 * @since 0.2.0
	 *
	 * @return void JSON string to export.
	 */
/*
	public function hook_action_ajax_export() {
		// Step 1.
		check_ajax_referer( 'APL_handler_export' );

		$rtn_data = new stdClass();
		// Step 2.
		$rtn_data->_status = 'success';
		$rtn_data->_error = '';

		// Step 3.
		$rtn_data->filename = $_POST['filename'];

		$preset_db = new APL_Preset_Db( 'default' );
		$temp_export_data = new stdClass();
		$temp_export_data->version = APL_VERSION;
		if ( 'database' === $_POST['export_type'] ) {
			$temp_export_data->presetDbObj = $preset_db;
		} elseif ( 'preset' === $_POST['export_type'] ) {
			$preset_name = $_POST['filename'];
			$rtn_data->filename = 'APL.' . $preset_name . '.' . date( 'Y-m-d' );

			$temp_export_data->preset_db = new stdClass();
			$temp_export_data->preset_db->_preset_db = new stdClass();

			$temp_export_data->preset_db->_preset_db->$preset_name = $preset_db->_preset_db->$preset_name;
		} else {
			$rtn_data->_status = 'failure';
			$rtn_data->_error = 'No \'Import Type\' selected - Unknown error';
		}

		update_option( 'APL_TMP_export_dataOutput', $temp_export_data );

		$rtn_data->action = 'APL_export';
		$rtn_data->_ajax_nonce = wp_create_nonce( 'APL_export' );

		// Step 4.
		echo json_encode( $rtn_data );
	}
	*/
?>
