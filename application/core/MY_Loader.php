<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

class MY_Loader extends MX_Loader {

	public function template($template_name, $vars = array(), $return = FALSE)
    {
        if($return):
        $content  = $this->view('common/header', $vars, $return);
        $content .= $this->view('common/body_header', $vars, $return);
        $content .= $this->view('common/sidebar', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('common/body_footer', $vars, $return);
        $content .= $this->view('common/footer', $vars, $return);

        return $content;
    else:
        $this->view('common/header', $vars);
        $this->view('common/body_header', $vars);
        $this->view('common/sidebar', $vars);
        $this->view($template_name, $vars);
        $this->view('common/body_footer', $vars);
        $this->view('common/footer', $vars);
    endif;
    }

    public function page($template_name, $vars = array(), $return = FALSE)
    {
        if($return):
        $content  = $this->view('common/header', $vars, $return);
        $content .= $this->view($template_name, $vars, $return);
        $content .= $this->view('common/footer', $vars, $return);

        return $content;
    else:
        $this->view('common/header', $vars);
        $this->view($template_name, $vars);
        $this->view('common/footer', $vars);
    endif;
    }
}