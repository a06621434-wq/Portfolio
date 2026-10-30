<?php

it('renders home page successfully', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('renders projects page successfully', function () {
    $response = $this->get('/projects');
    $response->assertStatus(200);
});

it('renders skills page successfully', function () {
    $response = $this->get('/skills');
    $response->assertStatus(200);
});

it('renders services page successfully', function () {
    $response = $this->get('/services');
    $response->assertStatus(200);
});

it('renders contact page successfully', function () {
    $response = $this->get('/contact');
    $response->assertStatus(200);
});

it('renders sitemap xml successfully', function () {
    $response = $this->get('/sitemap.xml');
    $response->assertStatus(200);
});
