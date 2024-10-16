<?php

class Documentation {

    public $subFolder = "";
	public $dataFolder = "";
	public $tables = [];
	public $pages = [];
    public $page;
	
	public $version = 1;
	public $subversion = 0;
	
	public $authors = [];
    public $author;
	public $contributors = [];
	
	public $chapters = [];
	public $contents = [];
	public $glossary = [];
	public $citations = [];
	public $references = [];
	
	public function __construct($version, $folder = "common/database/bootstrap/docs/") {
	
		$this->version = $version;
		$this->dataFolder = $folder;

		$pages = [];
        
		table_system($pages, cursor($folder . "pages.json"), $_TABLE['docsPages']);
		$pages = $_TABLE['docsPages']->rows;
		
		$this->pages = $pages; unset($pages);

		$this->init();

	
	}
	
	public function save_table($table, $property) {
	
		global $_TABLE;

		$table_name = $this->tables[$table];

		if ($table == "docsVersion"): $_TABLE[$table_name]->rows->$property = $this->$property;
		elseif ($table == "docsPages"): # authorization required
		else: $_TABLE[$table_name]->rows = $this->$property;
		endif;

        return $_TABLE[$table_name]->save();
		return true;
	
	}
	
	public function set_table($key, $table_name) {
	
		$this->tables[$key] = $table_name;
	
	}
	
	public function drop_table($key) { unset($this->tables[$key]); }
	
	public function init() {
	
		global $_TABLE;
		
		$this->tables['docsVersions'] = "documentationVersions";
		$config = null;
		table_system($config, cursor($this->dataFolder . "versions.json"), $_TABLE['documentationVersions']);
		$config = $_TABLE['documentationVersions']->rows;

        $version = array_query($config, 1, "id");
		
		$this->tables['docsAuthors'] = "documentationAuthors";
		$authors = [];
		table_system($authors, cursor($version->authors), $_TABLE['documentationAuthors']);
		$authors = $_TABLE['documentationAuthors']->rows;
		
		$this->tables['docsContributors'] = "documentationContributors";
		$contributors = [];
		table_system($contributors, cursor($version->contributors), $_TABLE['documentationContributors']);
		$contributors = $_TABLE['documentationContributors']->rows;

		$this->tables['docsChapters'] = "documentationChapters";
		$chapters = [];
		table_system($chapters, cursor($version->chapters), $_TABLE['documentationChapters']);
		$chapters = $_TABLE['documentationChapters']->rows;
		
		$this->tables['docsContents'] = "documentationContents";
		$contents = [];
		table_system($contents, cursor($version->contents), $_TABLE['documentationContents']);
		$contents = $_TABLE['documentationContents']->rows;

		$this->tables['docsGlossary'] = "documentationGlossary";
		$glossary = [];
		table_system($contents, cursor($version->glossary), $_TABLE['documentationGlossary']);
		$glossary = $_TABLE['documentationGlossary']->rows;
		
		$this->tables['docsCitations'] = "documentationCitations";
		$citations = [];
		table_system($citations, cursor($version->citations), $_TABLE['documentationCitations']);
		$citations = $_TABLE['documentationCitations']->rows;
		
		$this->tables['docsReferences'] = "documentationReferences";
		$references = [];
		table_system($references, cursor($version->references), $_TABLE['documentationReferences']);
		$references = $_TABLE['documentationReferences']->rows;
		
		$this->subversion = $version->subversion;
        $this->subFolder = $version->folder;
		# $this->downloads = $version->download_count;
		
		$this->authors = $authors; unset($authors);
		$this->contributors = $contributors; unset($contributors);
		
		$this->chapters = $chapters; unset($chapters);
		$this->contents = $contents; unset($contents);
		$this->glossary = $glossary; unset($glossary);
		$this->citations = $citations; unset($citations);
		$this->references = $references; unset($references);
	
	}
	
	public function add_author($author) { }
	public function update_author($id, $author) { }
	public function delete_author($id) { }
	
	public function add_contributor($author) { }
	public function update_contributor($id, $author) { }
	public function delete_contributor($id) { }
	
	public function add_reference($reference) { }
	public function update_reference($id, $reference) { }
	public function delete_reference($id) { }
	
	public function add_content($contents) {
	
		array_push($this->contents, $contents);
	
	}
	
	public function update_content($id, $contents, $properties = []) {
	
		$this->contents[$id] = $contents;
	
	}
	
	public function delete_content($id) {
	
		unset($this->contents[$id]);
	
	}
	
	public function add_citation() { }
	public function update_citation() { }
	public function delete_citation() { }
	
	public function add_references() { }
	public function update_references() { }
	public function delete_references() { }

}

class DocumentationContent {

	public $text = "";
	public $body = "";
	
	public function __construct($text, $body) {
	
		$this->text = $text;
		$this->body = $body;
	
	}

}

class DocumentationCitation {

	public $note = "";

}

class DocumentationReference {

	public $href = "";
	public $text = "";

}

?>