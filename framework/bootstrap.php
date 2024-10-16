<?php

if (!isset($_STRAP)):

    define("BOOTSTRAP", "framework/bootstrap.php");
    $_STRAP = new Bootstrap;

endif;

if (isset($interface)):

    if (is_array($interface)):
    
        $currentInterface = $interface; unset($interface);

        foreach ($currentInterface as $inner):
        
            if ($inner instanceOf BootstrapContainer): $container = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapIcon): $icon = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapGridRowColumn): $gridRowColumn = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTableHead): $tableHead = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTableHeadCell): $tableHeadColumn = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTableBody): $tableBody = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTableBodyRow): $tableBodyRow = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTableBodyRowCell): $tableBodyRowColumn = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCoin): $coin = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCoinSlider): $coinSlider = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCoinSurface): $coinSurface = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCardHeader): $cardHeader = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCardFooter): $cardFooter = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapNavLink): $navLink = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
            elseif ($inner instanceOf NavLink): $link = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapInterface): $interface = $inner->inner; $inner = true;
            endif;
            
            if ($inner === true): unset($inner); include BOOTSTRAP;
            else: $var = $inner; unset($inner); if (isset($var)): include INDEX; endif;
            endif;
        
        endforeach;
    
    elseif (is_object($interface)):
    
        $inner = $interface; unset($interface);

        if ($inner instanceOf BootstrapContainer): $container = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapIcon): $icon = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGridRowColumn): $gridRowColumn = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTableHead): $tableHead = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTableHeadCell): $tableHeadColumn = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTableBody): $tableBody = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTableBodyRow): $tableBodyRow = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTableBodyRowCell): $tableBodyRowColumn = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCoin): $coin = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCoinSlider): $coinSlider = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCoinSurface): $coinSurface = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCardHeader): $cardHeader = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCardFooter): $cardFooter = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapNavLink): $navLink = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
        elseif ($inner instanceOf NavLink): $link = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapInterface):
        
            if ($inner->type == "file"):
            
                $file = $inner->inner;

                $file_ext = pathinfo($file, PATHINFO_EXTENSION);
                if ($file_ext == "php"): unset($file_ext);
                elseif ($file_ext == "md" OR $file_ext == "mdown"):
                
                    $cursor = cursor($file);
                    if ($cursor):
                    
                        $tpl = markdown(cursor($file)->contents);
                        unset($file, $file_ext);
                    
                    else:
                    
                        # $tpl = $file;
                    
                    endif;
                
                endif;
            
            else: $interface = $inner->inner; $inner = true; endif;
        
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        elseif (isset($file) OR isset($tpl)): include INDEX;
        else: $var = $inner; include INDEX;
        endif;
    
    elseif (is_string($interface)):
    
        $inner = $interface; unset($interface);
        $tpl = $inner; unset($inner); include INDEX;
    
    endif;

elseif (isset($icon)):

    $currentIcon = $icon; unset($icon);

    if ($currentIcon->id AND $currentIcon->class): printf('<i id="%s" class="%s"></i>' . PHP_EOL, $currentIcon->id, $currentIcon->class);
    elseif ($currentIcon->id): printf('<i id="%s"></i>' . PHP_EOL, $currentIcon->id);
    elseif ($currentIcon->class): printf('<i class="%s"></i>' . PHP_EOL, $currentIcon->class);
    endif;

elseif (isset($grid)):

    $previousGrid = isset($currentGrid) ? $currentGrid : false;
    $currentGrid = $grid; unset($grid);

    printf('<div class="%s">' . PHP_EOL, $currentGrid->class);

    if (is_array($currentGrid->inner)):
    
        # $var = $gridRow; include INDEX;
        foreach ($currentGrid->inner as $inner):
        
            if (is_object($inner)):
            
                if ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
                endif;

                if ($inner === true): unset($inner); include BOOTSTRAP;
                else: $var = $inner; unset($inner); include INDEX;
                endif;
            
            else: $var = $inner; unset($inner); include INDEX;
            endif;
        
        endforeach;
    
    elseif (is_object($currentGrid->inner)):
    
        $inner = $currentGrid->inner;

        if ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        else: $var = $inner; unset($inner); include INDEX;
        endif;
    
    else: $var = $currentGrid->inner; include INDEX;
    endif;

    printf('</div>' . PHP_EOL);

elseif (isset($gridRow)):

    $previousGridRow = isset($currentGridRow) ? $currentGridRow : false;
    $currentGridRow = $gridRow; unset($gridRow);

    printf('<section class="%s">' . PHP_EOL, $currentGridRow->class);
    foreach ($currentGridRow->inner as $gridRowColumn): include BOOTSTRAP; endforeach;
    printf('</section>' . PHP_EOL);

elseif (isset($gridRowColumn)):

    $previousGridRowColumn = isset($currentGridRowColumn) ? $currentGridRowColumn : false;
    $currentGridRowColumn = $gridRowColumn; unset($gridRowColumn);

    printf('<aside class="%s">' . PHP_EOL, $currentGridRowColumn->class);

    $interface = $currentGridRowColumn->inner;
    if (is_string($interface)):
    
        if (is_file($interface)): $file = $interface; $interface = true;
        else: $tpl = $interface; $interface = true;
        endif;

        if ($interface === true): unset($interface); include INDEX; endif;
    
    elseif (is_array($interface)):
    
        $currentInterface = $interface; unset($interface);
        foreach ($currentInterface as $inner):
        
            if ($inner instanceOf BootstrapCard): $card = $inner; $inner = true; 
            elseif ($inner instanceOf BootstrapForm): $form = $inner; $inner = true;
            endif;

            if ($inner === true): unset($inner); include BOOTSTRAP;
            else: $var = $inner; unset($inner); include INDEX;
            endif;
        
        endforeach;
    
    else: include BOOTSTRAP; endif;

    printf('</aside>' . PHP_EOL);

elseif (isset($coin)):

    $currentCoin = $coin; unset($coin);

    // printf('<section class="">' . PHP_EOL);

    $interface = $currentCoin->slider; include BOOTSTRAP;
    
    printf('<article id="%s" class="%s mx-3">' . PHP_EOL, $currentCoin->id, $currentCoin->class);
    foreach ($currentCoin->surfaces as $coinSurface): include BOOTSTRAP; endforeach;
    printf('</article>' . PHP_EOL);
    
    // printf('</section>' . PHP_EOL);

    printf('<script>' . PHP_EOL);
    printf('coinSliders.push({ coin: "%s", slider: "%s" });' . PHP_EOL, $currentCoin->id, $currentCoinSlider->id);
    printf('rotateCoin("%s", "%s");' . PHP_EOL, $currentCoin->id, $currentCoinSlider->id);
    printf('</script>' . PHP_EOL);

elseif (isset($coinSlider)):

    $currentCoinSlider = $coinSlider;

    printf('<input type="range" id="%s" class="%s" min="%d" max="%d" step="%d" value="%d" />' . PHP_EOL,
        $coinSlider->id,
        $coinSlider->class,
        $coinSlider->min,
        $coinSlider->max,
        $coinSlider->step,
        $coinSlider->value
    );
    
    unset($coinSlider);

elseif (isset($coinSurface)):

    $currentCoinSurface = $coinSurface; unset($coinSurface);

    // if %s (class) is set here, layout breaks
    // if %s (class) is not set here, structure breaks
    
    printf('<aside class="%s">' . PHP_EOL, $currentCoinSurface->class);
    // printf('<aside class="">' . PHP_EOL, $currentCoinSurface->class);

    if (is_object($currentCoinSurface->inner)):
    
        $inner = $currentCoinSurface->inner;
        
        if ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapInterface): $interface = $inner; $inner = true;
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        else: $var = $inner; unset($inner); include INDEX;
        endif;
    
    elseif (is_string($currentCoinSurface->inner)): $tpl = $currentCoinSurface->inner; include INDEX;
    else: $var = $currentCoinSurface->inner; include INDEX;
    endif;

    printf('</aside>' . PHP_EOL);

elseif (isset($container)):

    $currentContainer = $container; unset($container);

    if ($currentContainer->id): printf('<div id="%s" class="%s">' . PHP_EOL, $currentContainer->id, $currentContainer->class);
    elseif ($currentContainer->class): printf('<div class="%s">' . PHP_EOL, $currentContainer->class);
    else: printf('<div>' . PHP_EOL);
    endif;

    if (is_string($currentContainer->inner)): $tpl = $currentContainer->inner; include INDEX;
    elseif (is_object($currentContainer->inner)):
        
        $inner = $currentContainer->inner;

        if ($inner instanceOf BootstrapInterface): $interface = $inner->inner; $inner = true;
        elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCoin): $coin = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapContainer): $container = $inner; $inner = true;
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        else: $var = $inner; unset($inner); include INDEX;
        endif;
    
    elseif (is_array($currentContainer->inner)):
    
        foreach ($currentContainer->inner as $interface): include BOOTSTRAP; endforeach;
    
    else: $var = $currentContainer->inner; include INDEX;
    endif;

    printf('</div>' . PHP_EOL);

elseif (isset($card)):

    $currentCard = $card; unset($card);

    printf('<section class="%s">' . PHP_EOL, $currentCard->class);

    if ($currentCard->header): $cardHeader = $currentCard->header; include BOOTSTRAP; endif;
    
    if ($currentCard->body):
    
        if (is_string($currentCard->body)): $tpl = $currentCard->body; include INDEX;
        elseif (is_object($currentCard->body)):
        
            $inner = $currentCard->body;

            if ($inner instanceOf BootstrapInterface): $interface = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapCoin): $coin = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapContainer): $container = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
            elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
            endif;

            if ($inner === true): unset($inner); include BOOTSTRAP;
            else: $var = $inner; unset($inner); include INDEX;
            endif;
        
        elseif (is_array($currentCard->body)):
        
            foreach ($currentCard->body as $inner):
            
                if ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
                endif;

                if ($inner === true): unset($inner); include BOOTSTRAP;
                else: $var = $inner; unset($inner); include INDEX;
                endif;
            
            endforeach;
        
        endif;
    endif;

    if ($currentCard->footer): $cardFooter = $currentCard->footer; include BOOTSTRAP; endif;
    
    printf('</section>' . PHP_EOL);

elseif (isset($cardHeader)):

    $currentCardHeader = $cardHeader; unset($cardHeader);
    
    printf('<header class="%s">' . PHP_EOL, $currentCardHeader->class);
    // $var = $currentCardHeader->inner; include INDEX;
    $interface = $currentCardHeader->inner; include BOOTSTRAP;
    printf('</header>' . PHP_EOL);

elseif (isset($cardBody)):

    $currentCardBody = $cardBody; unset($cardBody);

    printf('<aside class="%s">' . PHP_EOL, $currentCardBody->class);

    if (is_object($currentCardBody->inner)):
    
        $inner = $currentCardBody->inner;

        if ($inner instanceOf BootstrapInterface): $interface = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCoin): $coin = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapForm): $form = $inner; $inner = true;
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        else: $var = $inner; unset($inner); include INDEX;
        endif;
    
    elseif (is_string($currentCardBody->inner)): $tpl = $currentCardBody->inner; include INDEX;
    elseif (is_array($currentCardBody->inner)):
    
        foreach ($currentCardBody->inner as $inner):
        
            if (is_object($inner)):
            
                if ($inner instanceOf BootstrapInterface): $interface = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCard): $card = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapNavigation): $nav = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapForm): $form = $inner; $inner = true;
                elseif ($inner instanceOf BootstrapTable): $table = $inner; $inner = true;
                endif;

                if ($inner === true): unset($inner); include BOOTSTRAP;
                else: $var = $inner; unset($inner); include INDEX;
                endif;
            
            elseif (is_string($inner)):
            
                if (is_file(ltrim($inner, "/"))):
                
                    $file = ltrim($inner, "/");
                    $pathinfo = pathinfo($file, PATHINFO_EXTENSION);

                    if ($pathinfo == "php"): unset($inner); include INDEX;
                    elseif ($pathinfo == "md"):
                    
                        $tpl = markdown(cursor($file)->contents);
                        include INDEX;
                    
                    endif;
                
                else: $tpl = $inner; unset($inner); include INDEX;
                endif;
            
            else: $var = $inner; unset($inner); include INDEX;
            endif;
        
        endforeach;
    
    else: $var = $currentCardBody->inner; include INDEX;
    endif;
    // $interface = $currentCardBody->inner; include BOOTSTRAP;

    printf('</aside>' . PHP_EOL);

elseif (isset($cardFooter)):

    $currentCardFooter = $cardFooter; unset($cardFooter);

    printf('<footer class="%s">' . PHP_EOL, $currentCardFooter->class);

    if (is_object($currentCardFooter->inner)):
    
        $inner = $currentCardFooter->inner;

        if ($inner instanceOf BootstrapGrid): $grid = $inner; $inner = true;
        elseif ($inner instanceOf BootstrapGridRow): $gridRow = $inner; $inner = true;
        endif;

        if ($inner === true): unset($inner); include BOOTSTRAP;
        else: $var = $inner; unset($inner); include INDEX;
        endif;
    
    elseif (is_string($currentCardFooter->inner)): $tpl = $currentCardFooter->inner; include INDEX;
    else: $var = $currentCardFooter->inner; include INDEX;
    endif;
    printf('</footer>' . PHP_EOL);

elseif (isset($nav)):

    $currentNav = $nav; unset($nav);

    if ($currentNav->id): printf('<nav id="%s" class="%s">' . PHP_EOL, $currentNav->id, $currentNav->class);
    else: printf('<nav class="%s">' . PHP_EOL, $currentNav->class);
    endif;

    $interface = $currentNav->panels; include BOOTSTRAP;

    printf('</nav>' . PHP_EOL);

elseif (isset($navItem)):

    if ($navItem instanceOf BootstrapNavLink): $navLink = $navItem; unset($navItem); include BOOTSTRAP;
    else: $tpl = $navItem; unset($navItem); include INDEX;
    endif;

elseif (isset($navLink)):

    $currentNavLink = $navLink; unset($navLink);

    printf('<a class="%s" href="%s">' . PHP_EOL, $currentNavLink->class, $currentNavLink->href);
    $interface = $currentNavLink->text; include BOOTSTRAP;
    printf('</a>' . PHP_EOL);


elseif (isset($link)):

    $currentLink = $link; unset($link);
    printf('<a href="%s">%s</a>' . PHP_EOL, $currentLink->href, $currentLink->text);

elseif (isset($table)):

    $currentTable = $table; unset($table);

    if ($currentTable->id AND $currentTable->class):
    printf('<table id="%s" class="%s">' . PHP_EOL, $currentTable->id, $currentTable->class);
    elseif ($currentTable->id): printf('<table id="%s">' . PHP_EOL, $currentTable->id);
    elseif ($currentTable->class): printf('<table class="%s">' . PHP_EOL, $currentTable->class);
    else: printf('<table>' . PHP_EOL);
    endif;

    if ($currentTable->head): $interface = $currentTable->head; include BOOTSTRAP; endif;
    if ($currentTable->body): $interface = $currentTable->body; include BOOTSTRAP; endif;

    printf('</table>' . PHP_EOL);

elseif (isset($tableHead)):

    $currentTableHead = $tableHead; unset($tableHead);

    if ($currentTableHead->class): printf('<thead class="%s">'. PHP_EOL, $currentTableHead->class);
    else: printf('<thead>' . PHP_EOL);
    endif;

    $interface = $currentTableHead->inner; include BOOTSTRAP;

    printf('</thead>' . PHP_EOL);

elseif (isset($tableHeadColumn)):

    $currentTableHeadColumn = $tableHeadColumn; unset($tableHeadColumn);

    if ($currentTableHeadColumn->class AND $currentTableHeadColumn->colspan): printf('<th class="%s" colspan="%s">' . PHP_EOL, $currentTableHeadColumn->class, $currentTableHeadColumn->colspan);
    elseif ($currentTableHeadColumn->class): printf('<th class="%s">' . PHP_EOL, $currentTableHeadColumn->class);
    elseif ($currentTableHeadColumn->colspan): printf('<th colspan="%s">' . PHP_EOL, $currentTableHeadColumn->colspan);
    else: printf('<th>' . PHP_EOL);
    endif;
    
    $interface = $currentTableHeadColumn->inner; include BOOTSTRAP;

    printf('</th>' . PHP_EOL);

elseif (isset($tableBody)):

    $currentTableBody = $tableBody; unset($tableBody);

    if ($currentTableBody->class): printf('<tbody class="%s">' . PHP_EOL, $currentTableBody->class);
    else: printf('<tbody>' . PHP_EOL);
    endif;
    
    $interface = $currentTableBody->inner; include BOOTSTRAP;

    printf('</tbody>' . PHP_EOL);

elseif (isset($tableBodyRow)):

    $currentTableBodyRow = $tableBodyRow; unset($tableBodyRow);

    if ($currentTableBodyRow->id AND $currentTableBodyRow->class): printf('<tr id="%s" class="%s">' . PHP_EOL, $currentTableBodyRow->id, $currentTableBodyRow->class);
    elseif ($currentTableBodyRow->id): printf('<tr id="%s">' . PHP_EOL, $currentTableBodyRow->id);
    elseif ($currentTableBodyRow->class): printf('<tr class="%s">' . PHP_EOL, $currentTableBodyRow->class);
    else: printf('<tr>' . PHP_EOL);
    endif;

    $interface = $currentTableBodyRow->inner; include BOOTSTRAP;

    printf('</tr>' . PHP_EOL);

elseif (isset($tableBodyRowColumn)):

    $currentTableBodyRowColumn = $tableBodyRowColumn; unset($tableBodyRowColumn);

    if ($currentTableBodyRowColumn->class AND $currentTableBodyRowColumn->colspan): printf('<td class="%s" colspan="%s">' . PHP_EOL, $currentTableBodyRowColumn->class, $currentTableBodyRowColumn->colspan);
    elseif ($currentTableBodyRowColumn->class): printf('<td class="%s">' . PHP_EOL, $currentTableBodyRowColumn->class);
    elseif ($currentTableBodyRowColumn->colspan): printf('<td colspan="%s">' . PHP_EOL, $currentTableBodyRowColumn->colspan);
    else: printf('<td>' . PHP_EOL);
    endif;

    $interface = $currentTableBodyRowColumn->inner; include BOOTSTRAP;

    printf('</td>' . PHP_EOL);

else:

    if (isset($breadcrumb)):
    
        $breadcrumbLinks = [];
        $i = 0; $crumbQuery = ""; foreach ($breadcrumb as $crumbKey => $crumbValue):
    
            $i++;
    
            $linkClass = "breadcrumb-item";
            if ($i == count($breadcrumb)): $linkClass .= " active"; endif;
            $linkHyperlink = hyperlink($crumbKey);
    
            $crumbQuery .= $crumbKey;
            $linkPageNode = array_query($cms->pages, $crumbQuery, "crumb"); $crumbQuery .= "/";
    
            $linkText = is_object($linkPageNode) ? $linkPageNode->crumbText : ucfirst(urldecode($crumbKey));
    
            if ($linkPageNode): $link = new BootstrapNavLink($linkClass, $linkHyperlink, $linkText);
            else: $linkClass .= " active"; $link = sprintf('<span class="%s">%s</span>' . PHP_EOL, $linkClass, $linkText);
            endif;
    
            unset($linkClass, $linkHyperlink, $linkText, $linkPageNode);
            array_push($breadcrumbLinks, $link); unset($link);
    
        unset($crumbKey, $crumbValue); endforeach; unset($i, $crumbQuery, $breadcrumb);
    
    elseif (isset($form)):
    
        $currentForm = $form; unset($form);

        if ($currentForm->action): printf('<form action="%s" method="%s">' . PHP_EOL, $currentForm->action, $currentForm->method);
        else: printf('<form method="%s">' . PHP_EOL, $currentForm->method);
        endif;

        foreach ($currentForm->fields as $formGroup): include BOOTSTRAP; endforeach;

        printf('<nav class="mt-3">' . PHP_EOL);
        $formButton = $currentForm->button; include BOOTSTRAP;
        printf('</nav>' . PHP_EOL);

        printf('</form>' . PHP_EOL);
    
    elseif (isset($formGroup)):
    
        $currentFormGroup = $formGroup; unset($formGroup);

        printf('<div class="%s">' . PHP_EOL, $currentFormGroup->class);
        
        $formGroupLabel = $currentFormGroup->label; include BOOTSTRAP;
        $formGroupField = $currentFormGroup->field; include BOOTSTRAP;

        printf('</div>' . PHP_EOL);
    
    elseif (isset($formGroupLabel)):
    
        printf('<span class="%s">%s</span>' . PHP_EOL, $formGroupLabel->class, $formGroupLabel->text);
        unset($formGroupLabel);
    
    elseif (isset($formGroupField)):
    
        if ($formGroupField->field->type == "textarea"):
        
            printf('<textarea rows="10" class="%s" name="%s" placeholder="%s">%s</textarea>' . PHP_EOL,
                $formGroupField->class,
                $formGroupField->field->name,
                $formGroupField->field->placeholder,
                $formGroupField->field->value ? $formGroupField->field->value : ""
            );
        
        elseif ($formGroupField->field->type == "text" OR $formGroupField->field->type == "password"):
        
            $type = $formGroupField->field->type;
            $field = $formGroupField->field;

            printf('<input type="%s" class="%s" name="%s" placeholder="%s" value="%s" />' . PHP_EOL,
                $type,
                $formGroupField->class,
                $field->name,
                $field->placeholder,
                $field->value
            ); unset($field);
        
        else: $var = $formGroupField->field; include INDEX;
        endif;

        unset($formGroupField);
    
    elseif (isset($formButton)):
    
        printf('<button class="%s" type="submit" name="%s">%s</button>' . PHP_EOL, $formButton->class, $formButton->button->name, $formButton->button->text);

        unset($formButton);
    
    elseif (isset($calendar)):
    
        $currentCalendar = $calendar; unset($calendar);
        $var = $currentCalendar; include INDEX;
    
    elseif (isset($calendarWeek)):
    
        $currentCalendarWeek = $calendarWeek; unset($calendarWeek);
        $var = $currentCalendarWeek; include INDEX;
    
    elseif (isset($calendarDay)):
    
        $currentCalendarDay = $calendarDay; unset($calendarDay);
        $var = $currentCalendarDay; include INDEX;
    
    endif;

endif;

?>