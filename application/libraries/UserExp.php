<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter User Experience Library
 * Provides methods to automatically detect and find user experience behavior such as
 * detecting the user preferred languaged based on user browser, etc.
 *
 * @package		User Experience
 * @subpackage	Libraries
 * @category	Libraries
 * @author      Liran Tal <liran.tal@gmail.com>
 */

class UserExp {

	private $theme = NULL;
	private $_ci;
	
	// language mapping for non-standard user agents
	// map some langauge code to another
	private $language_mapping = array(
		'iw-il' => 'he',
		'iw' => 'he',
		'en' => 'en-us',
		'us' => 'en-us',
		'en-us' => 'en-us',
		'fr-be' => 'fr',
		'fr-ca' => 'fr',
		'fr-lu' => 'fr',
		'fr-mc' => 'fr',
		'fr-ch' => 'fr',
		'fr' => 'fr',
	);
	
	public $language = 'en-us';

	/**
	 * 
	 * class constructor
	 */
	public function __construct()
	{
		$this->_ci =& get_instance();
		
		// load the session library just in case it hasn't been loaded previously
		$this->_ci->load->library('session');
		
	}
	
	
	
	/**
	 * 
	 * Getter
	 */
	public function language_get() {
		
		return $this->language;
		
	}
	
	
	/**
	 * 
	 * Setter
	 * @param string $lang language string to set
	 */
	public function language_set($lang) {
		
		$this->language = $lang;
		$this->_ci->session->set_userdata('user_language', $lang);
		
	}
	
	
	
	public function language_detect_quick() {
		
		// check first if language value is in session
		$lang = $this->_ci->session->userdata('user_language');
		if ($lang)
			return $lang;

		return false;
		
	}
	
	
	public function language_detect() {

	
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) {
			
			$browser_language = strtolower($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
			$languages = explode(',', $browser_language);
			
			//$languages_vocab = $this->get_languages();
			$lang = false;
			foreach($languages as $browser_lang) {
				
				// if the language code has the ; char in it then we cut the language
				// code up until that char position
				$lang_stop_char = strpos($browser_lang, ';');
				if ($lang_stop_char !== false)
					$browser_lang = substr($browser_lang, 0, $lang_stop_char);

				if (empty($browser_lang))
					continue;
					
				
				if (!isset($this->language_mapping[$browser_lang]))
					continue;
				
				// perform language mapping - map the language the detected to actual languages supported by the app
				$lang_mapped = $this->language_mapping[$browser_lang];
				if ($lang_mapped)
					$browser_lang = $lang_mapped;
					
				// see if we have this language in the vocab
				//if (in_array($browser_lang, $languages_vocab)) {
				// check if this language directory exists
				if (is_dir(APPPATH.'/language/'.$browser_lang)) {
					
					$lang = true;
					$this->language_set($browser_lang);
					
					break;
				}
					
			}
			
			// if no language was found to be available, set english as default
			if (!$lang)
				$this->language_set('en-us');
			
		}
		
		return $this->language_get();
		
	}
	
	

	

	/**
	 * 
	 * Supported languages
	 */
	public function get_languages()
	{
		// pack abbreviation/language array
		$languages = array(
			'af' => 'Afrikaans',
			'sq' => 'Albanian',
			'ar-dz' => 'Arabic (Algeria)',
			'ar-bh' => 'Arabic (Bahrain)',
			'ar-eg' => 'Arabic (Egypt)',
			'ar-iq' => 'Arabic (Iraq)',
			'ar-jo' => 'Arabic (Jordan)',
			'ar-kw' => 'Arabic (Kuwait)',
			'ar-lb' => 'Arabic (Lebanon)',
			'ar-ly' => 'Arabic (libya)',
			'ar-ma' => 'Arabic (Morocco)',
			'ar-om' => 'Arabic (Oman)',
			'ar-qa' => 'Arabic (Qatar)',
			'ar-sa' => 'Arabic (Saudi Arabia)',
			'ar-sy' => 'Arabic (Syria)',
			'ar-tn' => 'Arabic (Tunisia)',
			'ar-ae' => 'Arabic (U.A.E.)',
			'ar-ye' => 'Arabic (Yemen)',
			'ar' => 'Arabic',
			'hy' => 'Armenian',
			'as' => 'Assamese',
			'az' => 'Azeri',
			'eu' => 'Basque',
			'be' => 'Belarusian',
			'bn' => 'Bengali',
			'bg' => 'Bulgarian',
			'ca' => 'Catalan',
			'zh-cn' => 'Chinese (China)',
			'zh-hk' => 'Chinese (Hong Kong SAR)',
			'zh-mo' => 'Chinese (Macau SAR)',
			'zh-sg' => 'Chinese (Singapore)',
			'zh-tw' => 'Chinese (Taiwan)',
			'zh' => 'Chinese',
			'hr' => 'Croatian',
			'cs' => 'Czech',
			'da' => 'Danish',
			'div' => 'Divehi',
			'nl-be' => 'Dutch (Belgium)',
			'nl' => 'Dutch (Netherlands)',
			'en-au' => 'English (Australia)',
			'en-bz' => 'English (Belize)',
			'en-ca' => 'English (Canada)',
			'en-ie' => 'English (Ireland)',
			'en-jm' => 'English (Jamaica)',
			'en-nz' => 'English (New Zealand)',
			'en-ph' => 'English (Philippines)',
			'en-za' => 'English (South Africa)',
			'en-tt' => 'English (Trinidad)',
			'en-gb' => 'English (United Kingdom)',
			'en-us' => 'English (United States)',
			'en-zw' => 'English (Zimbabwe)',
			'en' => 'English',
			'us' => 'English (United States)',
			'et' => 'Estonian',
			'fo' => 'Faeroese',
			'fa' => 'Farsi',
			'fi' => 'Finnish',
			'fr-be' => 'French (Belgium)',
			'fr-ca' => 'French (Canada)',
			'fr-lu' => 'French (Luxembourg)',
			'fr-mc' => 'French (Monaco)',
			'fr-ch' => 'French (Switzerland)',
			'fr' => 'French (France)',
			'mk' => 'FYRO Macedonian',
			'gd' => 'Gaelic',
			'ka' => 'Georgian',
			'de-at' => 'German (Austria)',
			'de-li' => 'German (Liechtenstein)',
			'de-lu' => 'German (Luxembourg)',
			'de-ch' => 'German (Switzerland)',
			'de' => 'German (Germany)',
			'el' => 'Greek',
			'gu' => 'Gujarati',
			'he' => 'Hebrew',
			'iw' => 'Hebrew',
			'iw-il' => 'Hebrew',
			'hi' => 'Hindi',
			'hu' => 'Hungarian',
			'is' => 'Icelandic',
			'id' => 'Indonesian',
			'it-ch' => 'Italian (Switzerland)',
			'it' => 'Italian (Italy)',
			'ja' => 'Japanese',
			'kn' => 'Kannada',
			'kk' => 'Kazakh',
			'kok' => 'Konkani',
			'ko' => 'Korean',
			'kz' => 'Kyrgyz',
			'lv' => 'Latvian',
			'lt' => 'Lithuanian',
			'ms' => 'Malay',
			'ml' => 'Malayalam',
			'mt' => 'Maltese',
			'mr' => 'Marathi',
			'mn' => 'Mongolian (Cyrillic)',
			'ne' => 'Nepali (India)',
			'nb-no' => 'Norwegian (Bokmal)',
			'nn-no' => 'Norwegian (Nynorsk)',
			'no' => 'Norwegian (Bokmal)',
			'or' => 'Oriya',
			'pl' => 'Polish',
			'pt-br' => 'Portuguese (Brazil)',
			'pt' => 'Portuguese (Portugal)',
			'pa' => 'Punjabi',
			'rm' => 'Rhaeto-Romanic',
			'ro-md' => 'Romanian (Moldova)',
			'ro' => 'Romanian',
			'ru-md' => 'Russian (Moldova)',
			'ru' => 'Russian',
			'sa' => 'Sanskrit',
			'sr' => 'Serbian',
			'sk' => 'Slovak',
			'ls' => 'Slovenian',
			'sb' => 'Sorbian',
			'es-ar' => 'Spanish (Argentina)',
			'es-bo' => 'Spanish (Bolivia)',
			'es-cl' => 'Spanish (Chile)',
			'es-co' => 'Spanish (Colombia)',
			'es-cr' => 'Spanish (Costa Rica)',
			'es-do' => 'Spanish (Dominican Republic)',
			'es-ec' => 'Spanish (Ecuador)',
			'es-sv' => 'Spanish (El Salvador)',
			'es-gt' => 'Spanish (Guatemala)',
			'es-hn' => 'Spanish (Honduras)',
			'es-mx' => 'Spanish (Mexico)',
			'es-ni' => 'Spanish (Nicaragua)',
			'es-pa' => 'Spanish (Panama)',
			'es-py' => 'Spanish (Paraguay)',
			'es-pe' => 'Spanish (Peru)',
			'es-pr' => 'Spanish (Puerto Rico)',
			'es-us' => 'Spanish (United States)',
			'es-uy' => 'Spanish (Uruguay)',
			'es-ve' => 'Spanish (Venezuela)',
			'es' => 'Spanish (Traditional Sort)',
			'sx' => 'Sutu',
			'sw' => 'Swahili',
			'sv-fi' => 'Swedish (Finland)',
			'sv' => 'Swedish',
			'syr' => 'Syriac',
			'ta' => 'Tamil',
			'tt' => 'Tatar',
			'te' => 'Telugu',
			'th' => 'Thai',
			'ts' => 'Tsonga',
			'tn' => 'Tswana',
			'tr' => 'Turkish',
			'uk' => 'Ukrainian',
			'ur' => 'Urdu',
			'uz' => 'Uzbek',
			'vi' => 'Vietnamese',
			'xh' => 'Xhosa',
			'yi' => 'Yiddish',
			'zu' => 'Zulu'
		);

		return $languages;
	}
	
	
}
