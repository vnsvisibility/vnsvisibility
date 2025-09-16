<?php
class Blogone_Section_Plus extends WP_Customize_Section{

    public $type = 'blogone-pro';
    public $plus_text = '';
    public $plus_url = '';
	public $id = '';
  
    public function json() {
        $json = parent::json();
        $json['plus_text'] = $this->plus_text;
        $json['plus_url']  = $this->plus_url;
	    $json['id'] = $this->id;
        return $json;
    }

    protected function render_template() { ?>

        <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
            <h3><a href="{{ data.plus_url }}" target="_blank">{{{ data.plus_text }}}</a></h3>
        </li>
    <?php }
}