<?php

$this->load->view('layouts/header');
$this->load->view('layouts/sidebar');
$this->load->view('layouts/navbar');
$this->load->view('pages/' . $pages);
$this->load->view('layouts/footer');
