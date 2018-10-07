<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Utils;

/**
 * Class Util
 * Classe qui contient les fonctions spécifiques nécéssaires
 */
class Util
{
    /**
     * Génération slug
     * @param string $_string
     * @param string $_separator
     * @return string
     */
    public static function slug($_string, $_separator = '-')
    {
        $_accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $_special_cases = array( '&' => 'and', "'" => '');

        $_string = mb_strtolower(trim($_string), 'UTF-8');
        $_string = str_replace(array_keys($_special_cases), array_values($_special_cases), $_string);
        $_string = preg_replace($_accents_regex, '$1', htmlentities( $_string, ENT_QUOTES, 'UTF-8'));
        $_string = preg_replace("/[^a-z0-9]/u", "$_separator", $_string);
        $_string = preg_replace("/[$_separator]+/u", "$_separator", $_string);

        return $_string;
    }

    /**
     * Différence heure entre deux dates
     * @param \DateTime $_datetime_debut
     * @param \DateTime $_datetime_fin
     * @param $_precision
     * @return float
     */
    public static function getHourDiffBetweenTwoDates($_datetime_debut, $_datetime_fin, $_precision = 1)
    {
        // Convert them to timestamps.
        $_datetime_debut_timestamp = strtotime($_datetime_debut->format('Y-m-d H:i:s'));
        $_datetime_fin_timestamp   = strtotime($_datetime_fin->format('Y-m-d H:i:s'));

        $_diff  = $_datetime_fin_timestamp - $_datetime_debut_timestamp;
        $_hours = round($_diff / (60 * 60), $_precision);

        return $_hours;
    }

    /**
     * Récupérer le nombre de jour de travail (weekend et férié exclus)
     * @param string $_start_date (format Y-m-d)
     * @param string $_end_date (format Y-m-d)
     * @param array $_holidays
     * @return float|int
     */
    public static function getWorkingDays($_start_date, $_end_date, $_holidays = []) {
        // do strtotime calculations just once
        $_end_date = strtotime($_end_date);
        $_start_date = strtotime($_start_date);
        //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
        //We add one to inlude both dates in the interval.
        $_days = ($_end_date - $_start_date) / 86400 + 1;
        $_no_full_weeks = floor($_days / 7);
        $_no_remaining_days = fmod($_days, 7);
        //It will return 1 if it's Monday,.. ,7 for Sunday
        $_the_first_day_of_week = date("N", $_start_date);
        $_the_last_day_of_week = date("N", $_end_date);
        //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
        //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
        if ($_the_first_day_of_week <= $_the_last_day_of_week) {
            if ($_the_first_day_of_week <= 6 && 6 <= $_the_last_day_of_week) 
                $_no_remaining_days--;
            if ($_the_first_day_of_week <= 7 && 7 <= $_the_last_day_of_week) 
                $_no_remaining_days--;
        } else {
            // (edit by Tokes to fix an edge case where the start day was a Sunday
            // and the end day was NOT a Saturday)
            // the day of the week for start is later than the day of the week for end
            if ($_the_first_day_of_week == 7) {
                // if the start date is a Sunday, then we definitely subtract 1 day
                $_no_remaining_days--;
                if ($_the_last_day_of_week == 6) {
                    // if the end date is a Saturday, then we subtract another day
                    $_no_remaining_days--;
                }
            } else {
                // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
                // so we skip an entire weekend and subtract 2 days
                $_no_remaining_days -= 2;
            }
        }
        //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
        //---->february in none leap years gave a remainder of 0 but still calculated weekends between first
        // and last day, this is one way to fix it
        $_working_days = $_no_full_weeks * 5;
        if ($_no_remaining_days > 0) {
            $_working_days += $_no_remaining_days;
        }
        //We subtract the holidays
        foreach($_holidays as $_holiday){
            $_time_stamp = strtotime($_holiday);
            //If the holiday doesn't fall in weekend
            if ($_start_date <= $_time_stamp && $_time_stamp <= $_end_date && date("N",$_time_stamp) != 6 
                && date("N",$_time_stamp) != 7)
                $_working_days--;
        }
        
        return $_working_days;
    }
}
