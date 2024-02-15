<?php

require_once get_theme_file_path() . '/cure-and-care/menu/class-cc-menu-planning.php';

require_once get_theme_file_path() . '/cure-and-care/menu/class-cc-menu-booking.php';

// Add shortcode for dashboard planning and price
add_shortcode('dashboard_planning_and_price', array('CCMenuPlanning', 'dashboard_planning_and_price_shortcode'));

// Add shortcode for dashboard booking
add_shortcode('dashboard-booking', array('CCMenuBooking', 'dashboard_booking_shortcode'));

