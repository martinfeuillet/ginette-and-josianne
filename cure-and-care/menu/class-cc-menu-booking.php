<?php

class CCMenuBooking {


    public function dashboard_booking_shortcode() {
        ob_start();
        require_once get_theme_file_path() . '/cure-and-care/partials/dashboard-booking.php';
        return ob_get_clean();
    }

}