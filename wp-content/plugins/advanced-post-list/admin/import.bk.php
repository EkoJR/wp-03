<?php

function apl_import()
{
    check_ajax_referer("APL_import");
    
    $TMPpresetDbObj = get_option('APL_TMP_import_presetDbObj');
    $presetDbObj = new APLPresetDbObj('default');
    $overwrite_list = explode(',', $_GET['overwrite']);
    
    foreach ($TMPpresetDbObj->_preset_db as $tmp_preset_name => $tmp_preset_value)
    {
        //ADD MISSING
        if (!isset($presetDbObj->_preset_db->$tmp_preset_name))
        {
            $presetDbObj->_preset_db->$tmp_preset_name = $tmp_preset_value;
        }
        //ADD TO CONFIRM OVERWRITE LIST {OBJECT}
        else
        {
            foreach ($overwrite_list as $value)
            {
                if ($tmp_preset_name == $value)
                {
                    $presetDbObj->_preset_db->$tmp_preset_name = $tmp_preset_value;
                    break;
                }
            }
        }
    }
    $presetDbObj->options_save_db;
    delete_option('APL_TMP_import_presetDbObj');
}



	// TODO CREATE AN AJAX FUNCTION TO IMPORT DATA TO THE PLUGIN
	// COULDN'T FIND A WAY TO CARRY THE $_FILES GLOBAL VARIBLE
	// THROUGH .post TO TARGET PHP CODE.
	/**
	 * Summary.
	 *
	 * (Un-used) Handles the AJAX function for importing data. Method used when
	 * jQuery.post is called in javascript for $('#frmImport').submit().
	 *
	 * STEP 1 - Check wp_create_nonce value.
	 * STEP 2 - Return data (if any) as a JSON string.
	 *
	 * @since 0.2.0
	 * @since 0.3.0 - Fixed major bugs, added multi-file uploading, better error
	 *                handling.
	 *
	 * @see APL_Preset_Db class
	 * @see APLUpdater
	 *
	 * @return void JSON string to import.
	 */
/*
	public function hook_action_ajax_import() {
		check_ajax_referer( 'APL_handler_import' );
		$rtn_data                      = new stdClass();
		$rtn_data->_msg                = 'success';
		$rtn_data->_error              = '';
		$rtn_data->_preset_db          = new stdClass();
		$rtn_data->overwrite_preset_db = new stdClass();

		$temp_preset_db = new APL_Preset_Db();

		if ( 'kalin' === $_POST['import_type'] ) {
			// GET KALIN'S POST LIST DATA.
			$kalin_preset_db = get_option( 'kalinsPost_admin_options' );
			if ( false === $kalin_preset_db ) {
				$rtn_data->_msg = 'failure';
				$rtn_data->_error .= 'Can\'t load Kalin\'s Post List data - Database may be missing or plugin is not installed.<br />';
			} else {
				// UPGRADE.
				$updater = new APLUpdater( 'kalin', $kalin_preset_db );
				if ( null === $updater->presetDbObj ) {
					$rtn_data->_msg = 'failure';
					$rtn_data->_error .= 'Can\'t upgrade Kalin\'s Post List - Unknown, may be a currupt data.<br />';
				} else {
					// MERGE TOGETHER.
					foreach ( $updater->presetDbObj->_preset_db as $preset_name => $preset_obj ) {
						if ( ! isset( $temp_preset_db->_preset_db->$preset_name ) ) {
							$temp_preset_db->_preset_db->$preset_name = $preset_obj;
						}
					}
				}
			}
		} elseif ( 'file' === $_POST['import_type'] ) {
			foreach ( $_FILES as $key => $value ) {
				// GET FILE CONTENT.
				$file_preset_db[ $key ] = json_decode( file_get_contents( $value['tmp_name'] ) );
				if ( is_null( $file_preset_db[ $key ] ) ) {
					$rtn_data->_msg = 'failure';
					$rtn_data->_error .= 'Can\'t load file ' . $value['name'] . ' - Syntax Error with JSON encoding inside file.<br />';
				} else {
					// UPGRADE.
					$updater = new APLUpdater( $file_preset_db[ $key ]->version, $file_preset_db[ $key ]->presetDbObj );
					if ( null === $updater->presetDbObj ) {
						$rtn_data->_msg = 'failure';
						$rtn_data->_error .= 'Can\'t upgrade file ' . $value['name'] . ' - Version number is missing, or no preset table was found; may be a currupted file.<br />';
					} else {
						// MERGE TOGETHER.
						foreach ( $updater->presetDbObj->_preset_db as $preset_name => $preset_obj ) {
							if ( ! isset( $temp_preset_db->_preset_db->$preset_name ) ) {
								$temp_preset_db->_preset_db->$preset_name = $preset_obj;
							}
						}
					}
				}
			}
		} else {
			$rtn_data->_msg = 'failure';
			$rtn_data->_error = 'No \'Imput Type\' selected. Choose between either Kalin\'s Post List or upload a file from Advanced Post List';
		}// End if().

		// LOAD PLUGIN PRESETS.
		$preset_db = new APL_Preset_Db( 'default' );
		$overwrite_preset_db = new stdClass();
		// COMPARE PLUGIN DB WITH UPLOAD DATA.
		foreach ( $temp_preset_db->_preset_db as $tmp_preset_name => $tmp_preset_value ) {
			// ADD MISSING.
			if ( ! isset( $preset_db->_preset_db->$tmp_preset_name ) ) {
				$preset_db->_preset_db->$tmp_preset_name = $tmp_preset_value;
			} else {
				// ADD TO CONFIRM OVERWRITE LIST {OBJECT}.
				$overwrite_preset_db->$tmp_preset_name = $tmp_preset_value;
			}
		}

		// SEND UPDATED AND POSSIBLE OVERWRITES TO UPDATE THE PRESET TABLE IN JS.
		$rtn_data->_preset_db = $preset_db->_preset_db;
		$rtn_data->overwrite_preset_db = $overwrite_preset_db;

		// STORE TEMP PRESET DATABASE OBJECT TO BE USED IN import.php.
		// DO NOT SAVE HERE - SAVE IN FINAL IMPORT @ import.php.
		// JUST A NOTE FOR FUTURE MODIFICATIONS.
		update_option( 'APL_TMP_import_presetDbObj', $temp_preset_db );

		// CREATE NEW AJAX NONCE VALUES.
		$rtn_data->action = 'APL_import';
		$rtn_data->_ajax_nonce = wp_create_nonce( 'APL_import' );

		echo json_encode( $rtn_data );
	}
	*/
?>
