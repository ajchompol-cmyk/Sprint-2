<?php
/*
Plugin Name: ToCupboard Products
Plugin URI: https://tusitio.com
Description: Muestra productos desde una API externa en WordPress.
Version: 2.0
Author: Álvaro Chompol
Author URI: https://tusitio.com
License: GPL2
*/

// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;

/**
 * Shortcode principal [tc_products]
 */
function tc_products_shortcode() {

    // Intentar cargar productos desde cache
    $products = get_transient('tc_products_cache');

    if ( false === $products ) {
        $response = wp_remote_get('https://fakestoreapi.com/products', array(
            'timeout' => 20
        ));

        if (is_wp_error($response)) {
            return '<p style="color:red;">❌ Error al conectar con la API: ' . esc_html($response->get_error_message()) . '</p>';
        }

        $body = wp_remote_retrieve_body($response);

        if (empty($body)) {
            return '<p style="color:red;">❌ La API no devolvió datos.</p>';
        }

        $products = json_decode($body, true);

        if (empty($products)) {
            return '<p>⚠️ No hay productos disponibles en este momento.</p>';
        }

        // Guardar cache por 1 hora
        set_transient('tc_products_cache', $products, HOUR_IN_SECONDS);
    }

    // Construir HTML
    $html = '<div class="tc-products">';

    foreach ($products as $p) {
        $title = esc_html($p['title']);
        $price = number_format(floatval($p['price']), 2);
        $image = esc_url($p['image']);

        $html .= "
          <div class='tc-product'>
            <img src='{$image}' alt='{$title}' loading='lazy'/>
            <h4>{$title}</h4>
            <p class='tc-price'><strong>\${$price}</strong></p>
          </div>
        ";
    }

    $html .= '</div>';
    return $html;
}
add_shortcode('tc_products', 'tc_products_shortcode');

/**
 * Estilos CSS
 */
function tc_products_styles() {
    wp_add_inline_style('wp-block-library', "
        .tc-products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }
        .tc-product {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            background: #fff;
            transition: box-shadow .2s ease, transform .2s ease;
        }
        .tc-product:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-3px);
        }
        .tc-product img {
            width: 140px;
            height: 140px;
            object-fit: contain;
            margin-bottom: 12px;
        }
        .tc-product h4 {
            font-size: 1em;
            margin: 10px 0;
            color: #333;
            min-height: 48px;
        }
        .tc-price {
            color: #0073aa;
            font-size: 1.2em;
            margin-top: 8px;
        }
    ");
}
add_action('wp_enqueue_scripts', 'tc_products_styles');