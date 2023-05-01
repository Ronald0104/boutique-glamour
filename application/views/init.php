<?php
    $layout = "bootstrap4-lm";
    $page = $page;
    $alias = substr(trim($this->session->userdata('user')['nombre']),0,1)."".substr(trim($this->session->userdata('user')['apellido_paterno']),0,1);
    $nombreUsuario = $this->session->userdata('user')['nombre'] . " " .$this->session->userdata('user')['apellido_paterno']; 
    $usuarioSesion = $this->session->userdata('user');
    
    switch ($layout) {
        case 'sb_admin':
            $this->load->view('layouts/sb_admin2/header');
            $this->load->view('layouts/sb_admin2/navbar');
            $this->load->view('layouts/sb_admin2/sidebar');
            $this->load->view($page);
            $this->load->view('layouts/sb_admin2/footer');
            break;
        case 'flaty':
            $this->load->view('layouts/flatly/header');
            $this->load->view('layouts/flatly/navbar');
            $this->load->view('layouts/flatly/menu');
            $this->load->view($page);
            $this->load->view('layouts/flatly/footer');
        case 'bootstrap4-lm':
            $this->load->view('layouts/bootstrap4-lm/header', array('usuarioSesion' => $usuarioSesion, 'nombreUsuario' => $nombreUsuario, 'alias' => $alias));
            $this->load->view('layouts/bootstrap4-lm/sidebar');
            $this->load->view($page);
            $this->load->view('layouts/bootstrap4-lm/footer');
        default:
            break;
    }

    
?>