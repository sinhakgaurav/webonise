<?php

namespace Core;

class View {

    /**
     * View file
     */
    private $file;

    /**
     * The data of the view
     */
    private $data;

    /**
     * The actual templater
     */
    private $twig;

    /**
     * Initialize a new View
     *
     * @param $file
     */
    public function __construct($file, $data = null) {
        $this->file = $file;
        $this->data = $data;

        $twigLoader = new \Twig_Loader_Filesystem(INC_ROOT . '/app/modules', '__main__');
        $this->twig = new \Twig_Environment($twigLoader, [
//                'cache' => INC_ROOT . '/app/cache',
        ]);
    }

    /**
     * Return the parsed view
     */
    public function __toString() {
        return $this->parseView();
    }

    /**
     * Parse the view into a string using Twig
     */
    public function parseView() {
        $file = $this->file . '.php';

        try {
            if (is_null($this->data)) {
                return $this->twig->render($file);
            }

            return $this->twig->render($file, $this->data);
        } catch (\Twig_Error_Loader $e) {
            return $this->getErrorMessage('loader', $e->getMessage());
        } catch (\Twig_Error_Loader $e) {
            return $this->getErrorMessage('runtime', $e->getMessage());
        } catch (\Twig_Error_Loader $e) {
            return $this->getErrorMessage('syntax', $e->getMessage());
        }
    }

    private function getErrorMessage($errorType, $errorMessage) {
        return sprintf("A %s error occured: %s", $errorType, $errorMessage);
    }

}
