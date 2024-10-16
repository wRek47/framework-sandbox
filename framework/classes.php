<?php

class FrameWork {

	public $visits = [];
	public $visitors = [];
    public $users = [];
	
	public $user = ["code" => false, "visit" => false, "visitor" => false];
	
	public function init_user() {
	
		$this->user['code'] = decode_token($_SESSION['token']);
		
		$visits_per_code = array_query_all($this->visits, $this->user['code'], "code");
		$hits_per_code = count($visits_per_code); unset($visits_per_code);
		
		$this->user['visit'] = new Visit($hits_per_code); unset($hits_per_code);
		array_push($this->visits, $this->user['visit']);
		
		$query = array_query_all($this->visitors, $this->user['code'], "code");
		$this->user['visitor'] = new Visitor();
		
		if (empty($query)): array_push($this->visitors, $this->user['visitor']);
		elseif (count($query) == 1):
		
			$visitor = current($query);
			$visitor->signed = $this->user['visitor']->created;
			$visitor->hits++;
			
			$this->user['visitor'] = $visitor; unset($visitor);
		
		elseif (count($query) > 1):
		
			$query = array_query_all($this->visits, $this->user['visit']->ip, "ip");
			var_dump($query); exit;
		
		endif; unset($query);
	
	}

}

class Visit {

    public $id;
    public $code = 0;

    public $datetime = "";
    public $url = "";

    public $ip = "Unknown";
    public $device = "Unknown";
    public $os = "Unknown";
    public $browser = "Unknown";

    public $geo = null;

    public function __construct($id) {
    
        /* $code = generate_code();
        if (!isset($_SESSION['token'])): $_SESSION['token'] = encode_token($code); endif; unset($code); */
        
        $this->code = decode_token($_SESSION['token']);
        $this->id = $id;

        $this->datetime = date("Y-m-d H:i:s");
        $this->url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->ip = $_SERVER['REMOTE_ADDR'];

        # $this->device = null;
        # $this->os = null;
        # $this->browser = null;

        # $this->geo = null;
    
    }

}

class Visitor {

    public $id = 0;

    public $code;
    public $created = "";

    public $signature = "";
	
    public $signed = "";
    public $duration = "PT30M";

    public $hits = 0;

    public function __construct() {
	
        $this->code = decode_token($_SESSION['token']);
		// $this->code = $code;
		// $this->signature = generated_text($prompt, $api = "");
		
		$this->created = time();
		$this->signed = false;
		
		$this->duration = false;
		$this->hits++;
	
	}

}

class Page {

    public $id;
    public $crumb = "";
    public $file = "";

    public $title = "";
    public $description = "";

    // public function __construct($file) { }

}

class Form {

    public $button;
    public $fields = [];

    public $respond = false;
    public $resolved = false;

    public function __construct($button, $fields = []) {
    
        $this->button = $button;
        $this->fields = $fields;

        $button_name = $button->name;
        if (isset($_POST[$button_name])):
        
            $this->respond = true;
        
        endif; unset($button_name);
    
    }

    public function field($name) { return array_query($this->fields, $name, "name"); }

}

class FormButton {

    public $name = "";
    public $text = "";

    public function __construct($name, $text) {
    
        $this->name = $name;
        $this->text = $text;
    
    }

}

class FormField {

    public $type = "";
    public $name = "";
    public $text = "";
    public $placeholder = "";
    public $value = "";

    public function __construct($type, $name, $text, $placeholder = "", $value = "") {
    
        $this->type = $type;
        $this->name = $name;
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->value = $value;

        if (isset($_POST[$name])): $this->value = $_POST[$name]; endif;
    
    }

}

class Table {

    public $local = "";

    public $name = "";
    public $fields = [];

    public $column = "";
    public $rows = [];

    public $row_id;
    public $row;

    public function __construct($name) { $this->name = $name; }

    public function select_one($value, $property) { array_query($this->rows, $value, $property); }
    public function select_all($value, $property) { array_query_all($this->rows, $value, $property); }

    public function insert($row) { array_push($this->rows, $row); }
    
    public function get_row($row_id, $property = null) {
    
        if (!is_null($property)): $row_id = array_query_id($this->rows, $row_id, $property); endif;
        if ($row_id === false OR !key_exists($row_id, $this->rows)): return false; endif;

        $this->row_id = $row_id;
        $this->row = $this->rows[$row_id];

        return $this->row;
    
    }

    public function set_row() { $this->rows[$this->row_id] = $this->row; }

    public function set($property, $value) {
    
        $this->row->$property = $value;
        $this->set_row();
    
    }

    public function unset($property) { unset($this->row->$property); }
    
    public function delete($row_id = null) {
    
        if (is_null($row_id)): $row_id = $this->row_id; endif;
        unset($this->rows[$row_id]);
    
    }

    public function save() {
    
        // var_dump($this->local, $this->rows);
        $data = cursor($this->local)->data;
        if ($data != $this->rows OR $this->rows == ""): $save = export_json(ROOT . $this->local, $this->rows); endif;
        // var_dump(json_decode($save, JSON_PRETTY_PRINT));
    
    }

    // public function saveRow() { }

    public function query($data, $property = "target", $class = null) {
    
        $data = array_query($this->rows, $data, $property);

        if (!is_null($class)):
        
            $data = json_class($data, $class);
        
        endif;

        return $data;
    
    }

    public function query_all($data, $property = "target") {
    
        return array_query_all($this->rows, $data, $property);
    
    }

}

class Navigation {

    public $inner = [];

	public $items = [];
	public $links = [];

    public $attributes = [];

    public $id = false;
    public $class = false;

    public function __construct($links = [], $items = [], $attributes = []) {
    
        $this->links = $links;
        $this->items = $items;

        $this->attributes = $attributes;

        foreach ($this->attributes as $key => $value): $this->$key = $value; unset($key, $value); endforeach;
    
    }

}

class NavLink {

	public $href = "";
	public $text = false;

    public $properties = [];

    public $id = false;
    public $class = false;
    public $target;
    
    public function __construct($href, $text = false, $properties = []) {
    
        $this->href = $href;
        $this->text = ($text) ? $text : $href;

        $this->properties = $properties;

        foreach ($this->properties as $key => $value): $this->$key = $value; unset($key, $value); endforeach;
    
    }

}

class FileSystem {

    public $type;
    public $cwd = "";

    public $local = "";
    public $name = "";
    public $ext;

    public $folders = [];
    public $files = [];

    public $tree = [];
    public $graphs = [];

    public $contents;
    public $data;
    
    public $manifest;

}

class CRUD {

    public $sys;
    public $seed;
    public $row_count;

    public $path = "";
    public $cursor;

    public function __construct($path, &$seed) {
    
        $this->path = $path;
        $this->sys = cursor($path);

        $this->seed =& $seed;
        if (is_array($seed)): $this->row_count = count($seed); endif;

        $is_file = isset($this->sys->ext) ? true : false;
        $is_dir = isset($this->sys->tree) ? true : false;

        if ($is_file):
        elseif ($is_dir):
        endif;
    
    }

    public function set($property, $value) {
    
        # $this->seed->$property = $value;
    
    }

    public function cursor($path) {
    
        # $cursor = cursor($path, $this->seed);
        $this->cursor = &$this->seed[$path];
        return $this->cursor;
    
    }

    public function query_id($value, $property = "target") {
    
        $query_id = array_query_id($this->seed, $value, $property);
        return $query_id;

        # var_dump($query); exit;
    
    }

    public function insert(&$array, $value, $prepend = false) {
    
        if ($prepend): array_unshift($array, $value);
        else: array_push($array, $value);
        endif;

        $id = count($array);
        return $id;
    
    }

    public function create($property, $value, $prepend = false) {
    
        if (is_null($this->seed)): $this->seed = (object) array(); endif;
        
        if (is_object($this->seed)):
        
            if (!isset($this->seed->$property)): $this->update($this->seed->$property, $value);
            elseif (is_array($this->seed->$property)): $id = $this->insert($this->seed->$property, $value);
            endif;
        
        elseif (is_array($this->seed)): $this->insert($this->seed, $value);
        else: $this->update($this->seed, $value);
        endif;

        if (isset($id)): return $id; endif;
        return true;
    
    }

    public function read($property) { return $this->seed->$property; }

    public function update(&$property, $value) {
    
        $property = $value;
    
    }

    public function append($value) {
    
        array_push($this->seed, $value);
    
    }

    public function prepend($value) {
    
        array_unshift($this->seed, $value);
    
    }

    public function delete($property, $value = "&null") {
    
        if ($value != "&null"): $this->update($property, $value);
        else: unset($this->seed->$property); endif;
    
    }

    public function save() { save($this->path, $this->seed); }

}

class Scene {

    public $global;

    public $flashes = [];

}

class Flash {

    public $id = 0;
    public $name = "";

    public $file = "";

    public $exterior = [];
    public $interior;

    public $planes = [];
    public $structures = [];
    public $surfaces = [];

}

class Plane {

    public $scene_id = 0;

    public $id = 0;
    public $name = "";
    public $file = "";
    public $title = "";
    public $description = "";
    
    public $layers = [];

    public $structures = [];
    public $surfaces = [];

}

class Structure {

    public $scene_id = 0;
    public $plane_id = 0;

    public $id = 0;
    public $name = "";
    public $file = "";
    public $title = "";
    public $description = "";
    
    public $surfaces = [];
    public $interior;

}

class Surface {

    public $plane_id = 0;
    
    public $id = 0;

    public $layers = [];
    public $grid = [];

}

//

class Bootstrap {

    public $elements = [];

    public function setElement($key, $value) {
    
        $this->elements[$key] = $value;
    
    }

}

class BootstrapInterface {

    public $type = "hyper";
    public $inner = [];

    public function __construct($inner = [], $type = "hyper") {
    
        $this->inner = $inner;
        $this->type = $type;
    
    }

}

// class BootstrapTemplate { }

class BootstrapElement extends BootstrapInterface {

    public $bootstrap_element_id = 0;

    public $id = "";
    public $class = "";

    public $inner = [];

    public function __construct($id, $class, $inner = []) {
    
        $this->id = $id;
        $this->class = $class;
        
        $this->inner = $inner;
    
    }

}

class BootstrapSection extends BootstrapElement { }
class BootstrapArticle extends BootstrapElement { }

class BootstrapLayout extends BootstrapElement {

    public $grid = [];

    public function __construct($grid = []) { $this->grid = $grid; }

}

class BootstrapGrid extends BootstrapElement { }
class BootstrapGridRow extends BootstrapElement { }
class BootstrapGridRowColumn extends BootstrapElement { }

class BootstrapContainer extends BootstrapElement { }

class BootstrapIcon extends BootstrapElement { }

class BootstrapCard extends BootstrapElement {

    public $header = null;
    public $body = null;
    public $footer = null;

    public function __construct($id, $class, $header = null, $body = null, $footer = null) {
    
        $this->id = $id;
        $this->class = $class;

        $this->header = $header;
        $this->body = $body;
        $this->footer = $footer;
    
    }

}

class BootstrapCardHeader extends BootstrapElement { }
class BootstrapCardBody extends BootstrapElement { }
class BootstrapCardFooter extends BootstrapElement { }

class BootstrapCoin extends BootstrapElement {

    public $slider;
    public $surfaces = [];

    public function __construct($id, $class, $surfaces = [], $slider = null) {
    
        $this->id = $id;
        $this->class = $class;
        $this->slider = $slider;
        $this->surfaces = $surfaces;
    
    }

}

class BootstrapCoinSlider extends BootstrapElement {

    public $step = 1;
    public $min = 0;
    public $max = 180;
    public $value = 0;

    public function __construct($id, $class = "", $value = 0, $min = 0, $max = 180, $step = 1) {
    
        $this->id = $id;
        $this->class = $class;

        $this->value = $value;

        $this->min = $min;
        $this->max = $max;
    
    }

}

class BootstrapCoinSurface extends BootstrapElement {

    public $angle = 0;
    public $title = "";

    public function __construct($id, $class, $inner = []) {
    
        $this->id = $id;
        $this->class = $class;
        $this->inner = $inner;
    
    }

}

class BootstrapNavigation {

    public $id;
    public $class = "";

    public $panels = [];

    public function __construct($class, $panels = [], $id = null) {
    
        $this->id = $id;
        $this->class = $class;

        $this->panels = $panels;
    
    }

}

class BootstrapNavLink {

    public $class = "";
    public $href = "";
    public $target = "";

    public $text = "";

    public function __construct($class, $href, $text, $target = null) {
    
        $this->class = $class;
        $this->href = $href;
        $this->text = $text;

        $this->target = $target;
    
    }

}

class BootstrapTable {

    public $id = "";
    public $class = "";

    public $head;
    public $body;

    public function __construct($id, $class, $head = false, $body = "") {
    
        $this->id = $id;
        $this->class = $class;

        $this->head = $head;
        $this->body = $body;
    
    }

}

class BootstrapTableHead {

    public $class = "";
    public $inner;

    public function __construct($class, $inner = []) {
    
        $this->class = $class;
        $this->inner = $inner;
    
    }

}

class BootstrapTableHeadCell {

    public $class = "";
    public $colspan = 0;

    public $inner = "";

    public function __construct($class, $colspan = 0, $inner = "") {
    
        $this->class = $class;
        $this->colspan = $colspan;

        $this->inner = $inner;
    
    }

}

class BootstrapTableBody {

    public $class = "";
    public $inner;

    public function __construct($class, $inner = []) {
    
        $this->class = $class;
        $this->inner = $inner;
    
    }

}

class BootstrapTableBodyRow {

    public $id = "";
    public $class = "";

    public $inner;

    public function __construct($id, $class, $inner = []) {
    
        $this->id = $id;
        $this->class = $class;

        $this->inner = $inner;
    
    }

}

class BootstrapTableBodyRowCell {

    public $class = "";
    public $colspan = 0;

    public $inner = "";

    public function __construct($class, $colspan = 0, $inner = "") {
    
        $this->class = $class;
        $this->colspan = $colspan;

        $this->inner = $inner;
    
    }

}

class BootstrapForm {

    public $action = "";
    public $method = "POST";

    public $fields = [];
    public $button;

    public function __construct($action, $method, $fields, $button) {
    
        $this->action = $action;
        $this->method = $method;
        $this->fields = !is_array($fields) ? [$fields] : $fields;
        $this->button = $button;
    
    }

}

class BootstrapFormButton {

    public $class = "";
    public $button;

    public function __construct($class, $button) {
    
        $this->class = $class;
        $this->button = $button;
    
    }

}

class BootstrapFormGroup {

    public $id = "";
    public $class = "";

    public $label;
    public $field;

    public function __construct($id, $class, $label, $field) {
    
        $this->id = $id;
        $this->class = $class;

        $this->label = $label;
        $this->field = $field;
    
    }

}

class BootstrapFormGroupLabel {

    public $class = "";
    public $text = "";

    public function __construct($class, $text) {
    
        $this->class = $class;
        $this->text = $text;
    
    }

}

class BootstrapFormGroupField {

    public $class = "";
    public $field;

    public function __construct($class, $field) {
    
        $this->class = $class;
        $this->field = $field;
    
    }

}

?>