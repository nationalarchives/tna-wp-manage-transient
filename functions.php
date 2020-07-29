<?php

/**
 * Deletes all transients that have expired
 *
 * @access public
 * @static
 * @param string $older_than
 * @param bool $safemode
 * @return bool
 */
function purge_expired_transients($older_than = '1 day', $safemode = true)
{

    global $wpdb;
    $older_than_time = strtotime('-' . $older_than);

    /**
     * Only check if the transients are older than the specified time
     */

    if ($older_than_time > time() || $older_than_time < 1) {
        return false;
    }

    /**
     * Get all the expired transients
     *
     * @var mixed
     * @access public
     */
    $transients = $wpdb->get_col(
        $wpdb->prepare("
				SELECT REPLACE(option_name, '_transient_timeout_', '') AS transient_name
				FROM {$wpdb->options}
				WHERE option_name LIKE '\_transient\_timeout\__%%'
					AND option_value < %s
		", $older_than_time)
    );

    /**
     * If safemode is ON just use the default WordPress get_transient() function
     * to delete the expired transients
     */
    if ($safemode) {
        foreach ($transients as $transient) {
            get_transient($transient);
        }
    }

    /**
     * If safemode is OFF the just manually delete all the transient rows in the database
     */
    else {
        $options_names = array();
        foreach ($transients as $transient) {
            $options_names[] = '_transient_' . $transient;
            $options_names[] = '_transient_timeout_' . $transient;
        }
        if ($options_names) {
            $options_names = array_map(array($wpdb, 'escape'), $options_names);
            $options_names = "'" . implode("','", $options_names) . "'";

            $result = $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name IN ({$options_names})");
            if (!$result) {
                return false;
            }
        }
    }

    return $transients;
}

/**
 * Get all transients that have expired
 *
 * @access public
 * @static
 * @return bool
 */
function get_expired_transients()
{

    global $wpdb;
    $older_than_time = strtotime('now' );

    /**
     * Get all the expired transients
     *
     * @var mixed
     * @access public
     */
    $transients = $wpdb->get_col(
        $wpdb->prepare("
				SELECT REPLACE(option_name, '_transient_timeout_', '') AS transient_name
				FROM {$wpdb->options}
				WHERE option_name LIKE '\_transient\_timeout\__%%'
					AND option_value < %s
		", $older_than_time)
    );

    return $transients;
}
