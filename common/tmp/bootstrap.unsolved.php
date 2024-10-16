<?php

if (!isset($_STRAP)):

    define("BOOTSTRAP", "framework/bootstrap.php");
    $_STRAP = new Bootstrap;

endif;

if (isset($inner)): // handle conventional elements

    if (is_string($inner)):
    
        print $inner; unset($inner);
	
    elseif (is_array($inner)):
	
		/*
			Inner needs to function in such a way that it can scale breadth, and depth.
			I can do breadth or depth, piece of cake.. I can even do breadth and/or depth, piece of cake..
			But solving for both using $inner leaves me lost in translation and aggravated.
			Solving for breadth is as simple as looping through $inner as $currentInner.
			Solving for depth is as simple as executing congruent objects.
			Solving for both is as simple as doing both respectively.

			Solving for both using $inner as a relay though, this requires invoking stacked inner states. AI either doesn't
			understand what I'm asking or can't do it. It's possible it can't do it, as it is likely limitations and bugs can and will
			arise in cross-relay trajectories due to the tesselational expansion that occurs with this hierarchy infrastructure.
		*/

        if (!isset($currentInner)):
        
            $previousInner = isset($currentInner) ? $currentInner : false;
            $currentInner = $inner; unset($inner);
            
            if (count($currentInner)): foreach ($currentInner as $inner): include BOOTSTRAP; endforeach;
            elseif (isset($previousInner)): $currentInner = $previousInner; var_dump(count($previousInner));
            endif;
        
        else: $inner = $currentInner; # include BOOTSTRAP;
        endif;
        // array_shift($previousInner); $currentInner = $previousInner;

        # if (isset($inner)): include BOOTSTRAP; endif;

        // var_dump($currentInner[1]); exit;
	
	elseif (is_object($inner)):
	
        // if ($inner instanceOf BootstrapInterface): $userInterface = $inner; var_dump($userInterface);

        if ($inner instanceOf BootstrapGrid): $grid = $inner;
        elseif ($inner instanceOf BootstrapRow): $gridRow = $inner;
        elseif ($inner instanceOf BootstrapColumn): $gridRowColumn = $inner;

		elseif ($inner instanceOf BootstrapCoin): $coin = $inner;
		elseif ($inner instanceOf BootstrapSlider): $coinSlider = $inner;
		elseif ($inner instanceOf BootstrapSurface): $coinFace = $inner;

		elseif ($inner instanceOf BootstrapCard): $card = $inner;
		elseif ($inner instanceOf BootstrapCardHeader): $cardHeader = $inner;
		elseif ($inner instanceOf BootstrapCardBody): $cardBody = $inner;
		elseif ($inner instanceOf BootstrapCardFooter): $cardFooter = $inner;

		elseif ($inner instanceOf Navigation): $nav = $inner;
		elseif ($inner instanceOf NavItem): $navItem = $inner;
		elseif ($inner instanceOf NavLink): $navLink = $inner;

        elseif ($inner instanceOf BootstrapInterface): $userInterface = $inner;
		else: $outer = $inner;
		endif; unset($inner);
        
        if (isset($grid) OR isset($gridRow) OR isset($gridColumn) OR
            isset($coin) OR isset($coinSlider) OR isset($coinFace) OR
            isset($card) OR isset($cardHeader) OR isset($cardBody) OR isset($cardFooter) OR
            isset($nav) OR isset($navItem) OR isset($navLink) OR
            isset($outer)
        ): include BOOTSTRAP; endif;
	
	endif;

elseif (isset($outer)): // handle non-conventional elements

else: // conventional interpretations

    if (isset($coin)):
	
		$previousCoin = isset($currentCoin) ? $currentCoin : false;
		$currentCoin = $coin; unset($coin);
		
		printf('<section class="%s">' . PHP_EOL, $currentCoin->class);
		$inner = $currentCoin->inner; include BOOTSTRAP;
		printf('</section>' . PHP_EOL);
		
		# unset($previousCoin, $currentCoin);
	
	elseif (isset($coinSlider)):
	
		$previousCoinSlider = isset($currentCoinSlider) ? $currentCoinSlider : false;
		$currentCoinSlider = $coinSlider; unset($coinSlider);
		
		// $inner = $currentCoinSlider->inner;
		printf('<input id="%s" class="%s" type="range" min="%d" max="%d" step="%d" value="%d" />',
			$currentCoinSlider->id,
			$currentCoinSlider->class,
			$currentCoinSlider->min,
			$currentCoinSlider->max,
			$currentCoinSlider->step,
			$currentCoinSlider->value);
		
		# unset($previousCoinSlider, $currentCoinSlider);
	
	elseif (isset($coinSurface)):
	
		$previousCoinSurface = isset($currentCoinSurface) ? $currentCoinSurface : false;
		$currentCoinSurface = $coinSurface; unset($coinSurface);
		
		printf('<section id="%s" class="%s">' . PHP_EOL, $currentCoinSurface->id, $currentCoinSurface->class);
		$inner = $currentCoinSurface->inner; include BOOTSTRAP;
		printf('</section>' . PHP_EOL);
		
		# unset($previousCoinSurface, $currentCoinSurface);
	
	elseif (isset($card)):
	
		$previousCard = isset($currentCard) ? $currentCard : false;
		$currentCard = $card; unset($card);

        if (!isset($currentCard->inner) OR (is_array($currentCard->inner) AND empty($currentCard->inner))):
        
            $currentCard->inner = [];

            if ($currentCard->header): array_push($currentCard->inner, $currentCard->header); endif;
            if ($currentCard->body): array_push($currentCard->inner, $currentCard->body); endif;
            if ($currentCard->footer): array_push($currentCard->inner, $currentCard->footer); endif;
        
        endif;
		
		printf('<section class="%s">' . PHP_EOL, $currentCard->class);
        # var_dump($currentCard->inner);
		$inner = $currentCard->inner; include BOOTSTRAP;
		printf('</section>' . PHP_EOL);
		
		# unset($previousCard, $currentCard);
	
	elseif (isset($cardHeader)):
	
		$previousCardHeader = isset($currentCardHeader) ? $currentCardHeader : false;
		$currentCardHeader = $cardHeader; unset($cardHeader);
		
		printf('<header class="%s">' . PHP_EOL, $currentCardHeader->class);
		$inner = $currentCardHeader->inner;
		printf('</header>' . PHP_EOL);
		
		# unset($previousCardHeader, $currentCardHeader);
	
	elseif (isset($cardTitle)):
	
		$previousCardTitle = isset($currentCardTitle) ? $currentCardTitle : false;
		$currentCardTitle = $cardTitle; unset($cardTitle);
		
		printf('<span class="%s">');
		$inner = $currentCardTitle->inner;
		printf('</span>');
		
		# unset($previousCardTitle, $currentCardTitle);
	
	elseif (isset($cardBody)):
	
		$previousCardBody = isset($currentCardBody) ? $currentCardBody : false;
		$currentCardBody = $cardBody; unset($cardBody);
		
		printf('<aside class="%s">' . PHP_EOL, $currentCardBody->class);
		$inner = $currentCardBody->inner; include BOOTSTRAP;
		printf('</aside>' . PHP_EOL);
		
		# unset($previousCardBody, $currentCardBody);
	
	elseif (isset($cardFooter)):
	
		$previousCardFooter = isset($currentCardFooter) ? $currentCardFooter : false;
		$currentCardFooter = $cardFooter; unset($cardFooter);
		
		printf('<footer class="%s">', $currentCardFooter->class);
		$inner = $currentCardFooter->inner; include BOOTSTRAP;
		printf('</footer>');
		
		# unset($previousCardFooter, $currentCardFooter);
	
    elseif (isset($nav)):
    
        $previousNav = isset($currentNav) ? $currentNav : false;
        $currentNav = $nav; unset($nav);

        printf('<nav id="" class="nav">' . PHP_EOL);
        
        if (!isset($currentNav->inner)): $currentNav->inner = $currentNav->links; endif;
        $inner = $currentNav->inner; include BOOTSTRAP;

        printf('</nav>' . PHP_EOL);

        # unset($previousNav, $currentNav);
    
    elseif (isset($navLink)):
    
        $previousNavLink = isset($currentNavLink) ? $currentNavLink : false;
        $currentNavLink = $navLink; unset($navLink);

        printf('<a class="nav-item nav-link" href="%s">%s</a>' . PHP_EOL, $currentNavLink->href, $currentNavLink->text);

        # unset($previousNavLink, $currentNavLink);
    
    elseif (isset($grid)):
    
        $previousGrid = isset($currentGrid) ? $currentGrid : false;
        $currentGrid = $grid; unset($grid);

        printf('<div class="%s">' . PHP_EOL, $currentGrid->class);
        # $inner = $currentGrid->inner; include INDEX;
        foreach ($currentGrid->inner as $gridRow): include BOOTSTRAP; endforeach;
        printf('</div>' . PHP_EOL);
    
	elseif (isset($gridRow)):
	
		$previousGridRow = isset($currentGridRow) ? $currentGridRow : false;
		$currentGridRow = $gridRow; unset($gridRow);
		
		// if ($currentGridRow->container): printf('<div class="%s">', $currentGridRow->container); endif;
		printf('<section class="%s">' . PHP_EOL, $currentGridRow->class);
        foreach ($currentGridRow->inner as $gridRowColumn): include BOOTSTRAP; endforeach;
		#$inner = $currentGridRow->inner; include BOOTSTRAP;
		printf('</section>' . PHP_EOL);
		// if ($currentGridRow->container): printf('</div>'); endif;
		
		# unset($previousGridRow, $currentGridRow);
	
	elseif (isset($gridRowColumn)):
	
		$previousGridRowColumn = isset($currentGridRowColumn) ? $currentGridRowColumn : false;
		$currentGridRowColumn = $gridRowColumn; unset($gridRowColumn);
		
		printf('<aside class="%s">' . PHP_EOL, $currentGridRowColumn->class);
        $inner = $currentGridRowColumn->inner; include BOOTSTRAP;
        array_shift($currentInner); $inner = $currentInner;
		printf('</aside>' . PHP_EOL);
		
		# unset($previousGridRowColumn, $currentGridRowColumn);
	
	endif;

endif;

?>