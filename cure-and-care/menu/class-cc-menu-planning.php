<?php

class CCMenuPlanning {

public static function dashboard_planning_and_price_shortcode() {
        ob_start();
        require_once get_theme_file_path() . '/cure-and-care/partials/dashboard-planning-and-price.php';
        return ob_get_clean();
    }


}