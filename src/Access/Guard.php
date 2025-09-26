<?php

namespace WCL\Access;

class Guard
{
    public function can_view_course(int $user_id, int $course_id): bool
    {
        if (user_can($user_id, 'manage_options')) {
            return true;
        }

        $capability = sprintf('wcl_view_course_%d', $course_id);
        if (user_can($user_id, $capability)) {
            return true;
        }

        $enrolled = get_user_meta($user_id, '_wcl_enrolled_courses', true);
        if (is_array($enrolled)) {
            return in_array($course_id, $enrolled, true);
        }

        return false;
    }
}
