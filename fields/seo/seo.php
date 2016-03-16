<?php
class SeoField extends BaseField {
	static public $fieldname = 'seo';
	static public $assets = array(
		'js' => array(
			'script.js',
		),
		'css' => array(
			'style.css',
		)
	);

	public function input() {
		// Load template with arguments
		$html = tpl::load( __DIR__ . DS . 'template.php', $data = array(
			'field' => $this,
			'page' => $this->page()
		));
		return $html;
	}

	// Connecting PHP to Javascript - https://forum.getkirby.com/t/panel-field-javascript-click-does-not-work-after-save/3474/7
	public function element() {
		$element = parent::element();
		$element->data('field', self::$fieldname);
		return $element;
	}

	// Routes - Makes Ajax possible - https://forum.getkirby.com/t/routing-in-custom-form-field/3101/7
	public function routes() {
		return array(
			array(
				'pattern' => 'ajax/(:any)/(:any)',
				'method'  => 'get',
				'action' => function($var1, $var2) {
					return response::json( array( $var1, $var2 ) );
				}
			)
		);
	}

	// Default value fallback
	public function val() {
		if($this->value() == "" && $this->default() !== "") {
			$value = $this->default();
		} elseif($this->value() == "" && $this->default() == "") {
			$value = "";
		} else {
			$value = $this->value();
		}
		return $value;
	}
}