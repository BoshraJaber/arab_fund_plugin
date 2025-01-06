<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package Arab Funds
 * @since 1.0.0
 */

class Arab_Funds_Admin {

	public $scripts;

	//class constructor
	function __construct() {

		global $arab_funds_scripts;

		$this->scripts = $arab_funds_scripts;
	}

	/**
	 * Admin Class
	 *
	 * Custom method to handle all translations strings in Arab funds
	 *
	 * @package Arab Funds
	 * @since 1.0.0
	*/

	function arab_funds_load_all_translation_strings() {
		pll_register_string( 'totalloans', 'TOTAL LOANS MADE', 'arab-funds', false );
		pll_register_string( 'aidprovided', 'THE AID PROVIDED IS TOTAL', 'arab-funds', false );
		pll_register_string( 'privatesector', 'PRIVATE SECTOR', 'arab-funds', false );
		pll_register_string( 'eindicators', 'Economic Indicators', 'arab-funds', false );
		pll_register_string( 'providedaid', 'Aid provided', 'arab-funds', false );
		pll_register_string( 'mainsectors', 'Main projects of the sector', 'arab-funds', false );
		pll_register_string( 'amount-kwd', 'Amount (thousand KWD)', 'arab-funds', false );
		pll_register_string( 'one-housand-kwd', 'One thousand KD*', 'arab-funds', false );
		pll_register_string( 'the-number', 'the number', 'arab-funds', false );
		pll_register_string( 'sr-no', 'Sr No', 'arab-funds', false );
		pll_register_string( 'number', 'NUMBER', 'arab-funds', false );
		pll_register_string( 'signed-loans', 'SIGNED LOANS', 'arab-funds', false );
		pll_register_string( 'extended-grants', 'EXTENDED GRANTS', 'arab-funds', false );
		pll_register_string( 'values', 'VALUES', 'arab-funds', false );
		pll_register_string( '1-kwd-equi', '(٭) 1 KWD Equivalent of about 3.3 US dollars', 'arab-funds', false );
		pll_register_string( '1-kwd-conversion-pay', '(٭٭) The equivalent amount in Kuwaiti dinars according to the conversion rate
		Upon payment', 'arab-funds', false );
		pll_register_string( 'financing-activities', 'Private sector - financing activities as of 12/31/2021', 'arab-funds', false );
		pll_register_string( 'project-status', 'Project Status as of 12/31/2022', 'arab-funds', false );
		pll_register_string( 'equivalent-amount', '(٭) The equivalent amount in Kuwaiti dinars according to the conversion rate upon payment (٭) 1 K. Equivalent to about 3.3 US dollars', 'arab-funds', false );
		pll_register_string( 'thetotal', 'the total', 'arab-funds', false );
		pll_register_string( 'amountindollar', '(Amounts in thousand KD)', 'arab-funds', false );
		pll_register_string( 'readmore-3', 'Read More', 'arab-funds', false );
		pll_register_string( 'show-more', 'Show more', 'arab-funds', false );
		pll_register_string( 'algeriatitle', 'ALGERIA', 'arab-funds', false );
		pll_register_string( 'transport', 'Transport', 'arab-funds', false );
		pll_register_string( 'watersewage', 'Water and Sewage', 'arab-funds', false );
		pll_register_string( 'telecomm', 'Telecomm', 'arab-funds', false );
		pll_register_string( 'socialservice', 'Social Services', 'arab-funds', false );
		pll_register_string( 'othersectors', 'Other Sectors', 'arab-funds', false );
		pll_register_string( 'industrymining', 'Industry and Mining', 'arab-funds', false );
		pll_register_string( 'energy', 'Energy', 'arab-funds', false );
		pll_register_string( 'agriculture', 'Agriculture', 'arab-funds', false );

		//Registering strings for all the macro details on country single page.
		pll_register_string( 'areasq', 'Area (Square Km)', 'arab-funds', false );
		pll_register_string( 'populationx', 'Population (x1000)', 'arab-funds', false );
		pll_register_string( 'gdpcurrent', 'GDP at Current Prices (Million $)', 'arab-funds', false );
		pll_register_string( 'gdppercapita', 'GDP Per Capita ($)', 'arab-funds', false );
		pll_register_string( 'realgdp', 'Real GDP Growth Rate (%)', 'arab-funds', false );
		pll_register_string( 'agriculturevalue', 'Agriculture Value Added (% of GDP)', 'arab-funds', false );
		pll_register_string( 'extractiveindustries', 'Extractive Industries Value Added (% of GDP)', 'arab-funds', false );
		pll_register_string( 'manufacturingindustries', 'Manufacturing Industries Value Added (% of GDP)', 'arab-funds', false );
		pll_register_string( 'servicesector', 'Service Sector Value Added (% of GDP)', 'arab-funds', false );
		pll_register_string( 'inflationrate', 'Inflation Rate (%)', 'arab-funds', false );
		pll_register_string( 'budgetsurplus', 'Budget Surplus/Deficit (% of GDP)', 'arab-funds', false );
		pll_register_string( 'currentaccount', 'Current Account Balance (% of GDP)', 'arab-funds', false );
		pll_register_string( 'adultliteracy', 'Adult Literacy Rate (%)', 'arab-funds', false );
		pll_register_string( 'lifeexpectancy', 'Life Expectancy at Birth (Years)', 'arab-funds', false );
		pll_register_string( 'accesshealth', '% of Population with Access to Health Services', 'arab-funds', false );
		pll_register_string( 'safedrinking', '% of Population with Access to Safe Drinking Water', 'arab-funds', false );
		pll_register_string( 'sanitiationfacilities', '% of Population with Suitable Sanitation Facilities', 'arab-funds', false );
		pll_register_string( 'nationalpoverty', '% of Population Below National Poverty Line', 'arab-funds', false );
		pll_register_string( 'laborforce', 'Labor Force (% of Population)', 'arab-funds', false );
		pll_register_string( 'employmentrate', 'Unemployment Rate (%)', 'arab-funds', false );

		//Project listing page all translations
		pll_register_string( 'selectyear', 'Please select a year', 'arab-funds', false );
		pll_register_string( 'selectsector', 'Please select the sector', 'arab-funds', false );
		pll_register_string( 'selectcountry', 'Please select the country', 'arab-funds', false );

		pll_register_string( 'pgrant', 'Grants', 'arab-funds', false );
		pll_register_string( 'pprivate', 'Private', 'arab-funds', false );
		pll_register_string( 'ploan', 'Loans', 'arab-funds', false );
		pll_register_string( 'pcontribution', 'Contributions', 'arab-funds', false );

		//Ttable headers
		pll_register_string( 'thenum', 'the number','arab-funds', false );
		pll_register_string( 'loannum', 'Loan number','arab-funds', false );
		pll_register_string( 'grantnum', 'Grant number','arab-funds', false );
		pll_register_string( 'projname', 'The Project','arab-funds', false );
		pll_register_string( 'sectname', 'Sector','arab-funds', false );
		pll_register_string( 'gapproval', 'General Approval','arab-funds', false );
		pll_register_string( 'oriamount', 'Original Amount','arab-funds', false );
		pll_register_string( 'amountpaid', 'Amount Paid','arab-funds', false );
		pll_register_string( 'cancelamount', 'Amount cancelled','arab-funds', false );
		pll_register_string( 'thenetamount', 'Net amount','arab-funds', false );

		pll_register_string( 'countrylabel', 'Country','arab-funds', false );
		pll_register_string( 'sectorlabel', 'Sector ','arab-funds', false );
		pll_register_string( 'yearlabel', 'Year','arab-funds', false );
		pll_register_string( 'loanlabel', 'Authorized Public Sector Loans','arab-funds', false );
		pll_register_string( 'grantlabel', 'Extended Grants','arab-funds', false );
		pll_register_string( 'privatelabel', 'Authorized Private Sector Loans','arab-funds', false );

		//All translations for Project Single Page
		pll_register_string( 'loanno', 'Loan No','arab-funds', false );
		pll_register_string( 'beneficiary', 'Beneficiary','arab-funds', false );
		pll_register_string( 'projectcost', 'Project Cost','arab-funds', false );
		pll_register_string( 'projectcost', 'Amount of Loan','arab-funds', false );
		pll_register_string( 'amountloan', 'Amount of Loan','arab-funds', false );
		pll_register_string( 'dobapproval', 'Date of Board Approval','arab-funds', false );
		pll_register_string( 'doloanagreement', 'Date of Loan Agreement','arab-funds', false );
		pll_register_string( 'doloaneffective', 'Date of Loan Effectiveness','arab-funds', false );
		pll_register_string( 'interestrate', 'Interest Rate','arab-funds', false );
		pll_register_string( 'gracep', 'Grace Period','arab-funds', false );
		pll_register_string( 'maturity', 'Maturity','arab-funds', false );
		pll_register_string( 'repayment', 'Repayment','arab-funds', false );
		pll_register_string( 'firstinstall', 'First Installment','arab-funds', false );
		pll_register_string( 'no-projects-found', 'No projects were found according to the search criteria.','arab-funds', false );
		pll_register_string( 'as-in', 'as in','arab-funds', false );
		pll_register_string( 'search-projects-summary', 'Search','arab-funds', false );
		pll_register_string( 'year', 'years','arab-funds', false );
		pll_register_string( 'million', 'million','arab-funds', false );
		pll_register_string( 'amount-kd', 'Amount Paid (KD)','arab-funds', false );
		pll_register_string( 'project', 'Project','arab-funds', false );
		pll_register_string( 'start-date', 'Start Date','arab-funds', false );
		pll_register_string( 'search-input', 'Search input is required.','arab-funds', false );
		pll_register_string( 'total-sum', 'Total','arab-funds', false );

		//pll_register_string( 'year_3_10', 'years','arab-funds', false );
		pll_register_string( 'current-event', 'Current event','arab-funds', false );
		pll_register_string( 'upcoming-event', 'Upcoming event','arab-funds', false );
		pll_register_string( 'cancelled-event', 'Cancelled event','arab-funds', false );
		//pll_register_string( 'homelabel', 'Home','arab-funds', false );
	}


	/**
	 * Adding Hooks
	 *
	 * @package Arab Funds
	 * @since 1.0.0
	 */
	function add_hooks(){
		add_action('plugins_loaded', array($this,'arab_funds_load_all_translation_strings'));
	}
}
?>