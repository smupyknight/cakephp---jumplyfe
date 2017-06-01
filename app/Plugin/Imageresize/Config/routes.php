<?php 
Router::connect('/get-image/*', array('plugin'=>'Imageresize','controller' => 'Imageresize', 'action' => 'get_image'));
Router::connect('/get-image-source/*', array('plugin'=>'Imageresize','controller' => 'Imageresize', 'action' => 'get_image'));
