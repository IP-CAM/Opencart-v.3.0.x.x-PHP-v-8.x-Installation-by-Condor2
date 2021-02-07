<?php
namespace Template;
final class Twig {
	private $data = [];

	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($filename, $code = '') {
		if (!$code) {
			$file = modification( DIR_TEMPLATE . $filename . '.twig' );

			if( class_exists('VQMod') ) {
				$file = \VQMod::modCheck($file);
			}

			if (is_file($file)) {
				$code = file_get_contents($file);
			} else {
				throw new \Exception('Error: Could not load template ' . $file . '!');
				exit();
			}
		}

		// initialize Twig environment
		$config = array(
			'charset'     => 'utf-8',
			'autoescape'  => false,
			'debug'       => false,
			'auto_reload' => true,
			'cache'       => DIR_CACHE . 'template/'
		);

		try {
			$loader1 = new \Twig\Loader\ArrayLoader(array($filename . '.twig' => $code));
			$loader2 = new \Twig\Loader\FilesystemLoader(array(DIR_TEMPLATE));
			$loader = new \Twig\Loader\ChainLoader(array($loader1, $loader2));

			$twig = new \Twig\Environment($loader, $config);

			return $twig->render($filename . '.twig', $this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $filename . '!');
			exit();
		}	
	}	
}