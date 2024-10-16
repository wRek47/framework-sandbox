# FrameWork

### Entity Management
Entities make-up...

##### Entity Decoding
...

##### Entity Encoding
...

##### Entity Audibles
...

### Backend Management

##### Building a Back-End
...

##### Updating a Back-End
...


### Frontend Management

##### Building a Front-End
...

##### Updating a Front-End
...

### Circular Operations

##### INDEX
Every `SCENE` is sensitive to these signals:
- `$var`
- `$file`
- `$files`

When any of these signals are set before `include INDEX;`, it will trigger the behavior of the respective signal.

##### SCENE
Every `SCENE` is sensitive to these signals:
- `$systems`
- `$system`
- `$structures`
- `$structure`
- `$surfaces`
- `$surface`

When any of these signals are set before `include SCENE;`, it will trigger the behavior of the respective signal.

### System Definitions and Globals

##### BASE, ROOT
...

##### Decoded $_ globals and custom $_ORDER and $_SPACE global variables
...

##### $fw, $scene
...

##### $website, $page
...

##### @$scene, @$system, @$structure, @$surface
...

##### Custom Variables and Recursive Inclusion
...

### System Variables, Functions, and Classes

Many functions and objects are included with FrameWork:
- $fw->globals($path);
- $fw->cursor($path, $system = null);
- $fw->landscape[];
- $fw->pagination();
- $fw->horizon();

- $fw->fresh_href();
- $fw->recycle_href();
- $fw->bloat_href();

##### Objects

- ::FileSystem()
    - FileSystem::Folder()
    - FileSystem::File()
- ::Form()
    - Form::Field()
    - Form::Button()
- ::Table()
    - Table::Row()
- ::Scene()
    - Scene::Canvas()
    - Scene::System()
    - Scene::Structure()
    - Scene::Surface()
- ::Canvas()
    - Canvas::User()
    - Canvas::Nation()
    - Canvas::Landscape()
    - Canvas::Horizon()

### Bootstrap Support

##### Layout
__Sidebar__

##### Blog
__Articles__
__Authors__

### Example Usage

##### Visitor Tracking
```
table_system(cursor("/path/to/visits.json"), $fw->tables['visits']);
table_system(cursor("/path/to/visitors.json"), $fw->tables['visitors']);

$visits = &$fw->tables['visits']->rows;
$visitors = &$fw->tables['visitors']->rows;

$visitor = new Visitor($visitors, $visit->code);

$var = $visitor; include INDEX;
```

##### User Selection
```
table_system(cursor("/path/to/users.json"), $fw->tables['users']);

$users = &$fw->tables['users']->rows;

$user = json_class(array_query($users, $visitor->id, "visitor_id), "User");
$user->init();
```

##### Surface Modeling
```
```

##### Hyperlink Generation
```
```

##### Content Manufacturing
```
```