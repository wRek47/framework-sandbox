### Introduction

---

- [Getting Started](#gettingStarted)
- [Engine Dictionary](#dictionary)
- [Usage Examples](#examples)
- [Downloads &amp; Installation](#downloads)
- [GitHub](#github)
- [Help Desk](#helpdesk)

---

<div id="gettingStarted">

##### Getting Started

Getting started with FrameWork means that you're interested in upgrading your digital software for a 3D world.
It's not hard to understand that a box has an inside and an outside, it was however, very hard to program them in seamless fashion.

With the introduction of FrameWork, comes an architecture that took me 10 years to mold into the distinct processors and operations associated
with the complexities of multidimensional stacking system I bring to life.

</div>

---

<div id="dictionary">

##### Engine Dictionary

- [Sensors](#dicSensors) [`$_VARIABLES`]
- [Portals](#dicPortals) [`CONSTANTS`]
- [Utilities](#dicUtilities) [`functions()`]
- [Components](#dicComponents) [`{classes}`]
- [Flowchart](#dicFlowchart) [`/path/to/cursor(file->local)/path/to/variable:withReflection("andParameters")->data::INDEX|BOOTSTRAP|*(*)*`]

</div>

---

<div id="examples">

##### Examples

- [Hello World page](#exHelloWorld)
- [Bootstrap Grid](#exGrid)
- [Signal Tensor](#exSignal)

<div id="exHelloWorld" class="card rounded-0 mt-3"><header class="card-header">Hello World (3-Row Static Web Page)</header><div class="card-body pb-0">

``` PHP
<?php

// skate or die.
if (!defined("INDEX")): include "index.php" or die("FrameWork is required here, but was not detected."); endif;

// import stack and table pavement

# stack_system("website", cursor("/path/to/website.yml"), $_STACK['website']);
$website = json_decode('{
    "title": "Your Site Name",
    "signoff": "Copyright &copy; ' . date("Y") . '",
    "default_page": "home"
}');

# table_system("structures", cursor("/path/to/structures.json"), $_TABLE['structures']);
$structures = json_decode('[ {
    "crumb": "home",
    "breadcrumb": "Home",

    "title": "My First Structure",
    "description": "`Hello World` site-page demonstration.",
    "body": "Hello world."
} ]');

// detect current page
[$page_id, $page] = array_query_both($structures, crumb_id(1), "crumb");
if (!$page): [$page_id, $page] = array_query_both($structures, $website->default_page, "crumb"); endif;

// create header
$layoutHeader = new BootstrapCardHeader("", "bg-dark text-light p-3 fs-3", $website->title);

// create footer
$layoutFooter = new BootstrapCardFooter("", "bg-secondary text-light p-3 text-center", $website->signoff);

// create main
$layoutMain = new BootstrapGrid("", "container", [
    new BootstrapCard("", "card",
        new BootstrapCardHeader("", "card-header", '<span class="card-title">' . $page->title . '</span>'),
        new BootstrapCardBody("", "card-body", $page->body),
        false
    )
]);

// add items to interface vector
$layout = new BootstrapInterface([$layoutHeader, $layoutMain, $layoutFooter]);

// send `$interface` to `BOOTSTRAP`
$interface = $layout; include BOOTSTRAP;

?>
```

</div></div>

<div id="exGrid" class="card rounded-0 mt-3"><header class="card-header">Bootstrap Grid (Rows and Columns)</header><div class="card-body pb-0">

``` PHP
<?php

// skate or die.
if (!defined("INDEX")): include "index.php" or die("FrameWork is required here, but was not detected."); endif;

// import stack and table pavement

# stack_system("layout", cursor("/path/to/layout.yml"), $_STACK['layout']);

# table_system("layoutSidebar", cursor("/path/to/sidebar.json"), $_TABLE['layoutSidebar']);

// create grid columns
$layoutSidebar = new BootstrapGridRowColumn("", "col-12 col-lg-3 col-md-4", [
    new BootstrapCard("", "card",
        new BootstrapCardHeader("", "card-header", '<span class="card-title">Main Menu</span>'),
        new BootstrapCardBody("", "card-body", "No links added.")
    )
]);

$layoutMainContent = new BootstrapGridRowColumn("", "col-12 col-lg-9 col-md-8", [
    new BootstrapCard("", "card",
        new BootstrapCardHeader("", "card-header", "Untitled Page"),
        new BootstrapCardBody("", "card-body", "No content added."),
        new BootstrapCardFooter("", "card-footer", date("l, F jS Y, g.i a"))
    )
);

// create grid rows
$layoutTop = new BootstrapCardHeader("", "bg-dark text-light p-3", "Untitled Website");
$layoutMiddle = new BootstrapGrid("", "container-fluid", [
    new BootstrapGridRow("", "row", [$layoutSidebar, $layoutMainContent])
]);
$layoutBottom = new BootstrapCardFooter("", "bg-secondary", "All rights reserved.");

// create grid container
$layoutMain = new BootstrapGrid("", "container", [$layoutTop, $layoutMiddle, $layoutBottom]);

?>
```

</div></div>

<div id="exSignal" class="card rounded-0 mt-3"><header class="card-header">Signal Tensor</header><div class="card-body pb-0">

``` PHP
<?php

// skate or die.
if (!defined("INDEX")): include "index.php" or die("FrameWork is required here, but was not detected."); endif;

if (!defined("SELF")): define("SELF", "/path/to/self"); endif; # use a distinct definition, generic constants lead limitations

// flowchart signal listener
if (isset($inputVariableName)):

    if (is_array($inputVariableName)):
    
        // decode signal instances
        $currentInputVariableName = $inputVariableName; unset($inputVariableName);
        foreach ($currentInputVariableName as $inputVariableKey => $inputVariableName): include SELF; if (isset($inputVariableKey)): unset($inputVariableKey); endif; endforeach;
    
    elseif (is_object($inputVariableName)):
    
        // variable instance relay
        if ($inputVariableName instanceOf ClassName): $objectVariableName = $inputVariableName; $inputVariableName = true;
        endif;

        // go to next
        if ($inputVariableName === true): unset($inputVariableName); include PARENT; // send to parent operative
        else: $var = $inputVariableName; unset($inputVariableName); include INDEX; // send to debugger
        endif;
    
    elseif (is_string($inputVariableName)):
    
        // check if content is a filename and intended to be used as such
        if (detect_filesys($inputVariableName)):
        
            $file = $inputVariableName; $inputVariableName = true;
        
        // check if content is likely to be html or tpl
        elseif (detect_html($inputVariableName)):
        
            $tpl = $inputVariableName; $inputVariableName = true;
        
        endif;
        
        // go to next
        if ($inputVariableName === true): unset($inputVariableName); include INDEX; // send to parent operative
        else: $var = $inputVariableName; unset($inputVariableName); include INDEX; // send to debugger
        endif;
    
    elseif (is_bool($inputVariableName)): unset($inputVariableName); include SELF; // complex operation simplified successfully
    else: $var = $inputVariableName; unset($inputVariableName); include INDEX; // send to debugger
    endif;

// flowchart structure listener
elseif (isset($objectInputVariable)):

    // expand system according new life of objectInputVariable

endif;

?>
```

</div>

---

##### Download &amp; Installation

No instructions found.

---

##### GitHub

No references or citations found.

---

##### Help Desk

Helpdesk is unavailable at this time.
