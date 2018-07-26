<?php

class View
{
	function render($content_view, $template_view, $data = null)
	{
		include __DIR__ . '/../templates/'.$template_view;
	}
}
