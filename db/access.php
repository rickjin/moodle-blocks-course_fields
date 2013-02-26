<?php
/**
 * *************************************************************************
 * *                  Course Fields Block                                 **
 * *************************************************************************
 * @copyright   emeneo.com                                                **
 * @link        emeneo.com                                                **
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later  **
 * *************************************************************************
 * ************************************************************************
*/
$capabilities = array(
    // Admin capability is assigned to the admin role as default.
    'block/course_fields:admin' => array(
        'riskbitmask' => RISK_PERSONAL,
        'captype' => 'write',
        'contextlevel' => CONTEXT_COURSE,
        'legacy' => array(
            'manager'             => CAP_ALLOW,
			'teacher'             => CAP_ALLOW
        )
    )
);
